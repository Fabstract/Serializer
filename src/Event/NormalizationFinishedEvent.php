<?php


namespace Fabs\Component\Serializer\Event;


use Fabs\Component\Event\Event;

class NormalizationFinishedEvent extends Event
{
    /** @var array */
    private $normalized_array = [];

    /**
     * NormalizationFinishedEvent constructor.
     * @param array $normalized_array
     */
    function __construct($normalized_array = [])
    {
        $this->normalized_array = $normalized_array;
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
}