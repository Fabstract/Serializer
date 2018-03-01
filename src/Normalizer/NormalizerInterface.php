<?php

namespace Fabs\Component\Serializer\Normalizer;

interface NormalizerInterface
{
    /**
     * @param NormalizableInterface $value
     * @return array
     */
    function normalize($value);

    /**
     * @param $value
     * @param Type $type
     * @return mixed
     */
    function denormalize($value, $type);
}
