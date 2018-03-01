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
