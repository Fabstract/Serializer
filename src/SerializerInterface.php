<?php

namespace Fabstract\Component\Serializer;

use Fabstract\Component\Serializer\Encoder\EncoderInterface;
use Fabstract\Component\Serializer\Normalizer\NormalizerInterface;
use Fabstract\Component\Serializer\Normalizer\Type;

interface SerializerInterface
{
    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data);

    /**
     * @param string $data
     * @param Type $type
     * @return mixed
     */
    public function deserialize($data, $type);

    /**
     * @return NormalizerInterface
     */
    public function getNormalizer();

    /**
     * @return EncoderInterface
     */
    public function getEncoder();
}
