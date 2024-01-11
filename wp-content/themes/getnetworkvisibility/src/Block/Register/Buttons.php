<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\BlockStyle;

class Buttons extends BlockStyle
{
    const STYLE_SOLID_LABEL = 'Solid';
    const STYLE_SOLID = 'solid';

    /**
     * @param string $class
     * @return Buttons
     */
    public static function getInstance(string $class = Buttons::class): Buttons
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setBlockName('core/button');
        $this->setName(self::STYLE_SOLID)->setLabel(self::STYLE_SOLID_LABEL)->registerBlockStyle();

        parent::__construct();
    }
}