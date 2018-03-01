<?php

namespace Fabs\Component\Serializer\Normalizer;

interface NormalizableInterface
{
    /**
     * @param NormalizationMetadata $normalization_metadata
     * @return void
     */
    public function configureNormalizationMetadata($normalization_metadata);
}
