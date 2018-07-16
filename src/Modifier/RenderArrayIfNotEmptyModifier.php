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
        if (is_array($value)) {
            $this->setShouldRender(count($value) > 0);
        }
    }
}
