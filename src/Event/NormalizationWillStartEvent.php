<?php

namespace Fabstract\Component\Serializer\Event;

class NormalizationWillStartEvent extends DepthAwareEvent
{
    /** @var mixed */
    private $object_to_normalize = null;

    /**
     * NormalizationWillStartEvent constructor.
     * @param mixed $object_to_normalize
     * @param int $depth
     */
    function __construct($object_to_normalize = null, $depth)
    {
        parent::__construct($depth);

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
