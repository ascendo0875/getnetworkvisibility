<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class FeaturedList {

    const DATAPOSTTYPE_RESOURCE_LABEL = "Resource";
    const DATAPOSTTYPE_RESOURCE_VALUE = "Resource";

    const DATAPOSTTYPE_PARTNER_LABEL = "Partner";
    const DATAPOSTTYPE_PARTNER_VALUE = "Partner";

    const DATAPOSTTYPE_CUSTOMER_LABEL = "Customer";
    const DATAPOSTTYPE_CUSTOMER_VALUE = "Customer";

    const DATASOURCE_LATEST_LABEL = "Latest";
    const DATASOURCE_LATEST_VALUE = "Latest";

    const DATASOURCE_CONNECTED_WITH_CURRENT_POST_LABEL = "Connected with current post";
    const DATASOURCE_CONNECTED_WITH_CURRENT_POST_VALUE = "Connected with current post";

    const DATASOURCE_MANUAL_LABEL = "Manual";
    const DATASOURCE_MANUAL_VALUE = "Manual";

    /**
     * @var FeaturedList[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return FeaturedList
     */
    public static function getInstance($postId = false, $blockId = false): FeaturedList
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof FeaturedList) {
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
     * @var bool 
     */
    private $isResource = null;

    /**
     * @var bool 
     */
    private $isPartner = null;

    /**
     * @var bool 
     */
    private $isCustomer = null;

    /**
    * @var string|false
    */
    private $dataPostType = null;

    /**
     * @var bool 
     */
    private $isLatest = null;

    /**
     * @var bool 
     */
    private $isConnectedWithCurrentPost = null;

    /**
     * @var bool 
     */
    private $isManual = null;

    /**
    * @var string|false
    */
    private $dataSource = null;

    /**
    * @var array|false
    */
    private $resources = null;

    /**
    * @var array|false
    */
    private $partners = null;

    /**
    * @var array|false
    */
    private $customers = null;

    /**
    * @var string|false
    */
    private $limit = null;

    /**
    * @var bool|false
    */
    private $displayTitle = null;

    /**
    * @var bool|false
    */
    private $applyingUrlOnElement = null;

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
     * @return bool 
     */
    public function isResource() {
        if((is_null($this->isResource)  || (is_admin() && acf_is_block_editor()))) {
            $this->setResource(($this->getDataPostType() === self::DATAPOSTTYPE_RESOURCE_VALUE));
        }
        
        return $this->isResource;
    }
    
    /**
     * @param bool $resource 
     * @return $this
     */
    public function setResource(bool $resource): self
    {
        $this->isResource = !empty($resource) ? $resource : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isPartner() {
        if((is_null($this->isPartner)  || (is_admin() && acf_is_block_editor()))) {
            $this->setPartner(($this->getDataPostType() === self::DATAPOSTTYPE_PARTNER_VALUE));
        }
        
        return $this->isPartner;
    }
    
    /**
     * @param bool $partner 
     * @return $this
     */
    public function setPartner(bool $partner): self
    {
        $this->isPartner = !empty($partner) ? $partner : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isCustomer() {
        if((is_null($this->isCustomer)  || (is_admin() && acf_is_block_editor()))) {
            $this->setCustomer(($this->getDataPostType() === self::DATAPOSTTYPE_CUSTOMER_VALUE));
        }
        
        return $this->isCustomer;
    }
    
    /**
     * @param bool $customer 
     * @return $this
     */
    public function setCustomer(bool $customer): self
    {
        $this->isCustomer = !empty($customer) ? $customer : false;
        
        return $this;
    }
    
    /**
     * @return string|false
     */
    public function getDataPostType()
    {
        if((is_null($this->dataPostType) || (is_admin() && acf_is_block_editor()))) {
            $dataPostType = get_field('data_post_type');

            $this->setDataPostType(!empty($dataPostType) ? $dataPostType : "Resource");
        }

        return $this->dataPostType;
    }

    /**
     * @param string|false $dataPostType
     * @return $this
     */
    public function setDataPostType($dataPostType): self
    {
        $this->dataPostType = $dataPostType;

        return $this;
    }

    /**
     * @return bool 
     */
    public function isLatest() {
        if((is_null($this->isLatest)  || (is_admin() && acf_is_block_editor()))) {
            $this->setLatest(($this->getDataSource() === self::DATASOURCE_LATEST_VALUE));
        }
        
        return $this->isLatest;
    }
    
    /**
     * @param bool $latest 
     * @return $this
     */
    public function setLatest(bool $latest): self
    {
        $this->isLatest = !empty($latest) ? $latest : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isConnectedWithCurrentPost() {
        if((is_null($this->isConnectedWithCurrentPost)  || (is_admin() && acf_is_block_editor()))) {
            $this->setConnectedWithCurrentPost(($this->getDataSource() === self::DATASOURCE_CONNECTED_WITH_CURRENT_POST_VALUE));
        }
        
        return $this->isConnectedWithCurrentPost;
    }
    
    /**
     * @param bool $connectedWithCurrentPost 
     * @return $this
     */
    public function setConnectedWithCurrentPost(bool $connectedWithCurrentPost): self
    {
        $this->isConnectedWithCurrentPost = !empty($connectedWithCurrentPost) ? $connectedWithCurrentPost : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isManual() {
        if((is_null($this->isManual)  || (is_admin() && acf_is_block_editor()))) {
            $this->setManual(($this->getDataSource() === self::DATASOURCE_MANUAL_VALUE));
        }
        
        return $this->isManual;
    }
    
    /**
     * @param bool $manual 
     * @return $this
     */
    public function setManual(bool $manual): self
    {
        $this->isManual = !empty($manual) ? $manual : false;
        
        return $this;
    }
    
    /**
     * @return string|false
     */
    public function getDataSource()
    {
        if((is_null($this->dataSource) || (is_admin() && acf_is_block_editor()))) {
            $dataSource = get_field('data_source');

            $this->setDataSource(!empty($dataSource) ? $dataSource : "Latest");
        }

        return $this->dataSource;
    }

    /**
     * @param string|false $dataSource
     * @return $this
     */
    public function setDataSource($dataSource): self
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getResources()
    {
        if((is_null($this->resources) || (is_admin() && acf_is_block_editor()))) {
            $resources = get_field('resources');
            
            $this->setResources(!empty($resources) ? $resources : null);
        }

        return $this->resources;
    }
    
    /**
     * @param array|false $resources
     * @return $this
     */
    public function setResources($resources): self
    {
        $this->resources = $resources;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getPartners()
    {
        if((is_null($this->partners) || (is_admin() && acf_is_block_editor()))) {
            $partners = get_field('partners');
            
            $this->setPartners(!empty($partners) ? $partners : null);
        }

        return $this->partners;
    }
    
    /**
     * @param array|false $partners
     * @return $this
     */
    public function setPartners($partners): self
    {
        $this->partners = $partners;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getCustomers()
    {
        if((is_null($this->customers) || (is_admin() && acf_is_block_editor()))) {
            $customers = get_field('customers');
            
            $this->setCustomers(!empty($customers) ? $customers : null);
        }

        return $this->customers;
    }
    
    /**
     * @param array|false $customers
     * @return $this
     */
    public function setCustomers($customers): self
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getLimit()
    {
        if((is_null($this->limit) || (is_admin() && acf_is_block_editor()))) {
            $limit = get_field('limit');

            $this->setLimit(!empty($limit) ? $limit : 4);
        }

        return $this->limit;
    }

    /**
     * @param string|false $limit
     * @return $this
     */
    public function setLimit($limit): self
    {
        $this->limit = !empty($limit) ? $limit : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isDisplayTitle()
    {
        if((is_null($this->displayTitle) || (is_admin() && acf_is_block_editor()))) {
            $displayTitle = get_field('display_title');
            
            $displayTitle = boolval($displayTitle);
            
            $this->setDisplayTitle($displayTitle);
        }

        return $this->displayTitle;
    }
    
    /**
     * @param bool $displayTitle
     * @return $this
     */
    public function setDisplayTitle(bool $displayTitle): self
    {
        $this->displayTitle = $displayTitle;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isApplyingUrlOnElement()
    {
        if((is_null($this->applyingUrlOnElement) || (is_admin() && acf_is_block_editor()))) {
            $applyingUrlOnElement = get_field('applying_url_on_element');
            
            $applyingUrlOnElement = boolval($applyingUrlOnElement);
            
            $this->setApplyingUrlOnElement($applyingUrlOnElement);
        }

        return $this->applyingUrlOnElement;
    }
    
    /**
     * @param bool $applyingUrlOnElement
     * @return $this
     */
    public function setApplyingUrlOnElement(bool $applyingUrlOnElement): self
    {
        $this->applyingUrlOnElement = $applyingUrlOnElement;

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