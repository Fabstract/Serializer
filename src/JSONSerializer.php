<?php

namespace Fabs\Component\Serializer;

use Fabs\Component\Lazy\Lazy;
use Fabs\Component\Serializer\Encoder\EncoderInterface;
use Fabs\Component\Serializer\Encoder\JSONEncoder;
use Fabs\Component\Serializer\Normalizer\Normalizer;
use Fabs\Component\Serializer\Normalizer\NormalizerInterface;

class JSONSerializer extends EventEmitterSerializerBase
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
        /** @var JSONEncoder $encoder */
        $encoder = Lazy::load(JSONEncoder::class);
        $encoder->setDecodeAssoc(true);
        $encoder->addEncodeOption(JSON_PRESERVE_ZERO_FRACTION);
        return $encoder;
    }
}
