<?php

namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\FeaturedListFields;
use FINNPartners\Theme\PostType\Instance\Partner;
use FINNPartners\Theme\PostType\Instance\Resource;
use FINNPartners\Theme\PostType\Instance\Customer;
use FINNPartners\Theme\PostType\Register\Resource as ResourcePostType;
use FINNPartners\Theme\PostType\Register\Partner as PartnerPostType;
use FINNPartners\Theme\PostType\Register\Customer as CustomerPostType;
use FINNPartners\Theme\Theme;
use WP_Query;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;
use WpAdvanceCustomFieldsExtend\Service\Media;
use WpAdvanceCustomFieldsExtend\Service\Post2PostHelper;
use WpAdvanceCustomFieldsExtend\Service\QueryHelper;

class FeaturedList extends Block
{

    /**
     * @var FeaturedListFields
     */
    private $fields;

    /**
     * @var Resource[]|Partner[]|false
     */
    private $articles = null;

    /**
     * @var bool
     */
    private $slider = null;

    /**
     * @var string|false
     */
    private $loadTemplateParts = null;

    /**
     * @param int|false $postId
     * @param array $block
     * @param bool $isPreview
     * @return void
     */
    public function __construct($postId = false, array $block = [], bool $isPreview = false)
    {
        $this->setFields(new FeaturedListFields($postId, !empty($block['id']) ? $block['id'] : false));

        parent::__construct($block);

        $this->setIsPreview($isPreview)->execute();
    }

    public function previewNotAvailableHTML(): void
    {
        if ($this->isPreview() && !$this->getArticles()) {
            parent::previewNotAvailableHTML(); // TODO: Change the autogenerated stub
        }
    }

    /**
     * @return false|Partner[]|Resource[]
     */
    public function getArticles()
    {
        if (is_null($this->articles)) {
            $articles = false;

            if ($this->getFields()->getDataPostType() && $this->getFields()->getDataSource()) {
                $queryHelper = new QueryHelper();
                $isQuery = false;
                $manualArticles = false;

                switch ($this->getFields()->getDataPostType()) {
                    case FeaturedListFields::DATAPOSTTYPE_PARTNER_VALUE:
                        $postType = PartnerPostType::POST_TYPE;
                        $classInstance = Partner::class;
                        if($this->getFields()->isManual()) {
                            $manualArticles = $this->getFields()->getPartners();
                            $isQuery = !empty($manualArticles);
                        }
                        break;
                    case FeaturedListFields::DATAPOSTTYPE_CUSTOMER_VALUE:
                        $postType = CustomerPostType::POST_TYPE;
                        $classInstance = Customer::class;
                        if($this->getFields()->isManual()) {
                            $manualArticles = $this->getFields()->getCustomers();
                            $isQuery = !empty($manualArticles);
                        }
                        break;
                    default:
                        $postType = ResourcePostType::POST_TYPE;
                        $classInstance = Resource::class;
                        if($this->getFields()->isManual()) {
                            $manualArticles = $this->getFields()->getResources();
                            $isQuery = !empty($manualArticles);
                        }
                        break;
                }

                if ($postType) {
                    switch ($this->getFields()->getDataSource()) {
                        case FeaturedListFields::DATASOURCE_MANUAL_VALUE:
                            if ($isQuery) {
                                $queryHelper->setArgs([
                                    'post_type' => [$postType],
                                    'post_status' => ['publish'],
                                    'posts_per_page' => count($manualArticles),
                                    'fields' => 'ids',
                                    'post__in' => $manualArticles,
                                    'orderby' => ['post__in' => 'asc'],
                                ]);
                            }
                            break;
                        case FeaturedListFields::DATASOURCE_CONNECTED_WITH_CURRENT_POST_VALUE:
                            $Post2PostHelper = Post2PostHelper::getInstances($postType);
                            $posts = $Post2PostHelper ? $Post2PostHelper->getPostsLinked() : false;
                            $isQuery = !empty($posts);

                            if ($isQuery) {
                                $queryHelper->setArgs([
                                    'post_type' => [$postType],
                                    'post_status' => ['publish'],
                                    'post__not_in' => [$this->getFields()->getPostId()],
                                    'post__in' => $posts,
                                    'posts_per_page' => $this->getFields()->getLimit(),
                                    'fields' => 'ids',
                                    'orderby' => ['post__in' => 'asc'],
                                ]);
                            }
                            break;
                        default:
                            $isQuery = true;

                            $queryHelper->setArgs([
                                'post_type' => [$postType],
                                'post__not_in' => [$this->getFields()->getPostId()],
                                'post_status' => ['publish'],
                                'posts_per_page' => $this->getFields()->getLimit(),
                                'fields' => 'ids',
                            ]);
                            break;
                    }
                }

                if ($isQuery) {
                    $articles = new WP_Query($queryHelper->getArgs());
                    $articles = $articles->have_posts() ? $articles->get_posts() : false;

                    if ($articles) {
                        foreach ($articles as &$article) {
                            /** @var int $article */
                            $article = new $classInstance($article);
                            /** @var Resource|Partner|Customer $article */

                            if (($article->getFields()->getThumbnail() instanceof Media)) {
                                $article->getFields()->getThumbnail()->setCrop(Theme::IMAGE_SIZES['featured_list']['name']);
                            }
                        }
                    }
                }
            }

            $this->setArticles($articles);
        }

        return $this->articles;
    }

    /**
     * @param false|Partner[]|Resource[] $articles
     * @return FeaturedList
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
        return $this;
    }

    /**
     * @return FeaturedListFields
     */
    public function getFields(): FeaturedListFields
    {
        return $this->fields;
    }

    /**
     * @param FeaturedListFields $fields
     * @return $this
     */
    protected function setFields(FeaturedListFields $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSlider(): bool
    {
        if (is_null($this->slider)) {
            $this->setSlider(in_array('is-style-slider', !empty($this->getCSSClasses()) ? $this->getCSSClasses() : []));
        }
        return $this->slider;
    }

    /**
     * @return false|string
     */
    public function getLoadTemplateParts()
    {
        if(is_null($this->loadTemplateParts)) {
            $loadTemplateParts = false;

            if($this->getFields()->getDataPostType()) {
                switch ($this->getFields()->getDataPostType()) {
                    case FeaturedListFields::DATAPOSTTYPE_PARTNER_VALUE:
                        $loadTemplateParts = file_exists(Theme::getInstance()->getPath() . "/template-parts/content/partner.php") ? 'partner' : 'article';
                        break;
                    case FeaturedListFields::DATAPOSTTYPE_RESOURCE_VALUE:
                        $loadTemplateParts = file_exists(Theme::getInstance()->getPath() . "/template-parts/content/resource.php") ? 'resource' : 'article';
                        break;
                    default:
                        $loadTemplateParts = 'article';
                        break;
                }
            }

            $this->setLoadTemplateParts($loadTemplateParts);
        }

        return $this->loadTemplateParts;
    }

    /**
     * @param false|string $loadTemplateParts
     * @return FeaturedList
     */
    public function setLoadTemplateParts($loadTemplateParts)
    {
        $this->loadTemplateParts = $loadTemplateParts;
        return $this;
    }

    /**
     * @param bool $slider
     * @return FeaturedList
     */
    public function setSlider(bool $slider): FeaturedList
    {
        $this->slider = $slider;
        return $this;
    }
}