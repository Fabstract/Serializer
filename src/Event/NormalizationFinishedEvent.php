<?php

namespace Fabstract\Component\Serializer\Event;

class NormalizationFinishedEvent extends DepthAwareEvent
{
    /** @var array */
    private $normalized_array = [];

    /**
     * NormalizationFinishedEvent constructor.
     * @param array $normalized_array
     * @param int $depth
     */
    function __construct($normalized_array = [], $depth)
    {
        parent::__construct($depth);

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
