<?php

namespace Fabs\Component\Serializer\RenderModifier;

use Fabs\Component\LINQ\LINQ;
use Fabs\Component\Serializer\Assert;

class RenderModifier
{
    /**
     * @param RenderModifiable $value
     */
    public function modify($value)
    {
        Assert::isImplements($value, RenderModifiable::class, 'value');
        $this->modifyInternal($value);
    }

    /**
     * @param RenderModifiable $value
     */
    private function modifyInternal($value)
    {
        $render_modification_metadata = new RenderModificationMetadata();
        $value->configureRenderModificationMetadata($render_modification_metadata);
        if ($render_modification_metadata->isEmpty()) {
            return;
        }

        $class_name = get_class($value);
        $reflection_class = new \ReflectionClass($class_name);
        $properties = $reflection_class->getProperties();
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
            $render_modification_metadata->getTransientPropertyList();
        $render_if_not_null_property_list =
            $render_modification_metadata->getRenderIfNotNullPropertyList();
        foreach ($property_name_property_lookup as $property_name => $property) {
            if (in_array($property_name, $transient_property_list, true) === true) {
                unset($value[$property_name]);
                continue;
            }

            if (in_array($property_name, $render_if_not_null_property_list, true) === true) {
                $property_value = $property->getValue($value);
                if ($property_value === null) {
                    unset($value[$property_name]);
                    continue;
                }
            }

            $property_value = $property->getValue($value);
            if ($property_value instanceof RenderModifiable) {
                $this->modifyInternal($property_value);
            }
        }
    }
}
