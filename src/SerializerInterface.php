<?php

namespace Fabs\Component\Serializer;

use Fabs\Component\Serializer\Encoder\EncoderInterface;
use Fabs\Component\Serializer\Normalizer\NormalizerInterface;
use Fabs\Component\Serializer\Normalizer\Type;

interface SerializerInterface
{
    /**
     * @param mixed $data
     * @return string
     */
    function serialize($data);

    /**
     * @param string $data
     * @param Type $type
     * @return mixed
     */
    function deserialize($data, $type);

    /**
     * @return NormalizerInterface
     */
    function getNormalizer();

    /**
     * @return EncoderInterface
     */
    function getEncoder();
}
