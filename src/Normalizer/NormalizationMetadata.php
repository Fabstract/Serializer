<?php

namespace Fabstract\Component\Serializer\Normalizer;

use Fabstract\Component\Serializer\Assert;
use Fabstract\Component\Serializer\RenderModifier\RenderModificationMetadata;

class NormalizationMetadata implements \ArrayAccess
{
    /** @var Type[] */
    private $type_lookup = [];
    /** @var RenderModificationMetadata */
    private $render_modification_metadata = null;

    function __construct()
    {
        $this->render_modification_metadata = new RenderModificationMetadata();
    }

    /**
     * @param string $property_name
     * @return NormalizationMetadata
     */
    public function setAsTransient($property_name)
    {
        $this->render_modification_metadata->setAsTransient($property_name);
        return $this;
    }

    /**
     * @param string $property_name
     * @return NormalizationMetadata
     */
    public function setRenderIfNotNull($property_name)
    {
        $this->render_modification_metadata->setRenderIfNotNull($property_name);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTransientPropertyList()
    {
        return $this->render_modification_metadata->getTransientPropertyList();
    }

    /**
     * @return string[]
     */
    public function getRenderIfNotNullPropertyList()
    {
        return $this->render_modification_metadata->getRenderIfNotNullPropertyList();
    }

    /**
     * @return bool
     */
    public function isRenderModificationMetadataEmpty()
    {
        return $this->render_modification_metadata->isEmpty();
    }

    /**
     * @param string $property_name
     * @param Type $type
     * @return $this
     */
    public function registerType($property_name, $type)
    {
        Assert::isNotEmptyString($property_name, false, 'property_name');
        Assert::isType($type, Type::class, 'type');

        $this->type_lookup[$property_name] = $type;
        return $this;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param string $property_name <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($property_name)
    {
        Assert::isNotEmptyString($property_name, false, 'property_name');
        return array_key_exists($property_name, $this->type_lookup);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param string $property_name <p>
     * The offset to retrieve.
     * </p>
     * @return Type Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($property_name)
    {
        Assert::isNotEmptyString($property_name, false, 'property_name');
        return $this->type_lookup[$property_name];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param string $property_name <p>
     * The offset to assign the value to.
     * </p>
     * @param Type $type <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($property_name, $type)
    {
        Assert::isNotEmptyString($property_name, false, 'property_name');
        Assert::isType($type, Type::class, 'type');
        $this->type_lookup[$property_name] = $type;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param string $property_name <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($property_name)
    {
        Assert::isNotEmptyString($property_name, false, 'property_name');
        unset($this->type_lookup[$property_name]);
    }
}
