<?php

namespace Fabstract\Component\Serializer\RenderModifier;

use Fabstract\Component\Serializer\Assert;

abstract class RenderConditionBase implements RenderConditionInterface
{
    /** @var bool */
    protected $should_render = true;
    /** @var bool */
    protected $should_value_update = false;
    /** @var mixed */
    protected $new_value = null;

    /**
     * @param bool $should_render
     */
    protected final function setShouldRender($should_render)
    {
        Assert::isBoolean($should_render, 'should_render');

        $this->should_render = $should_render;
    }

    /**
     * @return bool
     */
    public final function shouldRender()
    {
        return $this->should_render;
    }

    /**
     * @return bool
     */
    public final function shouldUpdateValue()
    {
        return $this->should_value_update;
    }

    /**
     * @param mixed $new_value
     */
    protected final function setNewValue($new_value)
    {
        $this->new_value = $new_value;
        $this->should_value_update = true;
    }

    /**
     * @return mixed
     */
    public final function getNewValue()
    {
        return $this->new_value;
    }
}
