<?php
namespace FINNPartners\Theme\PostType\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Topic {

    const LABEL_ICON = "Icon";

    /**
     * @var Topic[]
     */
    private static $instaces = [];

    /**
     * @param int $postId
     * @return Topic
     */
    public static function getInstance(int $postId): Topic
    {
        if(!isset(self::$instaces[$postId]) || !self::$instaces[$postId] instanceof Topic) {
            self::$instaces[$postId] = new self($postId);
        }

        return self::$instaces[$postId];
    }

    /**
     * @var int
     */
    private $postId;

    /**
    * @var Media|false
    */
    private $icon = null;

    /**
     * @param int $postId
     */
    public function __construct(int $postId) {
        $this->setPostId($postId);
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @return Media|false
     */
    public function getIcon() {
        if((is_null($this->icon) || (is_admin() && acf_is_block_editor()))) {
            $icon = get_field('icon', $this->getPostId());
            
            if(!empty($icon) && is_array($icon) && isset($icon['ID'])) {
                $icon = $icon['ID'];
            }
            
            $this->setIcon(!empty($icon) ? Media::getInstance($icon) : false);
        }

        return $this->icon;
    }

    /**
     * @param Media|false $icon
     * @return $this
     */
    public function setIcon($icon = false): self
    {
        $this->icon = ($icon instanceof Media) ? $icon : false;

        return $this;
    }

    /**
     * @param int $postId
     * @return $this
     */
    protected function setPostId(int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }
    
}