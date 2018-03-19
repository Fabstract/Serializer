<?php

namespace Fabstract\Component\Serializer\RenderModifier;

use Fabstract\Component\Serializer\Assert;

class RenderModificationMetadata
{
    /** @var string[] */
    private $transient_property_list = [];
    /** @var string[] */
    private $render_if_not_null_property_list = [];

    /**
     * @param string $property_name
     * @return RenderModificationMetadata
     */
    public function setAsTransient($property_name)
    {
        Assert::isString($property_name, 'property_name');

        $this->transient_property_list[] = $property_name;
        return $this;
    }

    /**
     * @param string $property_name
     * @return RenderModificationMetadata
     */
    public function setRenderIfNotNull($property_name)
    {
        Assert::isString($property_name, 'property_name');

        $this->render_if_not_null_property_list[] = $property_name;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTransientPropertyList()
    {
        return $this->transient_property_list;
    }

    /**
     * @return string[]
     */
    public function getRenderIfNotNullPropertyList()
    {
        return $this->render_if_not_null_property_list;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->transient_property_list) === 0 &&
            count($this->render_if_not_null_property_list) === 0;
    }
}
