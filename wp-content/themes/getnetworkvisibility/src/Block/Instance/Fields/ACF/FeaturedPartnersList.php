<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class FeaturedPartnersList {

    const DATASOURCE_LATEST_LABEL = "Latest";
    const DATASOURCE_LATEST_VALUE = "Latest";

    const DATASOURCE_CONNECTED_WITH_CURRENT_POST_LABEL = "Connected with current post";
    const DATASOURCE_CONNECTED_WITH_CURRENT_POST_VALUE = "Connected with current post";

    const DATASOURCE_MANUAL_LABEL = "Manual";
    const DATASOURCE_MANUAL_VALUE = "Manual";

    /**
     * @var FeaturedPartnersList[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return FeaturedPartnersList
     */
    public static function getInstance($postId = false, $blockId = false): FeaturedPartnersList
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof FeaturedPartnersList) {
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
    private $partners = null;

    /**
    * @var string|false
    */
    private $limit = null;

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