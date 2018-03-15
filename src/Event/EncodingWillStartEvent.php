<?php

namespace Fabs\Component\Serializer\Event;

use Fabs\Component\Event\Event;

class EncodingWillStartEvent extends Event
{
    /** @var array */
    private $array_to_encode = [];

    /**
     * EncodingWillStartEvent constructor.
     * @param array $array_to_encode
     */
    function __construct($array_to_encode = [])
    {
        $this->array_to_encode = $array_to_encode;
    }

    /**
     * @return array
     */
    public function getArrayToEncode()
    {
        return $this->array_to_encode;
    }

    /**
     * @param array $array_to_encode
     * @return $this
     */
    public function setArrayToEncode($array_to_encode)
    {
        $this->array_to_encode = $array_to_encode;
        return $this;
    }
}
