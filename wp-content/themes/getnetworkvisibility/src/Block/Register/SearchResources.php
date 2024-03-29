<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;

class SearchResources extends CustomBlock
{
    const NAME = 'search-resources';
    const FILENAME = 'search-resources';
    const TITLE = 'Search Resources';

    const ICON = 'id';

    public function __construct()
    {
        $this->setName(self::NAME)
            ->setTitle(self::TITLE)
            ->setRenderTemplate(self::FILENAME . '.php')
            ->setKeywords(['FP'])
            ->setIcon(self::ICON)
            ->setSupports(['jsx' => true, 'align' => false]);

        parent::__construct();
    }

    /**
     * @param string $class
     * @return SearchResources
     */
    public static function getInstance(string $class = SearchResources::class): SearchResources
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }
}