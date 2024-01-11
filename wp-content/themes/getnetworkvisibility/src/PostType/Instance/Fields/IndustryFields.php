<?php
namespace FINNPartners\Theme\PostType\Instance\Fields;

use FINNPartners\Theme\PostType\Instance\Fields\ACF\Industry;
use WpAdvanceCustomFieldsExtend\Service\Media;

class IndustryFields extends Industry {
    
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
     * @return false|string
     */
    public function getTitle()
    {
        if(is_null($this->title)) {
            $title = get_the_title($this->getPostId());

            $this->setTitle(!empty($title) ? $title : false);
        }

        return $this->title;
    }

    /**
     * @param false|string $title
     * @return Industry
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
        if(is_null($this->permalink)) {
            $permalink = get_permalink($this->getPostId());

            $this->setPermalink(!empty($permalink) ? $permalink : false);
        }

        return $this->permalink;
    }

    /**
     * @param false|string $permalink
     * @return Industry
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
        if(is_null($this->thumbnail)) {
            $thumbnail = get_post_thumbnail_id($this->getPostId());

            $this->setThumbnail(!empty($thumbnail) ? Media::getInstance($thumbnail) : false);
        }

        return $this->thumbnail;
    }

    /**
     * @param false|Media $thumbnail
     * @return Industry
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
        if(is_null($this->excerpt)) {
            $excerpt = get_the_excerpt($this->getPostId());

            $this->setExcerpt(!empty($excerpt) ? $excerpt : false);
        }

        return $this->excerpt;
    }

    /**
     * @param false|string $excerpt
     * @return Industry
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
        if(is_null($this->slug)) {
            $slug = get_post_field('post_name', $this->getPostId());

            $this->setSlug(!empty($slug) ? $slug : false);
        }

        return $this->slug;
    }

    /**
     * @param false|string $slug
     * @return Industry
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
        if(is_null($this->date)) {
            $date = get_the_date(get_option('date_format'), $this->getPostId());

            $this->setDate($date);
        }

        return $this->date;
    }

    /**
     * @param false|string $date
     * @return Industry
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}