<?php

namespace FINNPartners\Theme\PostType\Register;

use FINNPartners\Theme\Theme;
use stdClass;
use WpAdvanceCustomFieldsExtend\AbstractClass\RegisterPostType;

class Topic extends RegisterPostType
{
    const POST_TYPE = 'topic';
    const SEARCH_GETTER = 'query-topic';

    const SINGULAR_NAME = 'Topic';
    const PLURAL_NAME = 'Topics';

    const ICON = 'dashicons-pressthis';

    const TAXONOMIES = [
    ];

    public function __construct(string $postType)
    {
        parent::__construct($postType);

        $labels = new stdClass;
        $labels->name = self::PLURAL_NAME;
        $labels->singular_name = self::SINGULAR_NAME;
        $labels->add_new_item = __("Add New " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->new_item_name = __("New " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->edit_item = __("Edit " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->update_item = __("Update " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->search_items = __("Search " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->popular_items = __("Popular " . self::PLURAL_NAME, Theme::DOMAIN);
        $labels->all_items = __("All " . self::PLURAL_NAME, Theme::DOMAIN);
        $labels->add_or_remove_items = __("Add or remove " . self::PLURAL_NAME, Theme::DOMAIN);
        $labels->separate_items_with_commas = __("Separate " . self::PLURAL_NAME . " with commas", Theme::DOMAIN);
        $labels->choose_from_most_used = __("All " . self::PLURAL_NAME, Theme::DOMAIN);
        $labels->front = self::PLURAL_NAME;
        $labels->detail = self::SINGULAR_NAME;
        $labels->detail_plural = self::PLURAL_NAME;

        $this->setLabel(self::PLURAL_NAME)
            ->setLabels($labels)
            ->setPublic(true)
            ->setHasArchive(false)
            ->setSupports(['title', 'thumbnail', 'editor', 'excerpt', 'revisions', 'page-attributes'])
            ->setQueryVar(true)
            ->setMenuIcon(self::ICON)
            ->setHierarchical(true)
            ->setShowInRest(true)
            ->setRestBase(self::POST_TYPE)
            ->register();
    }

    /**
     * @param string $postType
     * @param string $class
     * @return Topic
     */
    public static function getInstance(string $postType = self::POST_TYPE, string $class = Topic::class): Topic
    {
        return parent::getInstance($postType, $class); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     */
    public function p2pInit(): void
    {
    }
}
