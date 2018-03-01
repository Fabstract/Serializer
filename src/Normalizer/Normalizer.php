<?php

namespace Fabs\Component\Serializer\Normalizer;

use Fabs\Component\Assert\Assert;
use Fabs\Component\Serializer\Exception\Exception;

class Normalizer implements NormalizerInterface
{
    /**
     * @param NormalizableInterface $value
     * @return array
     * @throws Exception
     */
    function normalize($value)
    {
        return $this->normalizeNormalizableInterface($value);
    }

    /**
     * @param array $value
     * @param Type $type
     * @return mixed
     */
    function denormalize($value, $type)
    {
        // TODO: Implement denormalize() method.
    }

    /**
     * @param NormalizableInterface $value
     * @return array
     */
    private function normalizeNormalizableInterface($value)
    {
        Assert::assertType($value, NormalizableInterface::class, 'value');

        $response = [];
        $reflection_class = new \ReflectionClass(get_class($value));

        $properties = $reflection_class->getProperties();
        foreach ($properties as $property) {
            $property_value = $property->getValue($value);
            $response[$property->name] = $this->normalizeInternal($property_value);
        }

        return $response;
    }

    /**
     * @param mixed $property_value
     * @return mixed|null
     * @throws Exception
     */
    private function normalizeInternal($property_value)
    {
        if ($property_value === null) {
            return null;
        }

        $type = gettype($property_value);
        if ($type === 'resource' || $type === 'unknown type') {
            throw new Exception('resource or unknown type cannot normalize');
        }

        if ($type === 'object') {
            return $this->normalizeObject($property_value);
        }

        return $property_value;
    }

    /**
     * @param mixed $property_value
     * @return mixed
     * @throws Exception
     */
    private function normalizeObject($property_value)
    {
        if ($property_value instanceof NormalizableInterface) {
            return $this->normalizeNormalizableInterface($property_value);
        } else if ($property_value instanceof \JsonSerializable) {
            return $property_value->jsonSerialize();
        }

        throw new Exception('cannot denormalize');
    }
}
