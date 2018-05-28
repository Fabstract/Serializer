<?php


namespace Fabstract\Component\Serializer;


use Fabstract\Component\Serializer\Exception\ParseException;
use Fabstract\Component\Serializer\Normalizer\Type;

abstract class Serializer implements SerializerInterface
{

    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data)
    {
        $normalized_data = $this->getNormalizer()->normalize($data);
        return $this->getEncoder()->encode($normalized_data);
    }

    /**
     * @param string $data
     * @param Type $type
     * @return mixed
     * @throws ParseException
     */
    public function deserialize($data, $type)
    {
        $decoded_data = $this->getEncoder()->decode($data);
        return $this->getNormalizer()->denormalize($decoded_data, $type);
    }
}