<?php

namespace Fabstract\Component\Serializer\Encoder;

use Fabstract\Component\Serializer\Exception\ParseException;

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
