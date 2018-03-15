<?php

namespace Fabs\Component\Serializer\Normalizer;

use Fabs\Component\Serializer\Assert;
use Fabs\Component\Serializer\Event\DenormalizationFinishedEvent;
use Fabs\Component\Serializer\Event\DenormalizationWillStartEvent;
use Fabs\Component\Serializer\Event\NormalizationFinishedEvent;
use Fabs\Component\Serializer\Event\NormalizationWillStartEvent;
use Fabs\Component\Serializer\Exception\Exception;

class Normalizer extends EventEmitterNormalizer
{
    #region Normalize

    public function normalize($value)
    {
        return $this->normalizeInternal($value, 0);
    }

    /**
     * @param NormalizableInterface|\JsonSerializable $value
     * @param int $depth
     * @return array
     * @throws Exception
     */
    private function normalizeInternal($value, $depth)
    {
        $this->emit(new NormalizationWillStartEvent($value, $depth));

        $allowed_type_list =
            [
                NormalizableInterface::class,
                \JsonSerializable::class
            ];
        Assert::isOneOfTypes($value, $allowed_type_list, 'value');

        if ($value instanceof NormalizableInterface) {
            $normalized = $this->normalizeNormalizableInterface($value, $depth);
        } else if ($value instanceof \JsonSerializable) {
            $normalized = $this->normalizeValue($value->jsonSerialize(), $depth);
        } else {
            throw new Exception('cannot normalize');
        }

        $this->emit(new NormalizationFinishedEvent($normalized, $depth));

        return $normalized;
    }

    /**
     * @param mixed $value
     * @param int $depth
     * @return mixed|null
     * @throws Exception
     */
    private function normalizeValue($value, $depth)
    {
        if ($value === null) {
            return null;
        }

        $type = gettype($value);
        if ($type === 'resource' || $type === 'unknown type') {
            throw new Exception('resource or unknown type cannot normalize');
        }

        if ($type === 'object') {
            return $this->normalizeInternal($value, $depth + 1);
        } else if ($type === 'array') {
            return $this->normalizeArray($value, $depth + 1);
        }

        return $value;
    }

    /**
     * @param NormalizableInterface $value
     * @param int $depth
     * @return array
     */
    private function normalizeNormalizableInterface($value, $depth)
    {
        $response = [];

        $reflection_class = new \ReflectionClass(get_class($value));
        $properties = $reflection_class->getProperties();
        foreach ($properties as $property) {
            $property_value = $property->getValue($value);
            $response[$property->name] = $this->normalizeValue($property_value, $depth);
        }

        return $response;
    }


    /**
     * @param array $array
     * @param int $depth
     * @return array
     */
    private function normalizeArray($array, $depth)
    {
        $response = [];

        foreach ($array as $key => $value) {
            $response[$key] = $this->normalizeValue($value, $depth);
        }

        return $response;
    }

    #endregion

    #region Denormalize

    /**
     * @var NormalizationMetadata[]
     */
    private $normalization_metadata_lookup = [];

    /**
     * @param array $value
     * @param Type $type
     * @return NormalizableInterface|NormalizableInterface[]
     */
    public function denormalize($value, $type)
    {
        return $this->denormalizeInternal($value, $type, 0);
    }

    /**
     * @param array $value
     * @param Type $type
     * @param int $depth
     * @return NormalizableInterface|NormalizableInterface[]
     */
    private function denormalizeInternal($value, $type, $depth)
    {
        $this->emit(new DenormalizationWillStartEvent($value, $type, $depth));

        if ($value !== null) {
            Assert::isArray($value, 'value');
            Assert::isType($type, Type::class, 'type');

            $class_name = $type->getClassName();

            $reflection_class = new \ReflectionClass($class_name);
            if ($type->isArray()) {
                $instance = $this->denormalizeArray($value, $type, $depth + 1);
            } else {
                /** @var NormalizableInterface $instance */
                $instance = $reflection_class->newInstance();
                Assert::isType($instance, NormalizableInterface::class, 'type.class_name');

                $normalization_metadata = $this->getNormalizationMetadata($instance, $class_name);

                $properties = $reflection_class->getProperties();
                foreach ($properties as $property) {
                    $property_name = $property->getName();

                    if (array_key_exists($property_name, $value) === true) {
                        $property_value = $value[$property_name];

                        if (
                            $normalization_metadata->offsetExists($property_name) === true
                        ) {
                            $property_type = $normalization_metadata[$property_name];
                            $property_value = $this->denormalizeInternal($property_value, $property_type, $depth + 1);
                        }
                        $property->setValue($instance, $property_value);
                    }
                }
            }
        } else {
            $instance = null;
        }

        $this->emit(new DenormalizationFinishedEvent($instance, $depth));

        return $instance;
    }

    /**
     * @param NormalizableInterface $instance
     * @param string $class_name
     * @return NormalizationMetadata
     */
    private function getNormalizationMetadata($instance, $class_name)
    {
        if (array_key_exists($class_name, $this->normalization_metadata_lookup) === false) {
            $normalization_metadata = new NormalizationMetadata();
            $instance->configureNormalizationMetadata($normalization_metadata);
            $this->normalization_metadata_lookup[$class_name] = $normalization_metadata;
        }

        return $this->normalization_metadata_lookup[$class_name];
    }

    /**
     * @param array $array
     * @param Type $type
     * @param int $depth
     * @return NormalizableInterface[]
     */
    private function denormalizeArray($array, $type, $depth)
    {
        $instance_list = [];

        $instance_type = Type::createNew($type);
        $instance_type->setIsArray(false);

        foreach ($array as $value) {
            $instance_list[] = $this->denormalizeInternal($value, $instance_type, $depth);
        }

        return $instance_list;
    }
}
