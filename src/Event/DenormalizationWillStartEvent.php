<?php

namespace Fabstract\Component\Serializer\Event;

use Fabstract\Component\Serializer\Normalizer\Type;

class DenormalizationWillStartEvent extends DepthAwareEvent
{
    /** @var array */
    private $array_to_denormalize = [];
    /** @var Type */
    private $type_to_denormalize = null;

    /**
     * DenormalizationWillStartEvent constructor.
     * @param array $array_to_denormalize
     * @param Type $type_to_denormalize
     * @param int $depth
     */
    function __construct($array_to_denormalize = [], $type_to_denormalize = null, $depth)
    {
        parent::__construct($depth);

        $this->array_to_denormalize = $array_to_denormalize;
        $this->type_to_denormalize = $type_to_denormalize;
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
}
