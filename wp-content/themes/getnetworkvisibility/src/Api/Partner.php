<?php

namespace FINNPartners\Theme\Api;

use FINNPartners\Theme\Api\AbstractClass\AbstractApiController;
use FINNPartners\Theme\Api\ParamsStructure\Partner as PartnerParamStructure;
use FINNPartners\Theme\Api\Repository\PartnerRepository;
use FINNPartners\Theme\PostType\Register\Partner as RegisterPostTypePartner;
use FINNPartners\Theme\Api\Data\Partner as PartnerData;
use FINNPartners\Theme\Taxonomy\Keyword;
use FINNPartners\Theme\Taxonomy\PartnerType;
use FINNPartners\Theme\Taxonomy\Region;
use FINNPartners\Theme\Taxonomy\Type;
use FpStructure\Entity\EntityInterface;
use WP_REST_Request;
use WP_REST_Server;

class Partner extends AbstractApiController
{
    public function __construct(string $paramStructure = PartnerParamStructure::class)
    {
        parent::__construct($paramStructure);
    }

    public static function url()
    {
        return implode('/', [get_home_url(), "wp-json", self::FP_STRUCTURE_NAMESPACE, RegisterPostTypePartner::POST_TYPE]);
    }

    /**
     * @return void
     */
    public function rest_api_init(): void
    {
        // TODO: Implement rest_api_init() method.
        register_rest_route(self::FP_STRUCTURE_NAMESPACE, RegisterPostTypePartner::POST_TYPE, [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'getResponse'],
            'permission_callback' => [$this, 'permissionCallBack'],
        ]);
    }

    public function getResponse(WP_REST_Request $request, ?EntityInterface $query = null)
    {
        $this->getParams()->setPostType(RegisterPostTypePartner::POST_TYPE);
        $this->getParams()->setEntityDataService([PartnerData::class, 'default']);

        if (!empty($request->get_param('order-name'))) {
            $this->getParams()->setParams('order-name', $request->get_param('order-name'));
        }

        if (!empty($request->get_param(PartnerType::TAXONOMY_NAME))) {
            $this->getParams()->setParamsTaxonomy(PartnerType::TAXONOMY_NAME, PartnerType::TAXONOMY_NAME, [
                [
                    'field' => 'slug',
                    'terms' => (!is_array($request->get_param(PartnerType::TAXONOMY_NAME))) ? [$request->get_param(PartnerType::TAXONOMY_NAME)] : $request->get_param(PartnerType::TAXONOMY_NAME)
                ]
            ]);
        }

        if (!empty($request->get_param(Region::TAXONOMY_NAME))) {
            $this->getParams()->setParamsTaxonomy(Region::TAXONOMY_NAME, Region::TAXONOMY_NAME, [
                [
                    'field' => 'slug',
                    'terms' => (!is_array($request->get_param(Region::TAXONOMY_NAME))) ? [$request->get_param(Region::TAXONOMY_NAME)] : $request->get_param(Region::TAXONOMY_NAME)
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
        /** @var PartnerRepository $Repository */
        $Repository = new PartnerRepository();

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