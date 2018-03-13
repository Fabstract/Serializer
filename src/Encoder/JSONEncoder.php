<?php

namespace Fabs\Component\Serializer\Encoder;

use Fabs\Component\Serializer\Assert;
use Fabs\Component\Serializer\Exception\JSONParseException;

class JSONEncoder implements EncoderInterface
{

    /** @var int[] */
    private $encode_options = [];

    /** @var bool */
    private $decode_assoc = false;
    /** @var int */
    private $decode_depth = 512;
    /** @var int[] */
    private $decode_options = [];

    /**
     * @param int $option
     * @return $this
     */
    public function addEncodeOption($option)
    {
        Assert::isInt($option);

        if (in_array($option, $this->encode_options, true) === false) {
            $this->encode_options[] = $option;
        }

        return $this;
    }

    /**
     * @param bool $decode_assoc
     * @return JSONEncoder
     */
    public function setDecodeAssoc($decode_assoc)
    {
        Assert::isBoolean($decode_assoc, 'assoc');

        $this->decode_assoc = $decode_assoc;
        return $this;
    }

    /**
     * @return bool
     */
    public function getDecodeAssoc()
    {
        return $this->decode_assoc;
    }

    /**
     * @param int $decode_depth
     * @return JSONEncoder
     */
    public function setDecodeDepth($decode_depth)
    {
        Assert::isPositive($decode_depth, 'depth');

        $this->decode_depth = $decode_depth;
        return $this;
    }

    /**
     * @return int
     */
    public function getDecodeDepth()
    {
        return $this->decode_depth;
    }

    /**
     * @param int $option
     * @return $this
     */
    public function addDecodeOption($option)
    {
        Assert::isInt($option);

        if (in_array($option, $this->decode_options, true) === false) {
            $this->decode_options[] = $option;
        }

        return $this;
    }

    /**
     * @param array $value
     * @return string
     */
    public function encode($value)
    {
        Assert::isArray($value);

        $encode_options_combined = $this->combineOptions($this->encode_options);
        return json_encode($value, $encode_options_combined);
    }

    /**
     * @param string $value
     * @return array
     * @throws JSONParseException
     */
    public function decode($value)
    {
        Assert::isString($value);

        $is_assoc = $this->getDecodeAssoc();
        $depth = $this->getDecodeDepth();
        $decode_options_combined = $this->combineOptions($this->decode_options);

        $decoded = json_decode($value, $is_assoc, $depth, $decode_options_combined);
        $json_last_error = json_last_error();
        if ($json_last_error !== JSON_ERROR_NONE) {
            $exception_message
                = sprintf('Cannot decode string to JSON. Error %s error_message %s',
                $json_last_error,
                json_last_error_msg());
            throw new JSONParseException($exception_message);
        }

        return $decoded;
    }

    /**
     * @param array $options
     * @return int
     */
    private function combineOptions($options)
    {
        return array_reduce($options, function ($a, $b) {
            return $a | $b;
        }, 0);
    }
}
