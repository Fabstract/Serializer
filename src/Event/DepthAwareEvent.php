<?php

namespace Fabstract\Component\Serializer\Event;

use Fabstract\Component\Event\Event;

abstract class DepthAwareEvent extends Event
{
    /** @var int */
    private $depth = 0;

    /**
     * DepthAwareEvent constructor.
     * @param int $depth
     */
    function __construct($depth = 0)
    {
        $this->depth = $depth;
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
     * @return static
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }
}
