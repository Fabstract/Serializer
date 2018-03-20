<?php

namespace Fabstract\Component\Serializer\Modifier;

use Fabstract\Component\Serializer\Assert;

class RenderModificationMetadata
{
    /** @var ModifierInterface[][] */
    private $property_modifier_list_lookup = [];

    /**
     * @param string $property_name
     * @return RenderModificationMetadata
     */
    public function setAsTransient($property_name)
    {
        return $this->setModifier($property_name, new RenderNeverModifier());
    }

    /**
     * @param string $property_name
     * @return RenderModificationMetadata
     */
    public function setRenderIfNotNull($property_name)
    {
        return $this->setModifier($property_name, new RenderIfNotNullModifier());
    }

    /**
     * @param string $property_name
     * @param ModifierInterface $modifier
     * @return RenderModificationMetadata
     */
    public function setModifier($property_name, $modifier)
    {
        Assert::isString($property_name, 'property_name');
        Assert::isImplements(
            $modifier,
            ModifierInterface::class,
            'modifier'
        );

        $this->property_modifier_list_lookup[$property_name][] =
            $modifier;
        return $this;
    }

    /**
     * @param string $property_name
     * @return ModifierInterface[]
     */
    public function getPropertyModifierList($property_name)
    {
        Assert::isString($property_name, 'property_name');

        if (array_key_exists($property_name, $this->property_modifier_list_lookup) !== true) {
            return [];
        }

        return $this->property_modifier_list_lookup[$property_name];
    }
}
