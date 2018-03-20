<?php

namespace Fabstract\Component\Serializer\RenderModifier;

use Fabstract\Component\LINQ\LINQ;
use Fabstract\Component\Serializer\Assert;
use Fabstract\Component\Serializer\Normalizer\NormalizableInterface;
use Fabstract\Component\Serializer\Normalizer\NormalizationMetadata;

/**
 * Class RenderModifier
 * @package Fabstract\Component\Serializer\RenderModifier
 *
 * @deprecated this class is evil
 */
class RenderModifier
{
    /**
     * @param mixed $value
     * @param NormalizationMetadata $normalization_metadata
     */
    public function modify($value, $normalization_metadata)
    {
        Assert::isType($normalization_metadata, NormalizationMetadata::class, 'normalization_metadata');

        $this->modifyInternal($value, $normalization_metadata);
    }

    /**
     * @param NormalizableInterface $value
     * @param NormalizationMetadata $normalization_metadata
     */
    private function modifyInternal($value, $normalization_metadata)
    {
        if ($normalization_metadata->isRenderModificationMetadataEmpty() === true) {
            return;
        }

        $class_name = get_class($value);
        $reflection_class = new \ReflectionClass($class_name);
        $properties = $reflection_class->getProperties(\ReflectionProperty::IS_PUBLIC);
        /** @var \ReflectionProperty[] $property_name_property_lookup */
        $property_name_property_lookup = LINQ::from($properties)
            ->map(function ($property) {
                /** @var \ReflectionProperty $property */
                return $property->getName();
            }, function ($property) {
                return $property;
            })
            ->toArray();

        $transient_property_list =
            $normalization_metadata->getTransientPropertyList();
        $render_if_not_null_property_list =
            $normalization_metadata->getRenderIfNotNullPropertyList();
        foreach ($property_name_property_lookup as $property_name => $property) {
            if (in_array($property_name, $transient_property_list, true) === true) {
                unset($value->$property_name);
                continue;
            }

            if (in_array($property_name, $render_if_not_null_property_list, true) === true) {
                $property_value = $property->getValue($value);
                if ($property_value === null) {
                    unset($value->$property_name);
                    continue;
                }
            }
        }
    }
}
