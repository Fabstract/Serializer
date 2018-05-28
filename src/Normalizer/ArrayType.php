<?php

namespace Fabstract\Component\Serializer\Normalizer;

use Fabstract\Component\Serializer\Exception\Exception;

class ArrayType extends Type
{
    public function isArray()
    {
        return true;
    }

    public function setIsArray($is_array)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        throw new Exception('setIsArray method cannot be called on ' . ArrayType::class);
    }
}
