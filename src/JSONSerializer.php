<?php

namespace Fabstract\Component\Serializer;

use Fabstract\Component\Lazy\Lazy;
use Fabstract\Component\Serializer\Encoder\EncoderInterface;
use Fabstract\Component\Serializer\Encoder\JSONEncoder;
use Fabstract\Component\Serializer\Normalizer\Normalizer;
use Fabstract\Component\Serializer\Normalizer\NormalizerInterface;

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
