<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;
use FINNPartners\Theme\Theme;

class Frame extends CustomBlock
{
    const NAME = 'frame';
    const FILENAME = 'frame';
    const TITLE = 'Frame';

    const COLOR_PICKER_FIELD_NAME = 'background_color';

    const BACKGROUND_COLORS = [
        Theme::COLORS['dark-blue'],
        Theme::COLORS['grey'],
        Theme::COLORS['horizontal-gradient'],
        Theme::COLORS['vertical-gradient'],
    ];

    /**
     * @param string $class
     * @return Frame
     */
    public static function getInstance(string $class = Frame::class): Frame
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

    public function __construct()
    {
        $this->setName(self::NAME)
            ->setTitle(self::TITLE)
            ->setRenderTemplate(self::FILENAME . '.php')
            ->setKeywords(['FP'])
            ->setIcon('superhero')
            ->setSupports(['jsx' => true, 'align' => ['full', 'wide']])
            ->setColorPickerFieldName(self::COLOR_PICKER_FIELD_NAME)
            ->setColorPickerColors(wp_list_pluck(self::BACKGROUND_COLORS, 'color'))
            ->setStyles([
                ['label' => 'Default', 'name' => '', 'isDefault' => true],
                ['label' => 'Narrow', 'name' => 'narrow', 'isDefault' => false],
            ]);
        ;

        parent::__construct();

    }
}
