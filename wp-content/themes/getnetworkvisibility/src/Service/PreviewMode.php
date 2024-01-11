<?php

namespace FINNPartners\Theme\Service;

class PreviewMode
{
    /**
     * @param string $urlImage
     * @param bool $isPreview
     * @return void
     */
    public static function styleBackgroundImage(string $urlImage, bool $isPreview = false)
    {
        echo $isPreview ? "style='background-image: url({$urlImage});'" : "";
    }
}