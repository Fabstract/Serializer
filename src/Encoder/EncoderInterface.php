<?php

namespace Fabs\Component\Serializer\Encoder;

use Fabs\Component\Serializer\Exception\ParseException;

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
     * @throws ParseException
     */
    function decode($value);
}
