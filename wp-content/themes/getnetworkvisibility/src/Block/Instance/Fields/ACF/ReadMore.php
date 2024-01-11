<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class ReadMore {

    /**
     * @var ReadMore[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return ReadMore
     */
    public static function getInstance($postId = false, $blockId = false): ReadMore
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof ReadMore) {
            self::$instaces[$postId][$blockId] = new self($postId);
        }

        return self::$instaces[$postId][$blockId];
    }

    /**
     * @var int|false
     */
    private $postId;

    /**
     * @var string
     */
    private $blockId;

    /**
    * @var string|false
    */
    private $moreLabel = null;

    /**
    * @var string|false
    */
    private $lessLabel = null;

    /**
     * @param int|false $postId
     * @param string|false $blockId
     */
    public function __construct($postId = false, $blockId = false) {
        $this->setPostId($postId)
                ->setBlockId(empty($blockId) ? "block_".uniqid() : $blockId);
    }

    /**
     * @return int|false
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @return string
     */
    public function getBlockId(): string
    {
        return $this->blockId;
    }

    /**
     * @return string|false
     */
    public function getMoreLabel()
    {
        if((is_null($this->moreLabel) || (is_admin() && acf_is_block_editor()))) {
            $moreLabel = get_field('more_label');

            $this->setMoreLabel(!empty($moreLabel) ? $moreLabel : "Read More");
        }

        return $this->moreLabel;
    }

    /**
     * @param string|false $moreLabel
     * @return $this
     */
    public function setMoreLabel($moreLabel): self
    {
        $this->moreLabel = !empty($moreLabel) ? $moreLabel : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getLessLabel()
    {
        if((is_null($this->lessLabel) || (is_admin() && acf_is_block_editor()))) {
            $lessLabel = get_field('less_label');

            $this->setLessLabel(!empty($lessLabel) ? $lessLabel : "Read Less");
        }

        return $this->lessLabel;
    }

    /**
     * @param string|false $lessLabel
     * @return $this
     */
    public function setLessLabel($lessLabel): self
    {
        $this->lessLabel = !empty($lessLabel) ? $lessLabel : false;

        return $this;
    }

    /**
     * @param int|false $postId
     * @return $this
     */
    protected function setPostId(int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * @param string $blockId
     * @return $this
     */
    protected function setBlockId(string $blockId): self
    {
        $this->blockId = $blockId;

        return $this;
    }

}