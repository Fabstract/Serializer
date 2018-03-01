<?php

namespace Fabs\Component\Serializer\Event;

use Fabs\Component\Event\Event;

class NormalizationWillStartEvent extends Event
{
    /** @var mixed */
    private $object_to_normalize = null;

    /**
     * NormalizationWillStartEvent constructor.
     * @param mixed $object_to_normalize
     */
    function __construct($object_to_normalize = null)
    {
        $this->object_to_normalize = $object_to_normalize;
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
}