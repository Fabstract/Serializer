<?php

namespace Fabs\Component\Serializer\Encoder;

use Fabs\Component\Serializer\Assert;

class JSONEncoder implements EncoderInterface
{

    /** @var int[] */
    private $encode_options = [];
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
     */
    public function decode($value)
    {
        Assert::isString($value);

        $decode_options_combined = $this->combineOptions($this->decode_options);
        return json_decode($value, $decode_options_combined);
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
