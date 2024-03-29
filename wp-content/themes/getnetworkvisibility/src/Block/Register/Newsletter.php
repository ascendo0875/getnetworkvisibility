<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;

class Newsletter extends CustomBlock
{
    const NAME = 'newsletter';
    const FILENAME = 'newsletter';
    const TITLE = 'Newsletter';

    const ICON = 'id';

    /**
     * @param string $class
     * @return Newsletter
     */
    public static function getInstance(string $class = Newsletter::class): Newsletter
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

        $this->addFilter();
    }

    public function addFilter() {
        add_filter('acf/load_field/name=ninja_forms', function ($field) {
            $forms = Ninja_Forms()->form()->get_forms();

            foreach ($forms as $form) {
                $field['choices'][$form->get_id()] = $form->get_setting('title');
            }

            return $field;
        }, 10);
    }
}