<?php

namespace Fabstract\Component\Serializer\Modifier;

class RenderArrayIfNotEmptyModifier extends ModifierBase
{

    /**
     * @param mixed $value
     * @param array $selected_render_tag_list
     * @return void
     */
    public function apply($value, $selected_render_tag_list = [])
    {
        if (is_array($value) && count($value) === 0) {
            $this->setShouldRender(false);
        }
    }
}
