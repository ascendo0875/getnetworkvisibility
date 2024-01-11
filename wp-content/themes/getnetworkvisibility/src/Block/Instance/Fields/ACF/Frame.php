<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Frame {

    /**
     * @var Frame[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return Frame
     */
    public static function getInstance($postId = false, $blockId = false): Frame
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof Frame) {
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
    * @var bool|false
    */
    private $clearBackgroundOnMobile = null;

    /**
    * @var string|false
    */
    private $backgroundColor = null;

    /**
    * @var Media|false
    */
    private $backgroundImage = null;

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
    public function isClearBackgroundOnMobile()
    {
        if((is_null($this->clearBackgroundOnMobile) || (is_admin() && acf_is_block_editor()))) {
            $clearBackgroundOnMobile = get_field('clear_background_on_mobile');
            
            $clearBackgroundOnMobile = boolval($clearBackgroundOnMobile);
            
            $this->setClearBackgroundOnMobile($clearBackgroundOnMobile);
        }

        return $this->clearBackgroundOnMobile;
    }
    
    /**
     * @param bool $clearBackgroundOnMobile
     * @return $this
     */
    public function setClearBackgroundOnMobile(bool $clearBackgroundOnMobile): self
    {
        $this->clearBackgroundOnMobile = $clearBackgroundOnMobile;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getBackgroundColor()
    {
        if((is_null($this->backgroundColor) || (is_admin() && acf_is_block_editor()))) {
            $backgroundColor = get_field('background_color');

            $this->setBackgroundColor(!empty($backgroundColor) ? $backgroundColor : "");
        }

        return $this->backgroundColor;
    }

    /**
     * @param string|false $backgroundColor
     * @return $this
     */
    public function setBackgroundColor($backgroundColor): self
    {
        $this->backgroundColor = !empty($backgroundColor) ? $backgroundColor : false;

        return $this;
    }

    /**
     * @return Media|false
     */
    public function getBackgroundImage() {
        if((is_null($this->backgroundImage) || (is_admin() && acf_is_block_editor()))) {
            $backgroundImage = get_field('background_image');
            
            if(!empty($backgroundImage) && is_array($backgroundImage) && isset($backgroundImage['ID'])) {
                $backgroundImage = $backgroundImage['ID'];
            }
            
            $this->setBackgroundImage(!empty($backgroundImage) ? Media::getInstance($backgroundImage) : false);
        }

        return $this->backgroundImage;
    }

    /**
     * @param Media|false $backgroundImage
     * @return $this
     */
    public function setBackgroundImage($backgroundImage = false): self
    {
        $this->backgroundImage = ($backgroundImage instanceof Media) ? $backgroundImage : false;

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