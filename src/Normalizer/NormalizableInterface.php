<?php

namespace Fabs\Component\Serializer\Normalizer;

interface NormalizableInterface
{
    /**
     * @return NormalizationMetadata
     */
    public function getNormalizationMetadata();
}
