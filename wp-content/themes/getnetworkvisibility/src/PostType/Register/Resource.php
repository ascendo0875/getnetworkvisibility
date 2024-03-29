<?php

namespace FINNPartners\Theme\PostType\Register;

use FINNPartners\Theme\Taxonomy\Keyword;
use FINNPartners\Theme\Taxonomy\Persona;
use FINNPartners\Theme\Taxonomy\Type;
use FINNPartners\Theme\Theme;
use SimpleXMLElement;
use stdClass;
use WP_Post;
use WpAdvanceCustomFieldsExtend\AbstractClass\RegisterPostType;
use WpAdvanceCustomFieldsExtend\Service\P2PHelper;
use wpdb;

class Resource extends RegisterPostType
{
    const POST_TYPE = 'post';

    const SINGULAR_NAME = 'Resource';
    const PLURAL_NAME = 'Resources';

    const ICON = 'dashicons-download';

    const TAXONOMIES = [
        Keyword::SINGULAR_NAME => Keyword::TAXONOMY_NAME,
        Persona::SINGULAR_NAME => Persona::TAXONOMY_NAME,
        Type::SINGULAR_NAME => Type::TAXONOMY_NAME,
    ];

    const CONNECTED_POSTS = [
        Industry::POST_TYPE,
        Product::POST_TYPE,
        Solution::POST_TYPE,
        Topic::POST_TYPE,
    ];

    public function __construct(string $postType)
    {
        parent::__construct($postType);

        add_action('init', [$this, 'overridePost']);
    }

    /**
     * @param string $postType
     * @param string $class
     * @return Resource
     */
    public static function getInstance(string $postType = self::POST_TYPE, string $class = Resource::class): Resource
    {
        return parent::getInstance($postType, $class); // TODO: Change the autogenerated stub
    }

    public function overridePost()
    {
        $postTypeObj = get_post_type_object(self::POST_TYPE);
        $labels = $postTypeObj->labels;
        $labels->name = self::PLURAL_NAME;
        $labels->singular_name = self::SINGULAR_NAME;
        $labels->add_new_item = __("Add " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->edit_item = __("Edit " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->new_item = __("New " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->view_item = __("View " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->view_items = __("View " . self::PLURAL_NAME, Theme::DOMAIN);
        $labels->search_items = __("Search " . self::PLURAL_NAME, Theme::DOMAIN);
        $labels->not_found = __("No " . self::PLURAL_NAME . " found.", Theme::DOMAIN);
        $labels->not_found_in_trash = __("No " . self::PLURAL_NAME . " found in Trash.", Theme::DOMAIN);
        $labels->all_items = __("All " . self::PLURAL_NAME, Theme::DOMAIN);
        $labels->archives = __(self::SINGULAR_NAME . " Archives", Theme::DOMAIN);
        $labels->attributes = __(self::SINGULAR_NAME . " Archives", Theme::DOMAIN);
        $labels->insert_into_item = __("Insert into " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->uploaded_to_this_item = __("Uploaded to this " . self::SINGULAR_NAME, Theme::DOMAIN);
        $labels->items_list_navigation = __(self::PLURAL_NAME . " list navigation", Theme::DOMAIN);
        $labels->items_list = __(self::PLURAL_NAME . " list", Theme::DOMAIN);
        $labels->item_published = __(self::SINGULAR_NAME . " published.", Theme::DOMAIN);
        $labels->item_published_privately = __(self::SINGULAR_NAME . " published privately.", Theme::DOMAIN);
        $labels->item_reverted_to_draft = __(self::SINGULAR_NAME . " reverted to draft.", Theme::DOMAIN);
        $labels->item_scheduled = __(self::SINGULAR_NAME . " scheduled.", Theme::DOMAIN);
        $labels->item_updated = __(self::SINGULAR_NAME . " updated.", Theme::DOMAIN);
        $labels->item_link = __(self::SINGULAR_NAME . " Link", Theme::DOMAIN);
        $labels->menu_name = self::PLURAL_NAME;
        $labels->name_admin_bar = self::SINGULAR_NAME;

        unregister_taxonomy_for_object_type('category', self::POST_TYPE);
        unregister_taxonomy_for_object_type('post_tag', self::POST_TYPE);
    }

    /**
     * @return void
     */
    public function p2pInit(): void
    {
        foreach (self::CONNECTED_POSTS as $connectedPost) {
            p2p_register_connection_type([
                'name' => self::POST_TYPE . '_to_' . $connectedPost,
                'from' => self::POST_TYPE,
                'to' => $connectedPost,
                'sortable' => 'any',
                'reciprocal' => true,
                'admin_column' => true,
            ]);
        }

    }

    /**
     * @param int $postId
     * @param SimpleXMLElement $xmlNode
     * @param bool $isUpdate
     * @return void
     */
    public function wpAllImportP2P(int $postId, SimpleXMLElement $xmlNode, bool $isUpdate): void
    {
        if (get_post_type($postId) === self::POST_TYPE) {
            $node = json_decode(json_encode(( array )$xmlNode), 1);

            if (!empty($node['solutions'])) {
                $this->connectedP2PSolution($node['solutions'], $postId, $isUpdate);
            }

            if (!empty($node['topics'])) {
                $this->connectedP2PTopic($node['topics'], $postId, $isUpdate);
            }

            if (!empty($node['products'])) {
                $this->connectedP2PProduct($node['products'], $postId, $isUpdate);
            }

            if (!empty($node['markets'])) {
                $this->connectedP2PMarket($node['markets'], $postId, $isUpdate);
            }
        }
    }

    /**
     * @param string $solutions
     * @param int $resourceId
     * @param bool $isUpdate
     * @return void
     */
    public function connectedP2PSolution(string $solutions, int $resourceId, bool $isUpdate = false)
    {
        /** @var P2PHelper $P2PHelper */
        $P2PHelper = P2PHelper::getHelper();
        $connectedToSolution = $P2PHelper->guessConnection(Resource::POST_TYPE, Solution::POST_TYPE);

        if ($isUpdate) {
            $post2postIds = p2p_get_connections($connectedToSolution, ['fields' => 'p2p_id']);

            if (!empty($post2postIds)) {
                p2p_delete_connection($post2postIds);
            }
        }

        if (!empty($solutions)) {
            $solutions = explode('|', $solutions);

            foreach ($solutions as $solution) {
                /** @var string $solution */
                $post = get_page_by_title($solution, ARRAY_A, Solution::POST_TYPE);
                /** @var WP_Post|null $post */

                if (!empty($post)) {
                    p2p_create_connection($connectedToSolution, ['from' => $resourceId, 'to' => $post['ID']]);
                }
            }

            wp_reset_query();
        }
    }

    /**
     * @param string $topics
     * @param int $resourceId
     * @param bool $isUpdate
     * @return void
     */
    public function connectedP2PTopic(string $topics, int $resourceId, bool $isUpdate = false)
    {
        /** @var P2PHelper $P2PHelper */
        $P2PHelper = P2PHelper::getHelper();
        $connectedToSolution = $P2PHelper->guessConnection(Resource::POST_TYPE, Topic::POST_TYPE);

        if ($isUpdate) {
            $post2postIds = p2p_get_connections($connectedToSolution, ['fields' => 'p2p_id']);

            if (!empty($post2postIds)) {
                p2p_delete_connection($post2postIds);
            }
        }

        if (!empty($topics)) {
            $topics = explode('|', $topics);

            foreach ($topics as $topic) {
                /** @var string $topic */
                $post = get_page_by_title($topic, ARRAY_A, Topic::POST_TYPE);
                /** @var WP_Post|null $post */

                if (!empty($post)) {
                    p2p_create_connection($connectedToSolution, ['from' => $resourceId, 'to' => $post['ID']]);
                }
            }

            wp_reset_query();
        }
    }

    /**
     * @param string $products
     * @param int $resourceId
     * @param bool $isUpdate
     * @return void
     */
    public function connectedP2PProduct(string $products, int $resourceId, bool $isUpdate = false)
    {
        /** @var P2PHelper $P2PHelper */
        $P2PHelper = P2PHelper::getHelper();
        $connectedToSolution = $P2PHelper->guessConnection(Resource::POST_TYPE, Product::POST_TYPE);

        if ($isUpdate) {
            $post2postIds = p2p_get_connections($connectedToSolution, ['fields' => 'p2p_id']);

            if (!empty($post2postIds)) {
                p2p_delete_connection($post2postIds);
            }
        }

        if (!empty($products)) {
            $products = explode('|', $products);

            foreach ($products as $product) {
                /** @var string $product */
                $post = get_page_by_title($product, ARRAY_A, Product::POST_TYPE);
                /** @var WP_Post|null $post */

                if (!empty($post)) {
                    p2p_create_connection($connectedToSolution, ['from' => $resourceId, 'to' => $post['ID']]);
                }
            }

            wp_reset_query();
        }
    }

    /**
     * @param string $markets
     * @param int $resourceId
     * @param bool $isUpdate
     * @return void
     */
    public function connectedP2PMarket(string $markets, int $resourceId, bool $isUpdate = false)
    {
        /** @var P2PHelper $P2PHelper */
        $P2PHelper = P2PHelper::getHelper();
        $connectedToSolution = $P2PHelper->guessConnection(Resource::POST_TYPE, Market::POST_TYPE);

        if ($isUpdate) {
            $post2postIds = p2p_get_connections($connectedToSolution, ['fields' => 'p2p_id']);

            if (!empty($post2postIds)) {
                p2p_delete_connection($post2postIds);
            }
        }

        if (!empty($markets)) {
            $markets = explode('|', $markets);

            foreach ($markets as $market) {
                /** @var string $market */
                $post = get_page_by_title($market, ARRAY_A, Market::POST_TYPE);
                /** @var WP_Post|null $post */

                if (!empty($post)) {
                    p2p_create_connection($connectedToSolution, ['from' => $resourceId, 'to' => $post['ID']]);
                }
            }

            wp_reset_query();
        }
    }
}
