<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;

class MediaVisual extends CustomBlock
{
    const TITLE = 'Media Visual';
    const NAME = 'media-visual';
    const FILENAME = 'media-visual';

    /**
     * @param string $class
     * @return MediaVisual
     */
    public static function getInstance(string $class = MediaVisual::class): MediaVisual
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

    public function __construct()
    {
        $this->setName(self::NAME)
            ->setTitle(self::TITLE)
            ->setIcon('superhero')
            ->setRenderTemplate(self::FILENAME . '.php')
            ->setKeywords(['FP'])
            ->setSupports(['jsx' => true, 'align' => ['full', 'width'], 'anchor' => true])
        ;

        parent::__construct();
    }
}