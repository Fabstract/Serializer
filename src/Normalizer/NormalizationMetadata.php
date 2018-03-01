<?php

namespace Fabs\Component\Serializer\Normalizer;

use Fabs\Component\Assert\Assert;
use Traversable;

class NormalizationMetadata implements \IteratorAggregate
{
    /** @var Type[] */
    private $type_lookup = [];

    /**
     * @param string $property_name
     * @param Type $type
     * @return $this
     */
    public function registerType($property_name, $type)
    {
        Assert::assertNonEmptyString($property_name, false, 'property_name');
        Assert::assertType($type, Type::class, 'type');

        $this->type_lookup[$property_name] = $type;
        return $this;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->type_lookup);
    }
}
