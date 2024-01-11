<?php

namespace FINNPartners\Theme\Block\Register;

use WpAdvanceCustomFieldsExtend\AbstractClass\CustomBlock;
use FINNPartners\Theme\Theme;

class EventsList extends CustomBlock
{
    const NAME = 'events-list';
    const FILENAME = self::NAME;
    const TITLE = 'Events List';

    /**
     * @param string $class
     * @return EventsList
     */
    public static function getInstance(string $class = EventsList::class): EventsList
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

    public function __construct()
    {
        $this->setName(self::NAME)
            ->setTitle(self::TITLE)
            ->setRenderTemplate(self::FILENAME . '.php')
            ->setKeywords([Theme::DOMAIN])
            ->setIcon('superhero')
            ->setSupports(['anchor' => true, 'jsx' => false, 'align' => false])
        ;

        parent::__construct();
    }
}
