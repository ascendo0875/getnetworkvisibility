<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;

class Carousel {

    /**
     * @var Carousel[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return Carousel
     */
    public static function getInstance($postId = false, $blockId = false): Carousel
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof Carousel) {
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
    * @var array|false
    */
    private $carousel = null;

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
     * @return array|false
     */
    public function getCarousel()
    {
        if((is_null($this->carousel) || (is_admin() && acf_is_block_editor()))) {
            $carousel = get_field('carousel');

            $this->setCarousel(!empty($carousel) ? $carousel : false);
        }

        return $this->carousel;
    }

    /**
     * @param array|false $carousel
     * @return $this
     */
    public function setCarousel($carousel): self
    {
        $this->carousel = $carousel;

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