<?php


namespace Fabs\Component\Serializer\Event;


use Fabs\Component\Event\Event;
use Fabs\Component\Serializer\Normalizer\NormalizableInterface;

class DenormalizationFinishedEvent extends Event
{
    /** @var NormalizableInterface */
    private $denormalized_object = null;

    /**
     * DenormalizationFinishedEvent constructor.
     * @param NormalizableInterface $denormalized_object
     */
    function __construct($denormalized_object = null)
    {
        $this->denormalized_object = $denormalized_object;
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
}