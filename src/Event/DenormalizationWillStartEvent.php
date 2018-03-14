<?php


namespace Fabs\Component\Serializer\Event;


use Fabs\Component\Event\Event;
use Fabs\Component\Serializer\Normalizer\Type;

class DenormalizationWillStartEvent extends Event
{
    /** @var array */
    private $array_to_denormalize = [];
    /** @var Type */
    private $type_to_denormalize = null;
    /** @var int */
    private $depth = 0;

    /**
     * DenormalizationWillStartEvent constructor.
     * @param array $array_to_denormalize
     * @param Type $type_to_denormalize
     * @param int $depth
     */
    function __construct($array_to_denormalize = [], $type_to_denormalize = null, $depth = 0)
    {
        $this->array_to_denormalize = $array_to_denormalize;
        $this->type_to_denormalize = $type_to_denormalize;
        $this->depth = $depth;
    }

    /**
     * @return array
     */
    public function getArrayToDenormalize()
    {
        return $this->array_to_denormalize;
    }

    /**
     * @param array $array_to_denormalize
     * @return DenormalizationWillStartEvent
     */
    public function setArrayToDenormalize($array_to_denormalize)
    {
        $this->array_to_denormalize = $array_to_denormalize;
        return $this;
    }

    /**
     * @return Type
     */
    public function getTypeToDenormalize()
    {
        return $this->type_to_denormalize;
    }

    /**
     * @param Type $type_to_denormalize
     * @return DenormalizationWillStartEvent
     */
    public function setTypeToDenormalize($type_to_denormalize)
    {
        $this->type_to_denormalize = $type_to_denormalize;
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
     * @return DenormalizationWillStartEvent
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }
}