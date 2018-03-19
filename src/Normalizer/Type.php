<?php

namespace Fabstract\Component\Serializer\Normalizer;

use Fabstract\Component\Serializer\Assert;

class Type
{
    /** @var string */
    private $class_name = null;
    /** @var bool */
    private $is_array = false;

    /**
     * Type constructor.
     * @param string $class_name
     */
    public function __construct($class_name)
    {
        Assert::isClassExists($class_name, 'class_name');
        $this->class_name = $class_name;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->class_name;
    }

    /**
     * @return bool
     */
    public function isArray()
    {
        return $this->is_array;
    }

    /**
     * @param bool $is_array
     * @return $this
     */
    public function setIsArray($is_array)
    {
        $this->is_array = $is_array;
        return $this;
    }

    /**
     * @param Type $type
     * @return Type
     */
    public static function createNew($type)
    {
        Assert::isType($type, Type::class, 'type');

        $new_type = new Type($type->getClassName());
        $new_type->is_array = $type->is_array;
        return $new_type;
    }
}
