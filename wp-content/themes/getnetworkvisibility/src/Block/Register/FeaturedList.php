<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;

class FeaturedList extends CustomBlock
{
    const NAME = 'featured-list';
    const FILENAME = 'featured-list';
    const TITLE = 'Featured List';

    const ICON = 'id';

    public function __construct()
    {
        $this->setName(self::NAME)
            ->setTitle(self::TITLE)
            ->setRenderTemplate(self::FILENAME . '.php')
            ->setKeywords(['FP'])
            ->setIcon(self::ICON)
            ->setSupports(['jsx' => true, 'align' => false])
            ->setStyles([
                ['label' => 'Slider', 'name' => 'slider', 'isDefault' => false],
                ['label' => 'List', 'name' => 'List', 'isDefault' => true],
            ]);

        parent::__construct();
    }

    /**
     * @param string $class
     * @return FeaturedList
     */
    public static function getInstance(string $class = FeaturedList::class): FeaturedList
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }
}