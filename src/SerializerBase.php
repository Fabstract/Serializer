<?php

namespace Fabs\Component\Serializer;

use Fabs\Component\Serializer\Normalizer\Type;

abstract class SerializerBase implements SerializerInterface
{
    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data)
    {
        $normalized_data = $this->getNormalizer()->normalize($data);
        $encoded = $this->getEncoder()->encode($normalized_data);

        return $encoded;
    }

    /**
     * @param string $data
     * @param Type $type
     * @return mixed
     */
    public function deserialize($data, $type)
    {
        $decoded_array = $this->getEncoder()->decode($data);
        $denormalized = $this->getNormalizer()->denormalize($decoded_array, $type);

        return $denormalized;
    }
}
