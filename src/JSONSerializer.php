<?php

namespace Fabs\Component\Serializer;

use Fabs\Component\Lazy\Lazy;
use Fabs\Component\Serializer\Encoder\EncoderInterface;
use Fabs\Component\Serializer\Encoder\JSONEncoder;
use Fabs\Component\Serializer\Normalizer\Normalizer;
use Fabs\Component\Serializer\Normalizer\NormalizerInterface;

class JSONSerializer extends EventEmitterSerializer
{

    /**
     * @return NormalizerInterface
     */
    public function getNormalizer()
    {
        return Lazy::load(Normalizer::class);
    }

    /**
     * @return EncoderInterface
     */
    public function getEncoder()
    {
        return Lazy::load(JSONEncoder::class);
    }
}
