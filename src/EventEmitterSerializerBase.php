<?php

namespace Fabstract\Component\Serializer;

use Fabstract\Component\Event\ListenerInterface;
use Fabstract\Component\Serializer\Encoder\EventEmitterEncoder;
use Fabstract\Component\Serializer\Normalizer\EventEmitterNormalizer;

abstract class EventEmitterSerializerBase extends SerializerBase
{
    /**
     * @param ListenerInterface|string $listener
     * @return static
     */
    public function addEncodeListener($listener)
    {
        /** @var EventEmitterEncoder $encoder */
        $encoder = $this->getEncoder();
        Assert::isType($encoder, EventEmitterEncoder::class, 'encoder');

        $encoder->addListener($listener);
        return $this;
    }

    /**
     * @param ListenerInterface|string $listener
     * @return static
     */
    public function removeEncodeListener($listener)
    {
        /** @var EventEmitterEncoder $encoder */
        $encoder = $this->getEncoder();
        Assert::isType($encoder, EventEmitterEncoder::class, 'encoder');

        $encoder->removeListener($listener);
        return $this;
    }

    /**
     * @param ListenerInterface|string $listener
     * @return static
     */
    public function addNormalizeListener($listener)
    {
        /** @var EventEmitterNormalizer $normalizer */
        $normalizer = $this->getNormalizer();
        Assert::isType($normalizer, EventEmitterNormalizer::class, 'normalizer');

        $normalizer->addListener($listener);
        return $this;
    }

    /**
     * @param ListenerInterface|string $listener
     * @return static
     */
    public function removeNormalizeListener($listener)
    {
        /** @var EventEmitterNormalizer $normalizer */
        $normalizer = $this->getNormalizer();
        Assert::isType($normalizer, EventEmitterNormalizer::class, 'normalizer');

        $normalizer->removeListener($listener);
        return $this;
    }

}