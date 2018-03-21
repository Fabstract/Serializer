<?php

namespace Fabstract\Component\Serializer\Modifier;

use Fabstract\Component\Serializer\Assert;

class ModificationMetadata
{
    /** @var ModifierInterface[][] */
    private $property_modifier_list_lookup = [];

    /**
     * @param string $property_name
     * @return ModificationMetadata
     */
    public function setAsTransient($property_name)
    {
        return $this->setModifier($property_name, new RenderNeverModifier());
    }

    /**
     * @param string $property_name
     * @return ModificationMetadata
     */
    public function setRenderIfNotNull($property_name)
    {
        return $this->setModifier($property_name, new RenderIfNotNullModifier());
    }

    /**
     * @param string $property_name
     * @param string[] $render_tag_list
     * @return ModificationMetadata
     */
    public function setRenderTagList($property_name, $render_tag_list)
    {
        Assert::isArrayOfString($render_tag_list, 'render_tag_list');

        return $this->setModifier($property_name, new RenderGroupModifier($render_tag_list));
    }

    /**
     * @param string $property_name
     * @param ModifierInterface $modifier
     * @return ModificationMetadata
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
