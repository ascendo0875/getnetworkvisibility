<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class FindTheResources {

    /**
     * @var FindTheResources[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return FindTheResources
     */
    public static function getInstance($postId = false, $blockId = false): FindTheResources
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof FindTheResources) {
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
    private $label = null;

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
    public function getLabel()
    {
        if((is_null($this->label) || (is_admin() && acf_is_block_editor()))) {
            $label = get_field('label');

            $this->setLabel(!empty($label) ? $label : "");
        }

        return $this->label;
    }

    /**
     * @param string|false $label
     * @return $this
     */
    public function setLabel($label): self
    {
        $this->label = !empty($label) ? $label : false;

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