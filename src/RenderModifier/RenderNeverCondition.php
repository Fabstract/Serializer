<?php

namespace Fabstract\Component\Serializer\RenderModifier;

class RenderNeverCondition extends RenderConditionBase
{
    /**
     * @param mixed $value
     * @return void
     */
    public function apply($value)
    {
        $this->setShouldRender(false);
    }
}
