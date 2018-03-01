<?php


namespace Fabs\Component\Serializer;


use Fabs\Component\Serializer\Exception\TypeConflictException;

class Assert extends \Fabs\Component\Assert\Assert
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