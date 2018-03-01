<?php

namespace Fabs\Component\Serializer\Normalizer;

use Fabs\Component\Assert\Assert;

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

    public function __clone()
    {
        $type = new Type($this->getClassName());
        $type->is_array = $this->is_array;
        return $type;
    }
}
