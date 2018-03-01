<?php


namespace Fabs\Component\Serializer;


use Fabs\Component\Event\EventEmitter;
use Fabs\Component\Event\EventEmitterInterface;
use Fabs\Component\Event\EventInterface;
use Fabs\Component\Event\ListenerInterface;
use Fabs\Component\Serializer\Event\DecodingFinishedEvent;
use Fabs\Component\Serializer\Event\DecodingWillStartEvent;
use Fabs\Component\Serializer\Event\DenormalizationFinishedEvent;
use Fabs\Component\Serializer\Event\DenormalizationWillStartEvent;
use Fabs\Component\Serializer\Event\EncodingFinishedEvent;
use Fabs\Component\Serializer\Event\EncodingWillStartEvent;
use Fabs\Component\Serializer\Event\NormalizationFinishedEvent;
use Fabs\Component\Serializer\Event\NormalizationWillStartEvent;
use Fabs\Component\Serializer\Normalizer\Type;

abstract class EventEmitterSerializer implements SerializerInterface, EventEmitterInterface
{

    /** @var EventEmitter */
    private $event_emitter = null;

    function __construct()
    {
        $this->event_emitter = new EventEmitter();
    }

    /**
     * @param EventInterface $event
     * @return $this
     */
    public function emit($event)
    {
        $this->event_emitter->emit($event);
        return $this;
    }

    /**
     * @param ListenerInterface|string $listener
     * @return $this
     */
    public function addListener($listener)
    {
        $this->event_emitter->addListener($listener);
        return $this;
    }

    /**
     * @param ListenerInterface|string $listener
     * @return $this
     */
    public function removeListener($listener)
    {
        $this->event_emitter->removeListener($listener);
        return $this;
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data)
    {
        $this->emit(new NormalizationWillStartEvent($data));
        $normalized_data = $this->getNormalizer()->normalize($data);
        $this->emit(new NormalizationFinishedEvent($normalized_data));

        $this->emit(new EncodingWillStartEvent($normalized_data));
        $encoded = $this->getEncoder()->encode($normalized_data);
        $this->emit(new EncodingFinishedEvent($encoded));

        return $encoded;
    }

    /**
     * @param string $data
     * @param Type $type
     * @return mixed
     */
    public function deserialize($data, $type)
    {
        $this->emit(new DecodingWillStartEvent($data));
        $decoded_array = $this->getEncoder()->decode($data);
        $this->emit(new DecodingFinishedEvent($decoded_array));

        $this->emit(new DenormalizationWillStartEvent($decoded_array, $type));
        $denormalized = $this->getNormalizer()->denormalize($decoded_array, $type);
        $this->emit(new DenormalizationFinishedEvent($denormalized));

        return $denormalized;
    }
}