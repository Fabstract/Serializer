<?php

namespace Fabs\Component\Serializer\RenderModifier;

interface RenderModifiable
{
    /**
     * @param RenderModificationMetadata $render_modification_metadata
     * @return void
     */
    public function configureRenderModificationMetadata($render_modification_metadata);
}
