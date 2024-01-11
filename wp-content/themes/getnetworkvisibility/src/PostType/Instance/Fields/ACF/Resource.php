<?php
namespace FINNPartners\Theme\PostType\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Resource {

    const LABEL_RESOURCEFILE = "Resource File";
    const LABEL_RESOURCEURL = "Resource URL";
    const LABEL_TECHPARTNER = "Tech Partner";
    const LABEL_DECRYPTION = "Decryption";
    const LABEL_STARTIMAGEOFTHEVIDEO = "Start image of the video";
    const LABEL_AUTHORNAME = "Name";
    const LABEL_AUTHORTITLE = "Title";

    /**
     * @var Resource[]
     */
    private static $instaces = [];

    /**
     * @param int $postId
     * @return Resource
     */
    public static function getInstance(int $postId): Resource
    {
        if(!isset(self::$instaces[$postId]) || !self::$instaces[$postId] instanceof Resource) {
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
    private $resourceFile = null;

    /**
    * @var string|false
    */
    private $resourceUrl = null;

    /**
    * @var bool|false
    */
    private $techPartner = null;

    /**
    * @var bool|false
    */
    private $decryption = null;

    /**
    * @var Media|false
    */
    private $startImageOfTheVideo = null;

    /**
    * @var string|false
    */
    private $authorName = null;

    /**
    * @var string|false
    */
    private $authorTitle = null;

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
    public function getResourceFile() {
        if((is_null($this->resourceFile) || (is_admin() && acf_is_block_editor()))) {
            $resourceFile = get_field('resource_file', $this->getPostId());
            
            if(!empty($resourceFile) && is_array($resourceFile) && isset($resourceFile['ID'])) {
                $resourceFile = $resourceFile['ID'];
            }
            
            $this->setResourceFile(!empty($resourceFile) ? Media::getInstance($resourceFile) : false);
        }

        return $this->resourceFile;
    }

    /**
     * @param Media|false $resourceFile
     * @return $this
     */
    public function setResourceFile($resourceFile = false): self
    {
        $this->resourceFile = ($resourceFile instanceof Media) ? $resourceFile : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getResourceUrl()
    {
        if((is_null($this->resourceUrl) || (is_admin() && acf_is_block_editor()))) {
            $resourceUrl = get_field('resource_url', $this->getPostId());

            $this->setResourceUrl(!empty($resourceUrl) ? $resourceUrl : "");
        }

        return $this->resourceUrl;
    }

    /**
     * @param string|false $resourceUrl
     * @return $this
     */
    public function setResourceUrl($resourceUrl): self
    {
        $this->resourceUrl = !empty($resourceUrl) ? $resourceUrl : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isTechPartner()
    {
        if((is_null($this->techPartner) || (is_admin() && acf_is_block_editor()))) {
            $techPartner = get_field('tech_partner', $this->getPostId());
            
            $techPartner = boolval($techPartner);
            
            $this->setTechPartner($techPartner);
        }

        return $this->techPartner;
    }
    
    /**
     * @param bool $techPartner
     * @return $this
     */
    public function setTechPartner(bool $techPartner): self
    {
        $this->techPartner = $techPartner;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isDecryption()
    {
        if((is_null($this->decryption) || (is_admin() && acf_is_block_editor()))) {
            $decryption = get_field('decryption', $this->getPostId());
            
            $decryption = boolval($decryption);
            
            $this->setDecryption($decryption);
        }

        return $this->decryption;
    }
    
    /**
     * @param bool $decryption
     * @return $this
     */
    public function setDecryption(bool $decryption): self
    {
        $this->decryption = $decryption;

        return $this;
    }

    /**
     * @return Media|false
     */
    public function getStartImageOfTheVideo() {
        if((is_null($this->startImageOfTheVideo) || (is_admin() && acf_is_block_editor()))) {
            $startImageOfTheVideo = get_field('start_image_of_the_video', $this->getPostId());
            
            if(!empty($startImageOfTheVideo) && is_array($startImageOfTheVideo) && isset($startImageOfTheVideo['ID'])) {
                $startImageOfTheVideo = $startImageOfTheVideo['ID'];
            }
            
            $this->setStartImageOfTheVideo(!empty($startImageOfTheVideo) ? Media::getInstance($startImageOfTheVideo) : false);
        }

        return $this->startImageOfTheVideo;
    }

    /**
     * @param Media|false $startImageOfTheVideo
     * @return $this
     */
    public function setStartImageOfTheVideo($startImageOfTheVideo = false): self
    {
        $this->startImageOfTheVideo = ($startImageOfTheVideo instanceof Media) ? $startImageOfTheVideo : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getAuthorName()
    {
        if((is_null($this->authorName) || (is_admin() && acf_is_block_editor()))) {
            $authorName = get_field('author_name', $this->getPostId());

            $this->setAuthorName(!empty($authorName) ? $authorName : "");
        }

        return $this->authorName;
    }

    /**
     * @param string|false $authorName
     * @return $this
     */
    public function setAuthorName($authorName): self
    {
        $this->authorName = !empty($authorName) ? $authorName : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getAuthorTitle()
    {
        if((is_null($this->authorTitle) || (is_admin() && acf_is_block_editor()))) {
            $authorTitle = get_field('author_title', $this->getPostId());

            $this->setAuthorTitle(!empty($authorTitle) ? $authorTitle : "");
        }

        return $this->authorTitle;
    }

    /**
     * @param string|false $authorTitle
     * @return $this
     */
    public function setAuthorTitle($authorTitle): self
    {
        $this->authorTitle = !empty($authorTitle) ? $authorTitle : false;

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