<?php

namespace Fabstract\Component\Serializer\Modifier;

use Fabstract\Component\Serializer\Assert;

class RenderGroupModifier extends ModifierBase
{
    /** @var string[] */
    public $render_tag_list = [];

    /**
     * RenderGroupModifier constructor.
     * @param string[] $render_tag_list
     */
    public function __construct($render_tag_list)
    {
        $this->render_tag_list = $render_tag_list;
    }

    /**
     * @param mixed $value
     * @param string[] $selected_render_tag_list
     * @return void
     */
    public function apply($value, $selected_render_tag_list = [])
    {
        Assert::isArrayOfString($selected_render_tag_list, 'parameters');

        $should_render = false;
        foreach ($selected_render_tag_list as $render_tag) {
            if (in_array($render_tag, $this->render_tag_list, true) === true) {
                $should_render = true;
                break;
            }
        }

        $this->setShouldRender($should_render);
    }
}
