<?php

namespace Fabstract\Component\Serializer;

use Fabstract\Component\Serializer\Exception\TypeConflictException;

class Assert extends \Fabstract\Component\Assert\Assert
{

    /**
     * @param string $name
     * @param string $expected
     * @param string $given
     * @return TypeConflictException
     */
    protected static function generateException($name, $expected, $given)
    {
        $exception = parent::generateException($name, $expected, $given);
        return new TypeConflictException(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }
}
