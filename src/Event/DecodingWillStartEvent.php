<?php

namespace Fabs\Component\Serializer\Event;

use Fabs\Component\Event\Event;

class DecodingWillStartEvent extends Event
{
    /** @var mixed */
    private $object_to_decode = null;

    /**
     * DecodingWillStartEvent constructor.
     * @param mixed $object_to_decode
     */
    function __construct($object_to_decode = null)
    {
        $this->object_to_decode = $object_to_decode;
    }

    /**
     * @return mixed
     */
    public function getObjectToDecode()
    {
        return $this->object_to_decode;
    }

    /**
     * @param mixed $object_to_decode
     * @return $this
     */
    public function setObjectToDecode($object_to_decode)
    {
        $this->object_to_decode = $object_to_decode;
        return $this;
    }
}
