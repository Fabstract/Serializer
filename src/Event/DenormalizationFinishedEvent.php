<?php


namespace Fabs\Component\Serializer\Event;


use Fabs\Component\Event\Event;
use Fabs\Component\Serializer\Normalizer\NormalizableInterface;

class DenormalizationFinishedEvent extends Event
{
    /** @var NormalizableInterface */
    private $denormalized_object = null;
    /** @var int */
    private $depth = 0;

    /**
     * DenormalizationFinishedEvent constructor.
     * @param NormalizableInterface $denormalized_object
     * @param int $depth
     */
    function __construct($denormalized_object = null, $depth = 0)
    {
        $this->denormalized_object = $denormalized_object;
        $this->depth = $depth;
    }

    /**
     * @return NormalizableInterface
     */
    public function getDenormalizedObject()
    {
        return $this->denormalized_object;
    }

    /**
     * @param NormalizableInterface $denormalized_object
     * @return DenormalizationFinishedEvent
     */
    public function setDenormalizedObject($denormalized_object)
    {
        $this->denormalized_object = $denormalized_object;
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
     * @return DenormalizationFinishedEvent
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }
}