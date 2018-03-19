<?php

namespace Fabstract\Component\Serializer\Event;

use Fabstract\Component\Serializer\Normalizer\NormalizableInterface;

class DenormalizationFinishedEvent extends DepthAwareEvent
{
    /** @var NormalizableInterface */
    private $denormalized_object = null;

    /**
     * DenormalizationFinishedEvent constructor.
     * @param NormalizableInterface $denormalized_object
     * @param int $depth
     */
    function __construct($denormalized_object = null, $depth)
    {
        parent::__construct($depth);

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
