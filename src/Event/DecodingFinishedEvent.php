<?php


namespace Fabs\Component\Serializer\Event;


use Fabs\Component\Event\Event;

class DecodingFinishedEvent extends Event
{
    /** @var array */
    private $decoded_array = [];

    /**
     * DecodingFinishedEvent constructor.
     * @param array $decoded_array
     */
    function __construct($decoded_array = [])
    {
        $this->decoded_array = $decoded_array;
    }

    /**
     * @return array
     */
    public function getDecodedArray()
    {
        return $this->decoded_array;
    }

    /**
     * @param array $decoded_array
     * @return DecodingFinishedEvent
     */
    public function setDecodedArray($decoded_array)
    {
        $this->decoded_array = $decoded_array;
        return $this;
    }
}