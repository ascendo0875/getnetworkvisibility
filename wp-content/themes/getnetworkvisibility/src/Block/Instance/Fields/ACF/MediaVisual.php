<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class MediaVisual {

    const SCALE_SCALE_25__LABEL = "Scale 25%";
    const SCALE_SCALE_25__VALUE = "scale-25";

    const SCALE_SCALE_50__LABEL = "Scale 50%";
    const SCALE_SCALE_50__VALUE = "scale-50";

    const SCALE_SCALE_75__LABEL = "Scale 75%";
    const SCALE_SCALE_75__VALUE = "scale-75";

    const SCALE_SCALE_100__LABEL = "Scale 100%";
    const SCALE_SCALE_100__VALUE = "scale-100";

    /**
     * @var MediaVisual[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return MediaVisual
     */
    public static function getInstance($postId = false, $blockId = false): MediaVisual
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof MediaVisual) {
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
    private $caption = null;

    /**
    * @var Media|false
    */
    private $image = null;

    /**
    * @var string|false
    */
    private $videoUrl = null;

    /**
     * @var bool 
     */
    private $isScale25 = null;

    /**
     * @var bool 
     */
    private $isScale50 = null;

    /**
     * @var bool 
     */
    private $isScale75 = null;

    /**
     * @var bool 
     */
    private $isScale100 = null;

    /**
    * @var string|false
    */
    private $scale = null;

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
    public function getCaption()
    {
        if((is_null($this->caption) || (is_admin() && acf_is_block_editor()))) {
            $caption = get_field('caption');

            $this->setCaption(!empty($caption) ? $caption : "");
        }

        return $this->caption;
    }

    /**
     * @param string|false $caption
     * @return $this
     */
    public function setCaption($caption): self
    {
        $this->caption = !empty($caption) ? $caption : false;

        return $this;
    }

    /**
     * @return Media|false
     */
    public function getImage() {
        if((is_null($this->image) || (is_admin() && acf_is_block_editor()))) {
            $image = get_field('image');
            
            if(!empty($image) && is_array($image) && isset($image['ID'])) {
                $image = $image['ID'];
            }
            
            $this->setImage(!empty($image) ? Media::getInstance($image) : false);
        }

        return $this->image;
    }

    /**
     * @param Media|false $image
     * @return $this
     */
    public function setImage($image = false): self
    {
        $this->image = ($image instanceof Media) ? $image : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getVideoUrl()
    {
        if((is_null($this->videoUrl) || (is_admin() && acf_is_block_editor()))) {
            $videoUrl = get_field('video_url');

            $this->setVideoUrl(!empty($videoUrl) ? $videoUrl : "");
        }

        return $this->videoUrl;
    }

    /**
     * @param string|false $videoUrl
     * @return $this
     */
    public function setVideoUrl($videoUrl): self
    {
        $this->videoUrl = !empty($videoUrl) ? $videoUrl : false;

        return $this;
    }

    /**
     * @return bool 
     */
    public function isScale25() {
        if((is_null($this->isScale25)  || (is_admin() && acf_is_block_editor()))) {
            $this->setScale25(($this->getScale() === self::SCALE_SCALE_25__VALUE));
        }
        
        return $this->isScale25;
    }
    
    /**
     * @param bool $scale25 
     * @return $this
     */
    public function setScale25(bool $scale25): self
    {
        $this->isScale25 = !empty($scale25) ? $scale25 : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isScale50() {
        if((is_null($this->isScale50)  || (is_admin() && acf_is_block_editor()))) {
            $this->setScale50(($this->getScale() === self::SCALE_SCALE_50__VALUE));
        }
        
        return $this->isScale50;
    }
    
    /**
     * @param bool $scale50 
     * @return $this
     */
    public function setScale50(bool $scale50): self
    {
        $this->isScale50 = !empty($scale50) ? $scale50 : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isScale75() {
        if((is_null($this->isScale75)  || (is_admin() && acf_is_block_editor()))) {
            $this->setScale75(($this->getScale() === self::SCALE_SCALE_75__VALUE));
        }
        
        return $this->isScale75;
    }
    
    /**
     * @param bool $scale75 
     * @return $this
     */
    public function setScale75(bool $scale75): self
    {
        $this->isScale75 = !empty($scale75) ? $scale75 : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isScale100() {
        if((is_null($this->isScale100)  || (is_admin() && acf_is_block_editor()))) {
            $this->setScale100(($this->getScale() === self::SCALE_SCALE_100__VALUE));
        }
        
        return $this->isScale100;
    }
    
    /**
     * @param bool $scale100 
     * @return $this
     */
    public function setScale100(bool $scale100): self
    {
        $this->isScale100 = !empty($scale100) ? $scale100 : false;
        
        return $this;
    }
    
    /**
     * @return string|false
     */
    public function getScale()
    {
        if((is_null($this->scale) || (is_admin() && acf_is_block_editor()))) {
            $scale = get_field('scale');

            $this->setScale(!empty($scale) ? $scale : "scale-100");
        }

        return $this->scale;
    }

    /**
     * @param string|false $scale
     * @return $this
     */
    public function setScale($scale): self
    {
        $this->scale = $scale;

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