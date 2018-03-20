<?php

namespace Fabstract\Component\Serializer\RenderModifier;

interface RenderConditionInterface
{
    /**
     * @param mixed $value
     * @return void
     */
    public function apply($value);

    /**
     * @return bool
     */
    public function shouldRender();

    /**
     * @return bool
     */
    public function shouldUpdateValue();

    /**
     * @return mixed
     */
    public function getNewValue();
}
