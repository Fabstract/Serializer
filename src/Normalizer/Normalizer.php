<?php

namespace Fabstract\Component\Serializer\Normalizer;

use Fabstract\Component\Serializer\Assert;
use Fabstract\Component\Serializer\Event\DenormalizationFinishedEvent;
use Fabstract\Component\Serializer\Event\DenormalizationWillStartEvent;
use Fabstract\Component\Serializer\Event\NormalizationFinishedEvent;
use Fabstract\Component\Serializer\Event\NormalizationWillStartEvent;
use Fabstract\Component\Serializer\Exception\Exception;
use Fabstract\Component\Serializer\Modifier\RenderGroupModifier;

class Normalizer extends EventEmitterNormalizer
{
    private $selected_render_tag_list = [];

    /**
     * @param string $render_tag
     */
    public function setRenderTag($render_tag)
    {
        Assert::isString($render_tag, 'render_tag');

        $this->selected_render_tag_list[] = $render_tag;
    }

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

        if (is_array($value) === true) {
            $normalized_array = [];
            foreach ($value as $key => $sub_value) {
                $normalized_array[$key] =
                    $this->normalizeInternal($sub_value, $depth + 1);
            }

            $this->emit(new NormalizationFinishedEvent($normalized_array, $depth));

            return $normalized_array;
        }

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
        $properties = $reflection_class->getProperties(\ReflectionProperty::IS_PUBLIC);
        $normalization_metadata = $this->getNormalizationMetadata($value);
        foreach ($properties as $property) {
            $property_name = $property->getName();
            $property_value = $property->getValue($value);
            $modifier_list = $normalization_metadata->getPropertyModifierList($property_name);
            foreach ($modifier_list as $modifier) {
                if ($modifier instanceof RenderGroupModifier) {
                    $modifier->apply($property_value, $this->selected_render_tag_list);
                } else {
                    $modifier->apply($property_value);
                }

                if ($modifier->shouldUpdateValue()) {
                    $value = $modifier->getNewValue();
                }

                if ($modifier->shouldRender() === false) {
                    continue 2;
                }
            }

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

                $normalization_metadata = $this->getNormalizationMetadata($instance);

                $properties = $reflection_class->getProperties(\ReflectionProperty::IS_PUBLIC);
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
     * @return NormalizationMetadata
     */
    private function getNormalizationMetadata($instance)
    {
        Assert::isImplements($instance, NormalizableInterface::class, 'instance');

        $class_name = get_class($instance);
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
