<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;

class Anchors {

    /**
     * @var Anchors[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return Anchors
     */
    public static function getInstance($postId = false, $blockId = false): Anchors
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof Anchors) {
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
    private $navigation = null;

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
    public function getNavigation()
    {
        if((is_null($this->navigation) || (is_admin() && acf_is_block_editor()))) {
            $navigation = get_field('navigation');

            $this->setNavigation(!empty($navigation) ? $navigation : false);
        }

        return $this->navigation;
    }

    /**
     * @param array|false $navigation
     * @return $this
     */
    public function setNavigation($navigation): self
    {
        $this->navigation = $navigation;

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