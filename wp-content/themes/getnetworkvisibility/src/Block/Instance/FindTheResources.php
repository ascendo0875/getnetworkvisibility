<?php

namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Api\AbstractClass\AbstractApiController;
use FINNPartners\Theme\Api\Resource as ApiResource;
use FINNPartners\Theme\Block\Instance\Fields\FindTheResourcesFields;
use FINNPartners\Theme\PostType\Instance\Topic as TopicInstance;
use FINNPartners\Theme\PostType\Register\Resource;
use FINNPartners\Theme\PostType\Register\Topic;
use FINNPartners\Theme\Service\ThemeCacheHelper;
use FINNPartners\Theme\Taxonomy\Type;
use FINNPartners\Theme\Theme;
use WP_Term;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;
use WpAdvanceCustomFieldsExtend\Service\Post2PostHelper;
use WpAdvanceCustomFieldsExtend\Service\React;
use WpAdvanceCustomFieldsExtend\Service\TaxonomyHelper;

class FindTheResources extends Block
{

    /**
     * @var FindTheResourcesFields
     */
    private $fields;

    /**
     * @param int|false $postId
     * @param array $block
     * @param bool $isPreview
     * @return void
     */
    public function __construct($postId = false, array $block = [], bool $isPreview = false)
    {
        $this->setFields(new FindTheResourcesFields($postId, !empty($block['id']) ? $block['id'] : false));

        parent::__construct($block);

        $this->setIsPreview($isPreview)->execute();
    }

    public function execute(): Block
    {
        /** @var React $React */
        $React = React::getInstance($this->getBlockId(), [
            'php' => getTheme()->getPath() . "templates/src/modules/list/build/list.build.asset.php",
            'js' => getTheme()->getPathUrl() . "templates/src/modules/list/build/list.build.js"
        ]);

        $React
            ->setApp('FindTheResources')
            ->addText('buttonLabelFindTheResources', $this->getFields()->getLabel())
            ->addText('popupTitle', 'Resource Finder')
            ->addText('textLabelClearAll', 'Clear all')
            ->addText('textLabelFindResources', 'find resources')
            ->addText('textShowMore', 'Show more')
            ->addText('textShowLess', 'Show less')
            ->addText('textSearchLabel', 'Search by keyword')
            ->addData('redirectToSearch', $this->getFields()->getLandingSearchPage())
            ;

        /** @var TaxonomyHelper $taxonomyHelper */
        $taxonomyHelper = TaxonomyHelper::getHelper();

        $filters = [];
        $filters['search'] = [
            'key' => AbstractApiController::API_QUERY_SEARCH,
            'default' => !empty($_GET[AbstractApiController::API_QUERY_SEARCH]) ? esc_sql($_GET[AbstractApiController::API_QUERY_SEARCH]) : false,
        ];
        $topics = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "find-the-resources-" . Topic::POST_TYPE, function () {
            $TopicsPost2PostHelper = Post2PostHelper::getInstances(Topic::POST_TYPE, Resource::POST_TYPE);
            $topics = $TopicsPost2PostHelper->getPostsLinkedToPostType(Topic::POST_TYPE);
            $topics = (!empty($topics)) ? $topics : false;

            if ($topics) {
                $topics = new \WP_Query([
                    'post_type' => Topic::POST_TYPE,
                    'post__in' => $topics,
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'fields' => 'ids',
                    'orderby' => ['title' => 'asc']
                ]);

                if($topics->have_posts()) {
                    $Topics = [];
                    foreach ($topics->get_posts() as $topic) {
                        $topic = new TopicInstance($topic);
                        /** @var TopicInstance $topic */
                        $Topics[] = ['label' => $topic->getFields()->getTitle(), 'value' => $topic->getFields()->getSlug()];
                    }

                    $topics = wp_list_sort($Topics, 'label');
                }
            }

            return $topics;
        });

        $filters[Topic::SEARCH_GETTER] = [
            'key' => Topic::SEARCH_GETTER,
            'element' => 'Input',
            'type' => 'checkbox',
            'default' => false,
            'label' => '',
            'choices' => $topics ?: [],
            'isVisible' => true,
        ];

        $types = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "find-the-resources-" . Type::TAXONOMY_NAME, function () use ($taxonomyHelper) {
            $terms = $taxonomyHelper->getTermsAssignedToPostType(Type::TAXONOMY_NAME, Resource::POST_TYPE);
            $terms = (!empty($terms) && !is_wp_error($terms)) ? $terms : false;

            if ($terms) {
                foreach ($terms as &$term) {
                    /** @var WP_Term $term */
                    $term = ['label' => ucfirst($term->name), 'value' => $term->slug];
                }

                $terms = wp_list_sort($terms, 'label');
            }

            return $terms;
        });

        $filters[Type::TAXONOMY_NAME] = [
            'key' => Type::TAXONOMY_NAME,
            'element' => 'Input',
            'type' => 'checkbox',
            'default' => false,
            'label' => 'What type of resources are you looking for?',
            'choices' => $types ?: [],
            'isVisible' => false,
        ];

        $React->addData('filters', $filters);
        $React->render();

        return parent::execute(); // TODO: Change the autogenerated stub
    }

    /**
     * @return FindTheResourcesFields
     */
    public function getFields(): FindTheResourcesFields
    {
        return $this->fields;
    }

    /**
     * @param FindTheResourcesFields $fields
     * @return $this
     */
    protected function setFields(FindTheResourcesFields $fields): self
    {
        $this->fields = $fields;

        return $this;
    }
}