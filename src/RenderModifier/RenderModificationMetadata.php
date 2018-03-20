<?php

namespace Fabstract\Component\Serializer\RenderModifier;

use Fabstract\Component\Serializer\Assert;

class RenderModificationMetadata
{
    /** @var RenderConditionInterface[][] */
    private $property_condition_list_lookup = [];

    /**
     * @param string $property_name
     * @return RenderModificationMetadata
     */
    public function setAsTransient($property_name)
    {
        return $this->setRenderCondition($property_name, new RenderNeverCondition());
    }

    /**
     * @param string $property_name
     * @return RenderModificationMetadata
     */
    public function setRenderIfNotNull($property_name)
    {
        return $this->setRenderCondition($property_name, new RenderIfNotNullCondition());
    }

    /**
     * @param string $property_name
     * @param RenderConditionInterface $render_condition
     * @return RenderModificationMetadata
     */
    public function setRenderCondition($property_name, $render_condition)
    {
        Assert::isString($property_name, 'property_name');
        Assert::isImplements(
            $render_condition,
            RenderConditionInterface::class,
            'render_condition'
        );

        $this->property_condition_list_lookup[$property_name] =
            $render_condition;
        return $this;
    }

    /**
     * @param string $property_name
     * @return RenderConditionInterface[]
     */
    public function getPropertyConditionList($property_name)
    {
        Assert::isString($property_name, 'property_name');

        if (array_key_exists($property_name, $this->property_condition_list_lookup) !== true) {
            return [];
        }

        return $this->property_condition_list_lookup[$property_name];
    }
}
