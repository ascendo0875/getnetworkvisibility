<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\BlockStyle;

class Heading extends BlockStyle
{
    const STYLE_GRADIENT_LABEL = 'Gradient';
    const STYLE_GRADIENT = 'gradient';

	const STYLE_NARROW_LABEL = 'Narrow';
	const STYLE_NARROW = 'narrow';

    /**
     * @param string $class
     * @return Heading
     */
    public static function getInstance(string $class = Heading::class): Heading
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setBlockName('core/heading');
        $this->setName(self::STYLE_GRADIENT)->setLabel(self::STYLE_GRADIENT_LABEL)->registerBlockStyle();
	    $this->setName(self::STYLE_NARROW)->setLabel(self::STYLE_NARROW_LABEL)->registerBlockStyle();

        parent::__construct();
    }
}