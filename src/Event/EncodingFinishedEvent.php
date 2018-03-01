<?php


namespace Fabs\Component\Serializer\Event;


use Fabs\Component\Event\Event;

class EncodingFinishedEvent extends Event
{
    /** @var string */
    private $encoded_string = null;

    /**
     * EncodingFinishedEvent constructor.
     * @param string $encoded_string
     */
    function __construct($encoded_string = null)
    {
        $this->encoded_string = $encoded_string;
    }

    /**
     * @return string
     */
    public function getEncodedString()
    {
        return $this->encoded_string;
    }

    /**
     * @param string $encoded_string
     * @return $this
     */
    public function setEncodedString($encoded_string)
    {
        $this->encoded_string = $encoded_string;
        return $this;
    }
}