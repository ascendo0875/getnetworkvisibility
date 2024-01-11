<?php

namespace FINNPartners\Theme\PostType\Instance\Fields;

use FINNPartners\Theme\PostType\Instance\Fields\ACF\Resource;
use FINNPartners\Theme\PostType\Instance\Industry;
use FINNPartners\Theme\PostType\Register\Industry as IndustryRegister;
use FINNPartners\Theme\PostType\Register\Product as ProductRegister;
use FINNPartners\Theme\PostType\Register\Solution as SolutionRegister;
use FINNPartners\Theme\PostType\Instance\Product;
use FINNPartners\Theme\PostType\Instance\Solution;
use FINNPartners\Theme\PostType\Instance\Topic;
use FINNPartners\Theme\Taxonomy\Type;
use WP_Term;
use WpAdvanceCustomFieldsExtend\Service\Media;
use WpAdvanceCustomFieldsExtend\Service\Post2PostHelper;
use FINNPartners\Theme\PostType\Register\Topic as TopicRegister;
use FINNPartners\Theme\PostType\Register\Resource as ResourceRegister;

class ResourceFields extends Resource
{

    /**
     * @var string|false
     */
    private $title = null;

    /**
     * @var string|false
     */
    private $permalink = null;

    /**
     * @var Media|false
     */
    private $thumbnail = null;

    /**
     * @var string|false
     */
    private $excerpt = null;

    /**
     * @var string|false
     */
    private $slug = null;

    /**
     * string|false
     */
    private $date = null;

    /**
     * @var string[]|false
     */
    private $typesName = null;

    /**
     * @var Topic[]|false
     */
    private $topics = null;

    /**
     * @var Industry[]|false
     */
    private $industries = null;

    /**
     * @var Product[]|false
     */
    private $products = null;

    /**
     * @var Solution[]|false
     */
    private $solutions = null;

    /**
     * @var Topic|false
     */
    private $primaryTopics = null;

    /**
     * @var bool
     */
    private $video = null;

    /**
     * @var bool
     */
    private $youtube = null;

    /**
     * @var bool
     */
    private $vimeo = null;

    /**
     * @return false|string
     */
    public function getTitle()
    {
        if (is_null($this->title)) {
            $title = get_the_title($this->getPostId());

            $this->setTitle(!empty($title) ? $title : false);
        }

        return $this->title;
    }

    /**
     * @param false|string $title
     * @return Resource
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return false|string
     */
    public function getPermalink()
    {
        if (is_null($this->permalink)) {
            $permalink = get_permalink($this->getPostId());

            $this->setPermalink(!empty($permalink) ? $permalink : false);
        }

        return $this->permalink;
    }

    /**
     * @param false|string $permalink
     * @return Resource
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
        return $this;
    }

    /**
     * @return false|Media
     */
    public function getThumbnail()
    {
        if (is_null($this->thumbnail)) {
            $thumbnail = get_post_thumbnail_id($this->getPostId());

            $this->setThumbnail(!empty($thumbnail) ? Media::getInstance($thumbnail) : false);
        }

        return $this->thumbnail;
    }

    /**
     * @param false|Media $thumbnail
     * @return Resource
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * @return false|string
     */
    public function getExcerpt()
    {
        if (is_null($this->excerpt)) {
            $excerpt = get_the_excerpt($this->getPostId());

            if(empty($excerpt)) {
                $excerpt = wp_strip_all_tags(apply_filters('the_content', get_post_field('post_content', $this->getPostId())));
            }

            $subExcerpt = substr(esc_attr($excerpt), 0, 170);
            if($subExcerpt && strlen($subExcerpt) !== strlen($excerpt)) {
                $subExcerpt .= ' ...';
            }

            $excerpt = $subExcerpt;

            $this->setExcerpt(!empty($excerpt) ? $excerpt : false);
        }

        return $this->excerpt;
    }

    /**
     * @param false|string $excerpt
     * @return Resource
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    /**
     * @return false|string
     */
    public function getSlug()
    {
        if (is_null($this->slug)) {
            $slug = get_post_field('post_name', $this->getPostId());

            $this->setSlug(!empty($slug) ? $slug : false);
        }

        return $this->slug;
    }

    /**
     * @param false|string $slug
     * @return Resource
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return false|string
     */
    public function getDate()
    {
        if (is_null($this->date)) {
            $date = get_the_date(get_option('date_format'), $this->getPostId());

            $this->setDate($date);
        }

        return $this->date;
    }

    /**
     * @param false|string $date
     * @return Resource
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return false|string[]
     */
    public function getTypesName()
    {
        if (empty($this->typesName)) {
            $typesName = false;
            $getTypes = wp_get_post_terms($this->getPostId(), Type::TAXONOMY_NAME);

            if (!empty($getTypes)) {
                $typesName = [];

                foreach ($getTypes as $type) {
                    /** @var WP_Term $type */
                    $typesName[] = $type->name;
                }
            }

            $this->setTypesName($typesName);
        }

        return $this->typesName;
    }

    /**
     * @param false|string[] $typesName
     * @return ResourceFields
     */
    public function setTypesName($typesName)
    {
        $this->typesName = $typesName;
        return $this;
    }

    /**
     * @return false|Topic
     */
    public function getPrimaryTopics()
    {
        if (is_null($this->primaryTopics)) {
            $primaryTopics = false;

            if ($this->getTopics()) {
                $primaryTopics = array_values($this->getTopics())[0];
            }

            $this->setPrimaryTopics($primaryTopics);
        }
        return $this->primaryTopics;
    }

    /**
     * @param false|Topic $primaryTopics
     * @return ResourceFields
     */
    public function setPrimaryTopics($primaryTopics)
    {
        $this->primaryTopics = $primaryTopics;
        return $this;
    }

    /**
     * @return false|Topic[]
     */
    public function getTopics()
    {
        if (is_null($this->topics)) {
            $Post2PostHelper = Post2PostHelper::getInstances(ResourceRegister::POST_TYPE, TopicRegister::POST_TYPE);
            $topics = $Post2PostHelper->getPostsLinked($this->getPostId());
            $topics = !empty($topics) ? $topics : false;

            if ($topics) {
                foreach ($topics as &$topic) {
                    $topic = new Topic($topic);
                    /** @var Topic $topic */
                }
            }

            $this->setTopics($topics);
        }

        return $this->topics;
    }

    /**
     * @param false|Topic[]
     * @return ResourceFields
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        if (is_null($this->video)) {
            $video = false;
            $allVideoTerms = get_terms(['taxonomy' => Type::TAXONOMY_NAME, 'meta_key' => 'is_video_type', 'meta_value' => 1, 'post_type' => ResourceRegister::POST_TYPE, 'fields' => 'ids']);

            if (!empty($allVideoTerms)) {
                $video = wp_get_post_terms($this->getPostId(), Type::TAXONOMY_NAME, ['include' => $allVideoTerms]);
                $video = (!empty($video) && count($video) > 0);
            }

            $this->setVideo($video);
        }
        return $this->video;
    }

    /**
     * @param bool $video
     * @return ResourceFields
     */
    public function setVideo(?bool $video): ResourceFields
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @return bool
     */
    public function isYoutube()
    {
        if (is_null($this->youtube)) {
            $youtube = !empty($this->getResourceUrl()) && strpos($this->getResourceUrl(), 'youtube.com') !== false;

            $this->setYoutube($youtube);
        }
        return $this->youtube;
    }

    /**
     * @param bool $youtube
     * @return ResourceFields
     */
    public function setYoutube(bool $youtube): ResourceFields
    {
        $this->youtube = $youtube;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVimeo()
    {
        if (is_null($this->video)) {
            $vimeo = (!empty($this->getResourceUrl()) && strpos($this->getResourceUrl(), 'vimeo.com') !== false);

            $this->setVimeo($vimeo);
        }
        return $this->vimeo;
    }

    /**
     * @param bool $vimeo
     * @return ResourceFields
     */
    public function setVimeo(bool $vimeo): ResourceFields
    {
        $this->vimeo = $vimeo;
        return $this;
    }

    /**
     * @return false|Industry[]
     */
    public function getIndustries()
    {
        if (is_null($this->industries)) {
            $Post2PostHelper = Post2PostHelper::getInstances(ResourceRegister::POST_TYPE, IndustryRegister::POST_TYPE);
            $industries = $Post2PostHelper->getPostsLinked($this->getPostId());
            $industries = !empty($industries) ? $industries : false;

            if ($industries) {
                foreach ($industries as &$industry) {
                    $industry = new Industry($industry);
                    /** @var Industry $industry */
                }
            }

            $this->setIndustries($industries);
        }

        return $this->industries;
    }

    /**
     * @param false|Industry[] $industries
     * @return ResourceFields
     */
    public function setIndustries($industries)
    {
        $this->industries = $industries;
        return $this;
    }

    /**
     * @return false|Product[]
     */
    public function getProducts()
    {
        if (is_null($this->products)) {
            $Post2PostHelper = Post2PostHelper::getInstances(ResourceRegister::POST_TYPE, ProductRegister::POST_TYPE);
            $products = $Post2PostHelper->getPostsLinked($this->getPostId());
            $products = !empty($products) ? $products : false;

            if ($products) {
                foreach ($products as &$product) {
                    $product = new Product($product);
                    /** @var Product $product */
                }
            }

            $this->setProducts($products);
        }

        return $this->products;
    }

    /**
     * @param false|Product[] $products
     * @return ResourceFields
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return false|Solution[]
     */
    public function getSolutions()
    {
        if (is_null($this->solutions)) {
            $Post2PostHelper = Post2PostHelper::getInstances(ResourceRegister::POST_TYPE, SolutionRegister::POST_TYPE);
            $solutions = $Post2PostHelper->getPostsLinked($this->getPostId());
            $solutions = !empty($solutions) ? $solutions : false;

            if ($solutions) {
                foreach ($solutions as &$solution) {
                    $solution = new Solution($solution);
                    /** @var Solution $solution */
                }
            }

            $this->setSolutions($solutions);
        }

        return $this->solutions;
    }

    /**
     * @param false|Solution[] $solutions
     * @return ResourceFields
     */
    public function setSolutions($solutions)
    {
        $this->solutions = $solutions;
        return $this;
    }
}