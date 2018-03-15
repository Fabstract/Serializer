<?php

namespace Fabs\Component\Serializer\Event;

use Fabs\Component\Event\Event;

class NormalizationWillStartEvent extends Event
{
    /** @var mixed */
    private $object_to_normalize = null;
    /** @var int */
    private $depth = 0;

    /**
     * NormalizationWillStartEvent constructor.
     * @param mixed $object_to_normalize
     * @param int $depth
     */
    function __construct($object_to_normalize = null, $depth = 0)
    {
        $this->object_to_normalize = $object_to_normalize;
        $this->depth = $depth;
    }

    /**
     * @return mixed
     */
    public function getObjectToNormalize()
    {
        return $this->object_to_normalize;
    }

    /**
     * @param mixed $normalizable
     * @return $this
     */
    public function setObjectToNormalize($normalizable)
    {
        $this->object_to_normalize = $normalizable;
        return $this;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return NormalizationWillStartEvent
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }
}