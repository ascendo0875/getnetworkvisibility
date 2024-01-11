<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;

class ContentWithCallout {

    /**
     * @var ContentWithCallout[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return ContentWithCallout
     */
    public static function getInstance($postId = false, $blockId = false): ContentWithCallout
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof ContentWithCallout) {
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
    private $aside = null;

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
    public function getAside()
    {
        if((is_null($this->aside) || (is_admin() && acf_is_block_editor()))) {
            $aside = get_field('aside');

            $this->setAside(!empty($aside) ? $aside : "");
        }

        return $this->aside;
    }

    /**
     * @param string|false $aside
     * @return $this
     */
    public function setAside($aside): self
    {
        $this->aside = !empty($aside) ? $aside : false;

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