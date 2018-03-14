<?php


namespace Fabs\Component\Serializer\Event;


use Fabs\Component\Event\Event;

class NormalizationFinishedEvent extends Event
{
    /** @var array */
    private $normalized_array = [];
    /** @var int */
    private $depth = 0;

    /**
     * NormalizationFinishedEvent constructor.
     * @param array $normalized_array
     * @param int $depth
     */
    function __construct($normalized_array = [], $depth = 0)
    {
        $this->normalized_array = $normalized_array;
        $this->depth = $depth;
    }

    /**
     * @return array
     */
    public function getNormalizedArray()
    {
        return $this->normalized_array;
    }

    /**
     * @param array $normalized_array
     * @return $this
     */
    public function setNormalizedArray($normalized_array)
    {
        $this->normalized_array = $normalized_array;
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
     * @return NormalizationFinishedEvent
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }
}