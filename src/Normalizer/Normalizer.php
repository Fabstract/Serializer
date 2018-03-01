<?php

namespace Fabs\Component\Serializer\Normalizer;

use Fabs\Component\Serializer\Assert;
use Fabs\Component\Serializer\Exception\Exception;

class Normalizer implements NormalizerInterface
{
    #region Normalize

    /**
     * @param NormalizableInterface|\JsonSerializable $value
     * @return array
     * @throws Exception
     */
    public function normalize($value)
    {
        $allowed_type_list =
        [
            NormalizableInterface::class,
            \JsonSerializable::class
        ];
        Assert::isOneOfTypes($value, $allowed_type_list, 'value');

        if ($value instanceof NormalizableInterface) {
            return $this->normalizeNormalizableInterface($value);
        } else if ($value instanceof \JsonSerializable) {
            return $this->normalizeInternal($value->jsonSerialize());
        }

        throw new Exception('cannot normalize');
    }

    /**
     * @param mixed $value
     * @return mixed|null
     * @throws Exception
     */
    private function normalizeInternal($value)
    {
        if ($value === null) {
            return null;
        }

        $type = gettype($value);
        if ($type === 'resource' || $type === 'unknown type') {
            throw new Exception('resource or unknown type cannot normalize');
        }

        if ($type === 'object') {
            return $this->normalize($value);
        } else if ($type === 'array') {
            return $this->normalizeArray($value);
        }

        return $value;
    }

    /**
     * @param NormalizableInterface $value
     * @return array
     */
    private function normalizeNormalizableInterface($value)
    {
        $response = [];

        $reflection_class = new \ReflectionClass(get_class($value));
        $properties = $reflection_class->getProperties();
        foreach ($properties as $property) {
            $property_value = $property->getValue($value);
            $response[$property->name] = $this->normalizeInternal($property_value);
        }

        return $response;
    }


    /**
     * @param array $array
     * @return array
     */
    private function normalizeArray($array)
    {
        $response = [];

        foreach ($array as $key => $value) {
            $response[$key] = $this->normalizeInternal($value);
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
        Assert::isArray($value, 'value');
        Assert::isType($type, Type::class, 'type');

        $class_name = $type->getClassName();

        $reflection_class = new \ReflectionClass($class_name);
        if ($type->isArray()) {
            return $this->denormalizeArray($value, $type);
        }

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
                    $property_value = $this->denormalize($property_value, $property_type);
                }
                $property->setValue($instance, $property_value);
            }
        }

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
     * @return NormalizableInterface[]
     */
    private function denormalizeArray($array, $type)
    {
        $instance_list = [];

        $instance_type = clone $type;
        $instance_type->setIsArray(false);

        foreach ($array as $value) {
            $instance_list[] = $this->denormalize($value, $instance_type);
        }

        return $instance_list;
    }

    #endregion
}
