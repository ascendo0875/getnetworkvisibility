<?php

namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Api\AbstractClass\AbstractApiController;
use FINNPartners\Theme\Api\Resource as ApiResource;
use FINNPartners\Theme\Block\Instance\Fields\SearchResourcesFields;
use FINNPartners\Theme\PostType\Register\Industry;
use FINNPartners\Theme\PostType\Register\Product;
use FINNPartners\Theme\PostType\Register\Resource;
use FINNPartners\Theme\PostType\Register\Solution;
use FINNPartners\Theme\PostType\Register\Topic;
use FINNPartners\Theme\PostType\Instance\Solution as SolutionInstance;
use FINNPartners\Theme\PostType\Instance\Topic as TopicInstance;
use FINNPartners\Theme\PostType\Instance\Industry as IndustryInstance;
use FINNPartners\Theme\PostType\Instance\Product as ProductInstance;
use FINNPartners\Theme\Service\ThemeCacheHelper;
use FINNPartners\Theme\Taxonomy\Keyword;
use FINNPartners\Theme\Taxonomy\Type;
use FINNPartners\Theme\Theme;
use WP_Post;
use WP_Term;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;
use WpAdvanceCustomFieldsExtend\Service\Post2PostHelper;
use WpAdvanceCustomFieldsExtend\Service\React;
use WpAdvanceCustomFieldsExtend\Service\TaxonomyHelper;

class SearchResources extends Block
{

    /**
     * @var SearchResourcesFields
     */
    private $fields;

    /**
     * @var string|false
     */
    private $landingSearchPage = null;

    /**
     * @param int|false $postId
     * @param array $block
     * @param bool $isPreview
     * @return void
     */
    public function __construct($postId = false, array $block = [], bool $isPreview = false)
    {
        parent::__construct($block);

        $this->setFields(new SearchResourcesFields($postId, !empty($block['id']) ? $block['id'] : false));

        $this->setIsPreview($isPreview)->execute();
    }

    public function execute(): Block
    {
        /** @var React $React */
        $React = React::getInstance($this->getBlockId(), [
            'php' => getTheme()->getPath() . "templates/src/modules/list/build/list.build.asset.php",
            'js' => getTheme()->getPathUrl() . "templates/src/modules/list/build/list.build.js"
        ]);
        $currentPostType = false;
        $currentSlug = false;

        $source = ApiResource::url();

        if ($this->getFields()->isConnectedToCurrentPost()) {
            if ((get_queried_object() instanceof WP_Post)) {
                $currentPostType = get_queried_object()->post_type;
                $currentSlug = get_post_field('post_name', get_queried_object());
                $source .= "?query-{$currentPostType}={$currentSlug}";
            }
        }

        $React->setApp('Resources')
            ->addData('source', $source)
            ->addData('loadMore', 'pagination')
            ->addData('maxFiltersDisplay', 6)
            ->addData('filtersShowMore', true)
            ->addData('redirectToSearch', $this->getFields()->isRedirectOnSearchPage() ? $this->getLandingSearchPage() : false)
            ->addData('disabledAutoScroll', $this->getFields()->isRedirectOnSearchPage())
            ->addData('domLoadedAutoScroll', $this->getFields()->isWhenLoadingPagesApplyScrolling())
            ->addText('textFilterShowMore', 'Show More')
            ->addText('textFilterShowLess', 'Show Less')
            ->addText('textSearchLabel', 'type a keyword')
            ->addText('textButtonSearchLabel', 'search')
            ->addText('textFilterLabel', 'filter ')
            ->addText('textClearAllLabel', 'clear all')
            ->addText('textShowNumberResults', 'show (%countResults%) results')
            ->addText('copyMessage', !empty($this->getFields()->getCopy()) ? $this->getFields()->getCopy() : false);

        $filters = [];
        $filters['search'] = [
            'key' => AbstractApiController::API_QUERY_SEARCH,
            'default' => !empty($_GET[AbstractApiController::API_QUERY_SEARCH]) ? esc_sql($_GET[AbstractApiController::API_QUERY_SEARCH]) : false,
        ];

        $filters['page'] = [
            'key' => 'page',
            'default' => isset($_GET['page']) ? esc_sql($_GET['page']) : false,
        ];

        if ($this->getFields()->isFilters()) {
            /** @var TaxonomyHelper $taxonomyHelper */
            $taxonomyHelper = TaxonomyHelper::getHelper();

            if ($this->getFields()->isFiltersBySolution() && $currentPostType !== Solution::POST_TYPE) {
                /** @var Post2PostHelper $SolutionsPost2PostHelper */
                $solutions = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "search-resources-" . Solution::POST_TYPE, function () {
                    $SolutionsPost2PostHelper = Post2PostHelper::getInstances(Solution::POST_TYPE, Resource::POST_TYPE);
                    $solutions = $SolutionsPost2PostHelper->getPostsLinkedToPostType(Solution::POST_TYPE);
                    $solutions = (!empty($solutions)) ? $solutions : false;

                    if ($solutions) {
                        $solutions = new \WP_Query([
                            'post_type' => Solution::POST_TYPE,
                            'post__in' => $solutions,
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'fields' => 'ids',
                            'orderby' => ['title' => 'asc'],
                        ]);

                        if($solutions->have_posts()) {
                            $Solutions = [];
                            foreach ($solutions->get_posts() as $solution) {
                                $solution = new SolutionInstance($solution);
                                /** @var SolutionInstance $solution */
                                $Solutions[] = ['label' => $solution->getFields()->getTitle(), 'value' => $solution->getFields()->getSlug()];
                            }

                            $solutions = wp_list_sort($Solutions, 'label');
                        }
                    }
                    return $solutions;
                });

                $filters[Solution::SEARCH_GETTER] = [
                    'key' => Solution::SEARCH_GETTER,
                    'element' => 'Input',
                    'type' => 'checkbox',
                    'default' => !empty($_GET[Solution::SEARCH_GETTER]) ? $_GET[Solution::SEARCH_GETTER] : (($currentPostType === Solution::POST_TYPE) ? $currentSlug : false),
                    'label' => Solution::PLURAL_NAME,
                    'choices' => $solutions ?: [],
                    'isVisible' => true,
                ];
            }

            if ($this->getFields()->isFiltersByType()) {
                $types = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "search-resources-" . Type::TAXONOMY_NAME, function () use ($taxonomyHelper) {
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
                    'default' => !empty($_GET[Type::TAXONOMY_NAME]) ? $_GET[Type::TAXONOMY_NAME] : false,
                    'label' => Type::PLURAL_NAME,
                    'choices' => $types ?: [],
                    'isVisible' => true,
                ];
            }

            if ($this->getFields()->isFiltersByTopic() && $currentPostType !== Topic::POST_TYPE) {
                $topics = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "search-resources-" . Topic::POST_TYPE, function () {
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
                    'default' => !empty($_GET[Topic::SEARCH_GETTER]) ? $_GET[Topic::SEARCH_GETTER] : (($currentPostType === Topic::POST_TYPE) ? $currentSlug : false),
                    'label' => Topic::PLURAL_NAME,
                    'choices' => $topics ?: [],
                    'isVisible' => true,
                ];
            }

            if ($this->getFields()->isFiltersByKeyword()) {
                $keywords = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "resources-keywords", function () use ($taxonomyHelper) {
                    $terms = $taxonomyHelper->getTermsAssignedToPostType(Keyword::TAXONOMY_NAME, Resource::POST_TYPE);
                    $terms = !empty($terms) ? $terms : false;

                    if ($terms) {
                        foreach ($terms as &$term) {
                            /** @var WP_Term $term */
                            $term = ['label' => ucfirst($term->name), 'value' => $term->slug];
                        }

                        $terms = wp_list_sort($terms, 'label');
                    }

                    return $terms;
                });

                $filters[Keyword::TAXONOMY_NAME] = [
                    'key' => Keyword::TAXONOMY_NAME,
                    'element' => 'Input',
                    'type' => 'checkbox',
                    'default' => !empty($_GET[Keyword::TAXONOMY_NAME]) ? $_GET[Keyword::TAXONOMY_NAME] : false,
                    'label' => Keyword::PLURAL_NAME,
                    'choices' => $keywords ?: [],
                    'isVisible' => false,
                ];
            }

            if ($this->getFields()->isFiltersByIndustry() && $currentPostType !== Industry::POST_TYPE) {
                $industries = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "search-resources-" . Industry::POST_TYPE, function () {
                    $IndustriesPost2PostHelper = Post2PostHelper::getInstances(Industry::POST_TYPE, Resource::POST_TYPE);
                    $industries = $IndustriesPost2PostHelper->getPostsLinkedToPostType(Industry::POST_TYPE);
                    $industries = (!empty($industries)) ? $industries : false;

                    if ($industries) {
                        $industries = new \WP_Query([
                            'post_type' => Industry::POST_TYPE,
                            'post__in' => $industries,
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'fields' => 'ids',
                            'orderby' => ['title' => 'asc']
                        ]);

                        if($industries->have_posts()) {
                            $Industries = [];
                            foreach ($industries->get_posts() as $industry) {
                                $industry = new IndustryInstance($industry);
                                /** @var IndustryInstance $industry */
                                $Industries[] = ['label' => $industry->getFields()->getTitle(), 'value' => $industry->getFields()->getSlug()];
                            }

                            $industries = wp_list_sort($Industries, 'label');
                        }
                    }

                    return $industries;
                });

                $filters[Industry::SEARCH_GETTER] = [
                    'key' => Industry::SEARCH_GETTER,
                    'element' => 'Input',
                    'type' => 'checkbox',
                    'default' => !empty($_GET[Industry::SEARCH_GETTER]) ? $_GET[Industry::SEARCH_GETTER] : (($currentPostType === Industry::POST_TYPE) ? $currentSlug : false),
                    'label' => Industry::PLURAL_NAME,
                    'choices' => $industries ?: [],
                    'isVisible' => false,
                ];
            }

            if ($this->getFields()->isFiltersByProduct() && $currentPostType !== Product::POST_TYPE) {
                $products = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "search-resources-" . Product::POST_TYPE, function () {
                    $ProductsPost2PostHelper = Post2PostHelper::getInstances(Product::POST_TYPE, Resource::POST_TYPE);
                    $products = $ProductsPost2PostHelper->getPostsLinkedToPostType(Product::POST_TYPE);
                    $products = (!empty($products)) ? $products : false;

                    if ($products) {
                        $products = new \WP_Query([
                            'post_type' => Product::POST_TYPE,
                            'post__in' => $products,
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'fields' => 'ids',
                            'orderby' => ['title' => 'asc']
                        ]);

                        if($products->have_posts()) {
                            $Products = [];
                            foreach ($products->get_posts() as $product) {
                                $product = new ProductInstance($product);
                                /** @var ProductInstance $product */
                                $Products[] = ['label' => $product->getFields()->getTitle(), 'value' => $product->getFields()->getSlug()];
                            }

                            $products = wp_list_sort($Products, 'label');
                        }
                    }

                    return $products;
                });

                $filters[Product::SEARCH_GETTER] = [
                    'key' => Product::SEARCH_GETTER,
                    'element' => 'Input',
                    'type' => 'checkbox',
                    'default' => !empty($_GET[Product::SEARCH_GETTER]) ? $_GET[Product::SEARCH_GETTER] : (($currentPostType === Product::POST_TYPE) ? $currentSlug : false),
                    'label' => Product::PLURAL_NAME,
                    'choices' => $products ?: [],
                    'isVisible' => false,
                ];
            }
        }

        $React->addData('filters', $filters);
        $React->render();

        return parent::execute(); // TODO: Change the autogenerated stub
    }

    /**
     * @return SearchResourcesFields
     */
    public function getFields(): SearchResourcesFields
    {
        return $this->fields;
    }

    /**
     * @param SearchResourcesFields $fields
     * @return $this
     */
    protected function setFields(SearchResourcesFields $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return false|string
     */
    public function getLandingSearchPage()
    {
        if (is_null($this->landingSearchPage)) {
            $landingSearchPage = get_field('search_resources_landing', 'option');

            $this->setLandingSearchPage(!empty($landingSearchPage) ? $landingSearchPage : false);
        }

        return $this->landingSearchPage;
    }

    /**
     * @param false|string $landingSearchPage
     * @return SearchResources
     */
    public function setLandingSearchPage($landingSearchPage)
    {
        $this->landingSearchPage = $landingSearchPage;
        return $this;
    }
}