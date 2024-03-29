<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;

class Topics extends CustomBlock
{
    const NAME = 'topics';
    const FILENAME = 'topics';
    const TITLE = 'Topics';

    const ICON = 'id';

    /**
     * @param string $class
     * @return Topics
     */
    public static function getInstance(string $class = Topics::class): Topics
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

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
}