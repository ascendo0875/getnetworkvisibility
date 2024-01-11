<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage FinnPartners
 * @since FinnPartners 1.0
 */

namespace FINNPartners\Theme\Taxonomy;

use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\AbstractClass\RegisterTaxonomy;

class Keyword extends RegisterTaxonomy
{
    const TAXONOMY_NAME = 'keyword';

    const SINGULAR_NAME = 'Keyword';
    const PLURAL_NAME = 'Keywords';

    public static function getInstance(string $taxonomyName = self::TAXONOMY_NAME, string $class = Keyword::class): Keyword
    {
        return parent::getInstance($taxonomyName, $class); // TODO: Change the autogenerated stub
    }

    public static function get(?int $postId = null, string $taxonomy = self::TAXONOMY_NAME)
    {
        return parent::get($postId, $taxonomy); // TODO: Change the autogenerated stub
    }

    public function __construct(string $taxonomyName)
    {
        parent::__construct($taxonomyName);

        $this->setLabel(self::PLURAL_NAME)
            ->setLabels([
                'name' => __(self::PLURAL_NAME, Theme::DOMAIN),
                'singular_name' => __(self::SINGULAR_NAME, Theme::DOMAIN),
                'add_new_item' => __('Add New ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'new_item_name' => __('New ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'edit_item' => __('Edit ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'update_item' => __('Update ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'search_items' => __('Search ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'popular_items' => __('Popular ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'all_items' => __('All ' . self::PLURAL_NAME, Theme::DOMAIN),
                'parent_item' => __('Parent ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'parent_item_colon' => __('Parent ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'add_or_remove_items' => __('Add or Remove ' . self::SINGULAR_NAME, Theme::DOMAIN),
                'separate_items_with_commas' => __('Separate ' . self::PLURAL_NAME . ' with commas', Theme::DOMAIN),
                'choose_from_most_used' => __('All ' . self::PLURAL_NAME, Theme::DOMAIN),
                'front' => __(self::PLURAL_NAME, Theme::DOMAIN),
                'detail' => __(self::SINGULAR_NAME, Theme::DOMAIN),
                'detail_plural' => __(self::PLURAL_NAME, Theme::DOMAIN),
            ])
            ->setCap([
                'manage_terms' => 'manage_categories',
                'edit_terms' => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_posts',
            ])
            ->setQueryVar(false)
            ->setHierarchical(true)
            ->setPublic(false)
            ->setShowUi(true)
            ->setShowAdminColumn(true)
            ->setShowInNavMenus(true)
            ->setShowInMenu(true)
            ->setShowInRest(true)
            ->register();
    }
}