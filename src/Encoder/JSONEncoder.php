<?php

namespace Fabstract\Component\Serializer\Encoder;

use Fabstract\Component\Serializer\Assert;
use Fabstract\Component\Serializer\Event\DecodingFinishedEvent;
use Fabstract\Component\Serializer\Event\DecodingWillStartEvent;
use Fabstract\Component\Serializer\Event\EncodingFinishedEvent;
use Fabstract\Component\Serializer\Event\EncodingWillStartEvent;
use Fabstract\Component\Serializer\Exception\ParseException;

class JSONEncoder extends EventEmitterEncoder
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

        $this->emit(new EncodingWillStartEvent($value));

        $encode_options_combined = $this->combineOptions($this->encode_options);
        $encoded = json_encode($value, $encode_options_combined);

        $this->emit(new EncodingFinishedEvent($encoded));

        return $encoded;
    }

    /**
     * @param string $value
     * @return array
     * @throws ParseException
     */
    public function decode($value)
    {
        Assert::isString($value);

        $this->emit(new DecodingWillStartEvent($value));

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
            throw new ParseException($exception_message);
        }

        $this->emit(new DecodingFinishedEvent($decoded));

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
