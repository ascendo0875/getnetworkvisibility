<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Hero {

    const FORMTYPE_NINJA_FORM_LABEL = "Ninja Form";
    const FORMTYPE_NINJA_FORM_VALUE = "ninja";

    const FORMTYPE_HUBSPOT_FORM_LABEL = "HubSpot Form";
    const FORMTYPE_HUBSPOT_FORM_VALUE = "hubspot";

    const NINJAFORMS_CONTACT_ME_LABEL = "Contact Me";
    const NINJAFORMS_CONTACT_ME_VALUE = "1";

    const NINJAFORMS_GET_RESOURCES_LIKE_THIS_DELIVERED_TO_YOUR_INBOX_LABEL = "Get Resources Like This Delivered To Your Inbox";
    const NINJAFORMS_GET_RESOURCES_LIKE_THIS_DELIVERED_TO_YOUR_INBOX_VALUE = "2";

    /**
     * @var Hero[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return Hero
     */
    public static function getInstance($postId = false, $blockId = false): Hero
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof Hero) {
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
    * @var Media|false
    */
    private $backgroundImage = null;

    /**
    * @var string|false
    */
    private $heading = null;

    /**
    * @var string|false
    */
    private $subheading = null;

    /**
    * @var string|false
    */
    private $copy = null;

    /**
    * @var bool|false
    */
    private $addCustomBox = null;

    /**
     * @var bool 
     */
    private $isNinjaForm = null;

    /**
     * @var bool 
     */
    private $isHubSpotForm = null;

    /**
    * @var string|false
    */
    private $formType = null;

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
    * @var string|false
    */
    private $hubspotPortalId = null;

    /**
    * @var string|false
    */
    private $hubspotFormId = null;

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
     * @return string|false
     */
    public function getSubheading()
    {
        if((is_null($this->subheading) || (is_admin() && acf_is_block_editor()))) {
            $subheading = get_field('subheading');

            $this->setSubheading(!empty($subheading) ? $subheading : "");
        }

        return $this->subheading;
    }

    /**
     * @param string|false $subheading
     * @return $this
     */
    public function setSubheading($subheading): self
    {
        $this->subheading = !empty($subheading) ? $subheading : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getCopy()
    {
        if((is_null($this->copy) || (is_admin() && acf_is_block_editor()))) {
            $copy = get_field('copy');

            $this->setCopy(!empty($copy) ? $copy : "");
        }

        return $this->copy;
    }

    /**
     * @param string|false $copy
     * @return $this
     */
    public function setCopy($copy): self
    {
        $this->copy = !empty($copy) ? $copy : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isAddCustomBox()
    {
        if((is_null($this->addCustomBox) || (is_admin() && acf_is_block_editor()))) {
            $addCustomBox = get_field('add_custom_box');
            
            $addCustomBox = boolval($addCustomBox);
            
            $this->setAddCustomBox($addCustomBox);
        }

        return $this->addCustomBox;
    }
    
    /**
     * @param bool $addCustomBox
     * @return $this
     */
    public function setAddCustomBox(bool $addCustomBox): self
    {
        $this->addCustomBox = $addCustomBox;

        return $this;
    }

    /**
     * @return bool 
     */
    public function isNinjaForm() {
        if((is_null($this->isNinjaForm)  || (is_admin() && acf_is_block_editor()))) {
            $this->setNinjaForm(($this->getFormType() === self::FORMTYPE_NINJA_FORM_VALUE));
        }
        
        return $this->isNinjaForm;
    }
    
    /**
     * @param bool $ninjaForm 
     * @return $this
     */
    public function setNinjaForm(bool $ninjaForm): self
    {
        $this->isNinjaForm = !empty($ninjaForm) ? $ninjaForm : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isHubSpotForm() {
        if((is_null($this->isHubSpotForm)  || (is_admin() && acf_is_block_editor()))) {
            $this->setHubSpotForm(($this->getFormType() === self::FORMTYPE_HUBSPOT_FORM_VALUE));
        }
        
        return $this->isHubSpotForm;
    }
    
    /**
     * @param bool $hubSpotForm 
     * @return $this
     */
    public function setHubSpotForm(bool $hubSpotForm): self
    {
        $this->isHubSpotForm = !empty($hubSpotForm) ? $hubSpotForm : false;
        
        return $this;
    }
    
    /**
     * @return string|false
     */
    public function getFormType()
    {
        if((is_null($this->formType) || (is_admin() && acf_is_block_editor()))) {
            $formType = get_field('form_type');

            $this->setFormType(!empty($formType) ? $formType : false);
        }

        return $this->formType;
    }

    /**
     * @param string|false $formType
     * @return $this
     */
    public function setFormType($formType): self
    {
        $this->formType = $formType;

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
     * @return string|false
     */
    public function getHubspotPortalId()
    {
        if((is_null($this->hubspotPortalId) || (is_admin() && acf_is_block_editor()))) {
            $hubspotPortalId = get_field('hubspot_portal_id');

            $this->setHubspotPortalId(!empty($hubspotPortalId) ? $hubspotPortalId : "");
        }

        return $this->hubspotPortalId;
    }

    /**
     * @param string|false $hubspotPortalId
     * @return $this
     */
    public function setHubspotPortalId($hubspotPortalId): self
    {
        $this->hubspotPortalId = !empty($hubspotPortalId) ? $hubspotPortalId : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getHubspotFormId()
    {
        if((is_null($this->hubspotFormId) || (is_admin() && acf_is_block_editor()))) {
            $hubspotFormId = get_field('hubspot_form_id');

            $this->setHubspotFormId(!empty($hubspotFormId) ? $hubspotFormId : "");
        }

        return $this->hubspotFormId;
    }

    /**
     * @param string|false $hubspotFormId
     * @return $this
     */
    public function setHubspotFormId($hubspotFormId): self
    {
        $this->hubspotFormId = !empty($hubspotFormId) ? $hubspotFormId : false;

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