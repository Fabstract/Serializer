<?php

namespace Fabs\Component\Serializer\Normalizer;

interface NormalizerInterface
{
    /**
     * @param NormalizableInterface $value
     * @return array
     */
    public function normalize($value);

    /**
     * @param array $value
     * @param Type $type
     * @return mixed
     */
    public function denormalize($value, $type);
}
