<?php
namespace FINNPartners\Theme\PostType\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Partner {

    const LABEL_HEROIMAGE = "Hero Image";
    const LABEL_WEBSITE = "Website";

    /**
     * @var Partner[]
     */
    private static $instaces = [];

    /**
     * @param int $postId
     * @return Partner
     */
    public static function getInstance(int $postId): Partner
    {
        if(!isset(self::$instaces[$postId]) || !self::$instaces[$postId] instanceof Partner) {
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
    private $heroImage = null;

    /**
    * @var string|false
    */
    private $website = null;

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
    public function getHeroImage() {
        if((is_null($this->heroImage) || (is_admin() && acf_is_block_editor()))) {
            $heroImage = get_field('hero_image', $this->getPostId());
            
            if(!empty($heroImage) && is_array($heroImage) && isset($heroImage['ID'])) {
                $heroImage = $heroImage['ID'];
            }
            
            $this->setHeroImage(!empty($heroImage) ? Media::getInstance($heroImage) : false);
        }

        return $this->heroImage;
    }

    /**
     * @param Media|false $heroImage
     * @return $this
     */
    public function setHeroImage($heroImage = false): self
    {
        $this->heroImage = ($heroImage instanceof Media) ? $heroImage : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getWebsite()
    {
        if((is_null($this->website) || (is_admin() && acf_is_block_editor()))) {
            $website = get_field('website', $this->getPostId());

            $this->setWebsite(!empty($website) ? $website : "");
        }

        return $this->website;
    }

    /**
     * @param string|false $website
     * @return $this
     */
    public function setWebsite($website): self
    {
        $this->website = !empty($website) ? $website : false;

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