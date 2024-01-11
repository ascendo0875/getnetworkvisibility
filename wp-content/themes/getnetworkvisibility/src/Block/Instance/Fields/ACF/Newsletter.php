<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Newsletter {

    const NINJAFORMS_CONTACT_ME_LABEL = "Contact Me";
    const NINJAFORMS_CONTACT_ME_VALUE = "1";

    const NINJAFORMS_GET_RESOURCES_LIKE_THIS_DELIVERED_TO_YOUR_INBOX_LABEL = "Get Resources Like This Delivered To Your Inbox";
    const NINJAFORMS_GET_RESOURCES_LIKE_THIS_DELIVERED_TO_YOUR_INBOX_VALUE = "2";

    /**
     * @var Newsletter[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return Newsletter
     */
    public static function getInstance($postId = false, $blockId = false): Newsletter
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof Newsletter) {
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
    private $heading = null;

    /**
     * @var bool 
     */
    private $isContactMe = null;

    /**
     * @var bool 
     */
    private $isGetResourcesLikeThisDeliveredToYourInbox = null;

    /**
    * @var string|false
    */
    private $ninjaForms = null;

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
    public function getHeading()
    {
        if((is_null($this->heading) || (is_admin() && acf_is_block_editor()))) {
            $heading = get_field('heading');

            $this->setHeading(!empty($heading) ? $heading : "");
        }

        return $this->heading;
    }

    /**
     * @param string|false $heading
     * @return $this
     */
    public function setHeading($heading): self
    {
        $this->heading = !empty($heading) ? $heading : false;

        return $this;
    }

    /**
     * @return bool 
     */
    public function isContactMe() {
        if((is_null($this->isContactMe)  || (is_admin() && acf_is_block_editor()))) {
            $this->setContactMe(($this->getNinjaForms() === self::NINJAFORMS_CONTACT_ME_VALUE));
        }
        
        return $this->isContactMe;
    }
    
    /**
     * @param bool $contactMe 
     * @return $this
     */
    public function setContactMe(bool $contactMe): self
    {
        $this->isContactMe = !empty($contactMe) ? $contactMe : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isGetResourcesLikeThisDeliveredToYourInbox() {
        if((is_null($this->isGetResourcesLikeThisDeliveredToYourInbox)  || (is_admin() && acf_is_block_editor()))) {
            $this->setGetResourcesLikeThisDeliveredToYourInbox(($this->getNinjaForms() === self::NINJAFORMS_GET_RESOURCES_LIKE_THIS_DELIVERED_TO_YOUR_INBOX_VALUE));
        }
        
        return $this->isGetResourcesLikeThisDeliveredToYourInbox;
    }
    
    /**
     * @param bool $getResourcesLikeThisDeliveredToYourInbox 
     * @return $this
     */
    public function setGetResourcesLikeThisDeliveredToYourInbox(bool $getResourcesLikeThisDeliveredToYourInbox): self
    {
        $this->isGetResourcesLikeThisDeliveredToYourInbox = !empty($getResourcesLikeThisDeliveredToYourInbox) ? $getResourcesLikeThisDeliveredToYourInbox : false;
        
        return $this;
    }
    
    /**
     * @return string|false
     */
    public function getNinjaForms()
    {
        if((is_null($this->ninjaForms) || (is_admin() && acf_is_block_editor()))) {
            $ninjaForms = get_field('ninja_forms');

            $this->setNinjaForms(!empty($ninjaForms) ? $ninjaForms : false);
        }

        return $this->ninjaForms;
    }

    /**
     * @param string|false $ninjaForms
     * @return $this
     */
    public function setNinjaForms($ninjaForms): self
    {
        $this->ninjaForms = $ninjaForms;

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