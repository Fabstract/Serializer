<?php

namespace Fabstract\Component\Serializer\RenderModifier;

class RenderIfNotNullCondition extends RenderConditionBase
{
    /**
     * @param mixed $value
     * @return void
     */
    public function apply($value)
    {
        $this->setShouldRender($value !== null);
    }
}
