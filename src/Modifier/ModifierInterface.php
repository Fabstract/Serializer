<?php

namespace Fabstract\Component\Serializer\Modifier;

interface ModifierInterface
{
    /**
     * @param mixed $value
     * @param array $selected_render_tag_list
     * @return void
     */
    public function apply($value, $selected_render_tag_list = []);

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
