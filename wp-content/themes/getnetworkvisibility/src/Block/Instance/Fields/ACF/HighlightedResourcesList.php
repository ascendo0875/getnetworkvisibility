<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class HighlightedResourcesList {

    const DATASOURCE_LATEST_LABEL = "Latest";
    const DATASOURCE_LATEST_VALUE = "Latest";

    const DATASOURCE_CONNECT_TO_CURRENT_POST_LABEL = "Connect to current post";
    const DATASOURCE_CONNECT_TO_CURRENT_POST_VALUE = "Connect to current post";

    const DATASOURCE_MANUAL_LABEL = "Manual";
    const DATASOURCE_MANUAL_VALUE = "Manual";

    /**
     * @var HighlightedResourcesList[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return HighlightedResourcesList
     */
    public static function getInstance($postId = false, $blockId = false): HighlightedResourcesList
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof HighlightedResourcesList) {
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
    private $isConnectToCurrentPost = null;

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
    * @var string|false
    */
    private $limit = null;

    /**
    * @var array|false
    */
    private $keywordsTaxonomy = null;

    /**
    * @var array|false
    */
    private $typesTaxonomy = null;

    /**
    * @var bool|false
    */
    private $displayExcerpt = null;

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
    public function isConnectToCurrentPost() {
        if((is_null($this->isConnectToCurrentPost)  || (is_admin() && acf_is_block_editor()))) {
            $this->setConnectToCurrentPost(($this->getDataSource() === self::DATASOURCE_CONNECT_TO_CURRENT_POST_VALUE));
        }
        
        return $this->isConnectToCurrentPost;
    }
    
    /**
     * @param bool $connectToCurrentPost 
     * @return $this
     */
    public function setConnectToCurrentPost(bool $connectToCurrentPost): self
    {
        $this->isConnectToCurrentPost = !empty($connectToCurrentPost) ? $connectToCurrentPost : false;
        
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
    public function getKeywordsTaxonomy()
    {
        if((is_null($this->keywordsTaxonomy) || (is_admin() && acf_is_block_editor()))) {
            $keywordsTaxonomy = get_field('keywords_taxonomy');

            $this->setKeywordsTaxonomy(!empty($keywordsTaxonomy) ? $keywordsTaxonomy : null);
        }

        return $this->keywordsTaxonomy;
    }

    /**
     * @param array|false $keywordsTaxonomy
     * @return $this
     */
    public function setKeywordsTaxonomy($keywordsTaxonomy): self
    {
        $this->keywordsTaxonomy = !empty($keywordsTaxonomy) ? $keywordsTaxonomy : false;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getTypesTaxonomy()
    {
        if((is_null($this->typesTaxonomy) || (is_admin() && acf_is_block_editor()))) {
            $typesTaxonomy = get_field('types_taxonomy');

            $this->setTypesTaxonomy(!empty($typesTaxonomy) ? $typesTaxonomy : null);
        }

        return $this->typesTaxonomy;
    }

    /**
     * @param array|false $typesTaxonomy
     * @return $this
     */
    public function setTypesTaxonomy($typesTaxonomy): self
    {
        $this->typesTaxonomy = !empty($typesTaxonomy) ? $typesTaxonomy : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isDisplayExcerpt()
    {
        if((is_null($this->displayExcerpt) || (is_admin() && acf_is_block_editor()))) {
            $displayExcerpt = get_field('display_excerpt');
            
            $displayExcerpt = boolval($displayExcerpt);
            
            $this->setDisplayExcerpt($displayExcerpt);
        }

        return $this->displayExcerpt;
    }
    
    /**
     * @param bool $displayExcerpt
     * @return $this
     */
    public function setDisplayExcerpt(bool $displayExcerpt): self
    {
        $this->displayExcerpt = $displayExcerpt;

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