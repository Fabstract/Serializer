<?php

namespace Fabs\Component\Serializer\Normalizer;

use Fabs\Component\Serializer\Exception\Exception;

class ArrayType extends Type
{
    public function isArray()
    {
        return true;
    }

    public function setIsArray($is_array)
    {
        throw new Exception('setIsArray method cannot be called on ' . ArrayType::class);
    }
}
