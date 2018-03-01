<?php

namespace Fabs\Component\Serializer;

use Fabs\Component\Event\EventEmitter;
use Fabs\Component\Serializer\Encoder\EncoderInterface;
use Fabs\Component\Serializer\Normalizer\NormalizerInterface;
use Fabs\Component\Serializer\Normalizer\Type;

class JSONSerializer extends EventEmitter implements SerializerInterface
{

    /**
     * @param mixed $data
     * @return string
     */
    function serialize($data)
    {
        // TODO: Implement serialize() method.
    }

    /**
     * @param string $data
     * @param Type $type
     * @return mixed
     */
    function deserialize($data, $type)
    {
        // TODO: Implement deserialize() method.
    }

    /**
     * @return NormalizerInterface
     */
    function getNormalizer()
    {
        // TODO: Implement getNormalizer() method.
    }

    /**
     * @return EncoderInterface
     */
    function getEncoder()
    {
        // TODO: Implement getEncoder() method.
    }
}
