<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class CustomersFeatured {

    const DATASOURCE_LATEST_LABEL = "Latest";
    const DATASOURCE_LATEST_VALUE = "Latest";

    const DATASOURCE_MANUAL_SELECTION_LABEL = "Manual Selection";
    const DATASOURCE_MANUAL_SELECTION_VALUE = "Manual Selection";

    /**
     * @var CustomersFeatured[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return CustomersFeatured
     */
    public static function getInstance($postId = false, $blockId = false): CustomersFeatured
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof CustomersFeatured) {
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
    private $isLatest = null;

    /**
     * @var bool 
     */
    private $isManualSelection = null;

    /**
    * @var string|false
    */
    private $dataSource = null;

    /**
    * @var string|false
    */
    private $limit = null;

    /**
    * @var array|false
    */
    private $customers = null;

    /**
    * @var string|false
    */
    private $labelForCustomerCta = null;

    /**
    * @var bool|false
    */
    private $addCta = null;

    /**
    * @var string|false
    */
    private $labelCta = null;

    /**
    * @var string|false
    */
    private $linkCta = null;

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
    public function isManualSelection() {
        if((is_null($this->isManualSelection)  || (is_admin() && acf_is_block_editor()))) {
            $this->setManualSelection(($this->getDataSource() === self::DATASOURCE_MANUAL_SELECTION_VALUE));
        }
        
        return $this->isManualSelection;
    }
    
    /**
     * @param bool $manualSelection 
     * @return $this
     */
    public function setManualSelection(bool $manualSelection): self
    {
        $this->isManualSelection = !empty($manualSelection) ? $manualSelection : false;
        
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
     * @return string|false
     */
    public function getLimit()
    {
        if((is_null($this->limit) || (is_admin() && acf_is_block_editor()))) {
            $limit = get_field('limit');

            $this->setLimit(!empty($limit) ? $limit : 3);
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
    public function getLabelForCustomerCta()
    {
        if((is_null($this->labelForCustomerCta) || (is_admin() && acf_is_block_editor()))) {
            $labelForCustomerCta = get_field('label_for_customer_cta');

            $this->setLabelForCustomerCta(!empty($labelForCustomerCta) ? $labelForCustomerCta : "see how we work with %s");
        }

        return $this->labelForCustomerCta;
    }

    /**
     * @param string|false $labelForCustomerCta
     * @return $this
     */
    public function setLabelForCustomerCta($labelForCustomerCta): self
    {
        $this->labelForCustomerCta = !empty($labelForCustomerCta) ? $labelForCustomerCta : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isAddCta()
    {
        if((is_null($this->addCta) || (is_admin() && acf_is_block_editor()))) {
            $addCta = get_field('add_cta');
            
            $addCta = boolval($addCta);
            
            $this->setAddCta($addCta);
        }

        return $this->addCta;
    }
    
    /**
     * @param bool $addCta
     * @return $this
     */
    public function setAddCta(bool $addCta): self
    {
        $this->addCta = $addCta;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getLabelCta()
    {
        if((is_null($this->labelCta) || (is_admin() && acf_is_block_editor()))) {
            $labelCta = get_field('label_cta');

            $this->setLabelCta(!empty($labelCta) ? $labelCta : "See all security tech customers");
        }

        return $this->labelCta;
    }

    /**
     * @param string|false $labelCta
     * @return $this
     */
    public function setLabelCta($labelCta): self
    {
        $this->labelCta = !empty($labelCta) ? $labelCta : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getLinkCta()
    {
        if((is_null($this->linkCta) || (is_admin() && acf_is_block_editor()))) {
            $linkCta = get_field('link_cta');

            $this->setLinkCta(!empty($linkCta) ? $linkCta : "");
        }

        return $this->linkCta;
    }

    /**
     * @param string|false $linkCta
     * @return $this
     */
    public function setLinkCta($linkCta): self
    {
        $this->linkCta = !empty($linkCta) ? $linkCta : false;

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