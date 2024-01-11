<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;

class Anchors extends CustomBlock
{
    const NAME = 'anchors';
    const FILENAME = 'anchors';
    const TITLE = 'Anchors';

    const ICON = 'id';

    public function __construct()
    {
        $this->setName(self::NAME)
            ->setTitle(self::TITLE)
            ->setRenderTemplate(self::FILENAME . '.php')
            ->setKeywords(['FP'])
            ->setIcon(self::ICON)
            ->setSupports(['jsx' => true, 'align' => ['full', 'wide']]);

        parent::__construct();
    }

    /**
     * @param string $class
     * @return Anchors
     */
    public static function getInstance(string $class = Anchors::class): Anchors
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }
}