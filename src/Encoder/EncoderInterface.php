<?php

namespace Fabs\Component\Serializer\Encoder;

interface EncoderInterface
{
    /**
     * @param array $value
     * @return string
     */
    function encode($value);

    /**
     * @param string $value
     * @return array
     */
    function decode($value);
}
