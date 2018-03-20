<?php

namespace Fabstract\Component\Serializer\Modifier;

class RenderNeverModifier extends ModifierBase
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
