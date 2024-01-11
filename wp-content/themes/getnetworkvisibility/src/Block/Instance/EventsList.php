<?php

namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\EventsListFields;
use FINNPartners\Theme\PostType\Instance\Event;
use WP_Query;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;
use WpAdvanceCustomFieldsExtend\Service\CachePage;

class EventsList extends Block
{

    /**
     * @var EventsListFields
     */
    private $fields;

    /**
     * @var Event[]|false
     */
    private $events;

    /**
     * @param int|false $postId
     * @param array $block
     * @param bool $isPreview
     * @return void
     */
    public function __construct($postId = false, array $block = [], bool $isPreview = false)
    {
        $this->setFields(new EventsListFields($postId, !empty($block['id']) ? $block['id'] : false));

        parent::__construct($block);

        $this->setIsPreview($isPreview)->execute();
    }

    public function previewNotAvailableHTML(): void
    {
        if ($this->isPreview() && empty($this->getEvents())) {
            parent::previewNotAvailableHTML(); // TODO: Change the autogenerated stub
        }
    }

    public function getEvents()
    {
        global $wp_query;

        if (is_null($this->events)) {
            $excludeIDs = CachePage::getInstance()->getPostIds();

            $args = [
                'post_type' => 'event',
                'posts_per_page' => $this->getFields()->getLimit(),
                'orderby' => ['start_date' => 'ASC'],
                'meta_query' => [
                    [
                        'key' => 'start_date',
                        'compare' => '>=',
                        'value' => date('Ymd'),
                        'type' => 'DATETIME',
                    ]
                ],
                'fields' => 'ids',
            ];

            // Exclude
            if (!empty($excludeIDs)) {
                $args['post__not_in'] = $excludeIDs;
            }

            $wp_query = new WP_Query($args);

            $eventIDs = $wp_query->posts;
            $events = [];
            foreach ($eventIDs as $eventID) {
                $events[] = new Event($eventID);
            }

            $this->setEvents(!empty($events) ? $events : false);
        }

        return $this->events;
    }

    /**
     * @param false|Event[] $events
     * @return EventsList
     */
    public function setEvents($events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * @return EventsListFields
     */
    public function getFields(): EventsListFields
    {
        return $this->fields;
    }

    /**
     * @param EventsListFields $fields
     * @return $this
     */
    protected function setFields(EventsListFields $fields): self
    {
        $this->fields = $fields;

        return $this;
    }
}