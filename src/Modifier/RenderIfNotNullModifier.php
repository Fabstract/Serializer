<?php

namespace Fabstract\Component\Serializer\Modifier;

class RenderIfNotNullModifier extends ModifierBase
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
