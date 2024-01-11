<?php

namespace FINNPartners\Theme\Api;

use FINNPartners\Theme\Api\AbstractClass\AbstractApiController;
use FINNPartners\Theme\Api\ParamsStructure\Resource as ResourceParamStructure;
use FINNPartners\Theme\Api\Repository\ResourceRepository;
use FINNPartners\Theme\PostType\Register\Industry;
use FINNPartners\Theme\PostType\Register\Product;
use FINNPartners\Theme\PostType\Register\Resource as RegisterPostTypeResource;
use FINNPartners\Theme\Api\Data\Resource as ResourceData;
use FINNPartners\Theme\PostType\Register\Solution;
use FINNPartners\Theme\PostType\Register\Topic;
use FINNPartners\Theme\Taxonomy\Keyword;
use FINNPartners\Theme\Taxonomy\Type;
use FpStructure\Entity\EntityInterface;
use WP_REST_Request;
use WP_REST_Server;

class Resource extends AbstractApiController
{
    public function __construct(string $paramStructure = ResourceParamStructure::class)
    {
        parent::__construct($paramStructure);
    }

    public static function url()
    {
        return implode('/', [get_home_url(), "wp-json", self::FP_STRUCTURE_NAMESPACE, RegisterPostTypeResource::POST_TYPE]);
    }

    /**
     * @return void
     */
    public function rest_api_init(): void
    {
        // TODO: Implement rest_api_init() method.
        register_rest_route(self::FP_STRUCTURE_NAMESPACE, RegisterPostTypeResource::POST_TYPE, [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'getResponse'],
            'permission_callback' => [$this, 'permissionCallBack'],
        ]);
    }

    public function getResponse(WP_REST_Request $request, ?EntityInterface $query = null)
    {
        $this->getParams()->setPostType(RegisterPostTypeResource::POST_TYPE);
        $this->getParams()->setEntityDataService([ResourceData::class, 'default']);

        if (!empty($request->get_param('order-name'))) {
            $this->getParams()->setParams('order-name', $request->get_param('order-name'));
        }

        if (!empty($request->get_param(Solution::SEARCH_GETTER))) {
            $solutions = !is_array($request->get_param(Solution::SEARCH_GETTER)) ? [$request->get_param(Solution::SEARCH_GETTER)] : $request->get_param(Solution::SEARCH_GETTER);
            $solutionIds = [];
            foreach ($solutions as $solution) {
                $solution = get_page_by_path($solution, ARRAY_A, Solution::POST_TYPE);
                /** @var array|null $solution */

                if (!empty($solution)) {
                    $solutionIds[] = $solution['ID'];
                }
            }

            if (!empty($solutionIds)) {
                $request->set_param(Solution::SEARCH_GETTER, $solutionIds);
            }

            $this->getParams()->setParamsP2P(Solution::POST_TYPE, Solution::SEARCH_GETTER, [
                'ID' => $solutionIds,
                '!p2p_from' => null,
                'direction' => 'to',
            ]);
        }

        if (!empty($request->get_param(Industry::SEARCH_GETTER))) {
            $industries = !is_array($request->get_param(Industry::SEARCH_GETTER)) ? [$request->get_param(Industry::SEARCH_GETTER)] : $request->get_param(Industry::SEARCH_GETTER);
            $industryIds = [];
            foreach ($industries as $industry) {
                $industry = get_page_by_path($industry, ARRAY_A, Industry::POST_TYPE);
                /** @var array|null $industry */

                if (!empty($industry)) {
                    $industryIds[] = $industry['ID'];
                }
            }

            if (!empty($industryIds)) {
                $request->set_param(Industry::SEARCH_GETTER, $industryIds);
            }

            $this->getParams()->setParamsP2P(Industry::POST_TYPE, Industry::SEARCH_GETTER, [
                'ID' => $industryIds,
                '!p2p_from' => null,
                'direction' => 'to',
            ]);
        }

        if (!empty($request->get_param(Type::TAXONOMY_NAME))) {
            $this->getParams()->setParamsTaxonomy(Type::TAXONOMY_NAME, Type::TAXONOMY_NAME, [
                [
                    'field' => 'slug',
                    'terms' => (!is_array($request->get_param(Type::TAXONOMY_NAME))) ? [$request->get_param(Type::TAXONOMY_NAME)] : $request->get_param(Type::TAXONOMY_NAME)
                ]
            ]);
        }

        if (!empty($request->get_param(Topic::SEARCH_GETTER))) {
            $topics = !is_array($request->get_param(Topic::SEARCH_GETTER)) ? [$request->get_param(Topic::SEARCH_GETTER)] : $request->get_param(Topic::SEARCH_GETTER);
            $topicIds = [];
            foreach ($topics as $topic) {
                $topic = get_page_by_path($topic, ARRAY_A, Topic::POST_TYPE);
                /** @var array|null $topic */

                if (!empty($topic)) {
                    $topicIds[] = $topic['ID'];
                }
            }

            if (!empty($topicIds)) {
                $request->set_param(Topic::SEARCH_GETTER, $topicIds);
            }

            $this->getParams()->setParamsP2P(Topic::POST_TYPE, Topic::SEARCH_GETTER, [
                'ID' => $topicIds,
                '!p2p_from' => null,
                'direction' => 'to',
            ]);
        }

        if (!empty($request->get_param(Product::SEARCH_GETTER))) {
            $products = !is_array($request->get_param(Product::SEARCH_GETTER)) ? [$request->get_param(Product::SEARCH_GETTER)] : $request->get_param(Product::SEARCH_GETTER);
            $productIds = [];
            foreach ($products as $product) {
                $product = get_page_by_path($product, ARRAY_A, Product::POST_TYPE);
                /** @var array|null $product */

                if (!empty($product)) {
                    $productIds[] = $product['ID'];
                }
            }

            if (!empty($productIds)) {
                $request->set_param(Product::SEARCH_GETTER, $productIds);
            }

            $this->getParams()->setParamsP2P(Product::POST_TYPE, Product::SEARCH_GETTER, [
                'ID' => $productIds,
                '!p2p_from' => null,
                'direction' => 'to',
            ]);
        }

        if (!empty($request->get_param(Keyword::TAXONOMY_NAME))) {
            $this->getParams()->setParamsTaxonomy(Keyword::TAXONOMY_NAME, Keyword::TAXONOMY_NAME, [
                [
                    'field' => 'slug',
                    'terms' => (!is_array($request->get_param(Keyword::TAXONOMY_NAME))) ? [$request->get_param(Keyword::TAXONOMY_NAME)] : $request->get_param(Keyword::TAXONOMY_NAME)
                ]
            ]);
        }

        if (!empty($request->get_param(self::API_QUERY_SEARCH))) {
            $this->getParams()->setSearchKeywords(self::API_QUERY_SEARCH);
        }

        return parent::getResponse($request, $query); // TODO: Change the autogenerated stub
    }

    protected function query()
    {
        /** @var ResourceRepository $Repository */
        $Repository = new ResourceRepository();

        $args = [
            'paged' => $this->getParams()->getPage(),
            'posts_per_page' => $this->getParams()->getPerPage(),
            'post_status' => ['publish'],
            'fields' => 'ids',
            'debug' => false,
        ];

        if (!empty($this->getParams()->getParams('meta_query'))) {
            $args = array_merge($args, ['meta_query' => $this->getParams()->getParams('meta_query')]);
        }

        $foundPosts = true;
        $maxNumPages = true;

        $posts = $Repository->findBy($args, $this->getParams(), $foundPosts, $maxNumPages);

        $this->getParams()->setFoundPosts($foundPosts);
        $this->getParams()->setMaxNumPages($maxNumPages);

        return $posts;
    }
}