<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\BlockStyle;

class Lists extends BlockStyle
{
    const STYLE_HIGHLIGHTED_LABEL = 'Highlighted Numbers';
    const STYLE_HIGHLIGHTED = 'highlighted-numbers';

    const STYLE_NARROW_LABEL = 'Narrow';
    const STYLE_NARROW = 'narrow';

    const STYLE_NARROW_CENTER_LABEL = 'Narrow Center';
    const STYLE_NARROW_CENTER = 'narrow-center';

    /**
     * @param string $class
     * @return Lists
     */
    public static function getInstance(string $class = Lists::class): Lists
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setBlockName('core/list');
        $this->setName(self::STYLE_HIGHLIGHTED)->setLabel(self::STYLE_HIGHLIGHTED_LABEL)->registerBlockStyle();
        $this->setName(self::STYLE_NARROW)->setLabel(self::STYLE_NARROW_LABEL)->registerBlockStyle();
        $this->setName(self::STYLE_NARROW_CENTER)->setLabel(self::STYLE_NARROW_CENTER_LABEL)->registerBlockStyle();

        parent::__construct();
    }
}
