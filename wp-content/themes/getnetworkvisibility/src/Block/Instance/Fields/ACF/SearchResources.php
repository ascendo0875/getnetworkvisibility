<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class SearchResources {

    /**
     * @var SearchResources[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return SearchResources
     */
    public static function getInstance($postId = false, $blockId = false): SearchResources
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof SearchResources) {
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
    private $copy = null;

    /**
    * @var bool|false
    */
    private $whenLoadingPagesApplyScrolling = null;

    /**
    * @var bool|false
    */
    private $redirectOnSearchPage = null;

    /**
    * @var bool|false
    */
    private $connectedToCurrentPost = null;

    /**
    * @var bool|false
    */
    private $filters = null;

    /**
    * @var bool|false
    */
    private $filtersBySolution = null;

    /**
    * @var bool|false
    */
    private $filtersByIndustry = null;

    /**
    * @var bool|false
    */
    private $filtersByType = null;

    /**
    * @var bool|false
    */
    private $filtersByTopic = null;

    /**
    * @var bool|false
    */
    private $filtersByProduct = null;

    /**
    * @var bool|false
    */
    private $filtersByKeyword = null;

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
    public function isWhenLoadingPagesApplyScrolling()
    {
        if((is_null($this->whenLoadingPagesApplyScrolling) || (is_admin() && acf_is_block_editor()))) {
            $whenLoadingPagesApplyScrolling = get_field('when_loading_pages_apply_scrolling');
            
            $whenLoadingPagesApplyScrolling = boolval($whenLoadingPagesApplyScrolling);
            
            $this->setWhenLoadingPagesApplyScrolling($whenLoadingPagesApplyScrolling);
        }

        return $this->whenLoadingPagesApplyScrolling;
    }
    
    /**
     * @param bool $whenLoadingPagesApplyScrolling
     * @return $this
     */
    public function setWhenLoadingPagesApplyScrolling(bool $whenLoadingPagesApplyScrolling): self
    {
        $this->whenLoadingPagesApplyScrolling = $whenLoadingPagesApplyScrolling;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isRedirectOnSearchPage()
    {
        if((is_null($this->redirectOnSearchPage) || (is_admin() && acf_is_block_editor()))) {
            $redirectOnSearchPage = get_field('redirect_on_search_page');
            
            $redirectOnSearchPage = boolval($redirectOnSearchPage);
            
            $this->setRedirectOnSearchPage($redirectOnSearchPage);
        }

        return $this->redirectOnSearchPage;
    }
    
    /**
     * @param bool $redirectOnSearchPage
     * @return $this
     */
    public function setRedirectOnSearchPage(bool $redirectOnSearchPage): self
    {
        $this->redirectOnSearchPage = $redirectOnSearchPage;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isConnectedToCurrentPost()
    {
        if((is_null($this->connectedToCurrentPost) || (is_admin() && acf_is_block_editor()))) {
            $connectedToCurrentPost = get_field('connected_to_current_post');
            
            $connectedToCurrentPost = boolval($connectedToCurrentPost);
            
            $this->setConnectedToCurrentPost($connectedToCurrentPost);
        }

        return $this->connectedToCurrentPost;
    }
    
    /**
     * @param bool $connectedToCurrentPost
     * @return $this
     */
    public function setConnectedToCurrentPost(bool $connectedToCurrentPost): self
    {
        $this->connectedToCurrentPost = $connectedToCurrentPost;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFilters()
    {
        if((is_null($this->filters) || (is_admin() && acf_is_block_editor()))) {
            $filters = get_field('filters');
            
            $filters = boolval($filters);
            
            $this->setFilters($filters);
        }

        return $this->filters;
    }
    
    /**
     * @param bool $filters
     * @return $this
     */
    public function setFilters(bool $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFiltersBySolution()
    {
        if((is_null($this->filtersBySolution) || (is_admin() && acf_is_block_editor()))) {
            $filtersBySolution = get_field('filters_by_solution');
            
            $filtersBySolution = boolval($filtersBySolution);
            
            $this->setFiltersBySolution($filtersBySolution);
        }

        return $this->filtersBySolution;
    }
    
    /**
     * @param bool $filtersBySolution
     * @return $this
     */
    public function setFiltersBySolution(bool $filtersBySolution): self
    {
        $this->filtersBySolution = $filtersBySolution;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFiltersByIndustry()
    {
        if((is_null($this->filtersByIndustry) || (is_admin() && acf_is_block_editor()))) {
            $filtersByIndustry = get_field('filters_by_industry');
            
            $filtersByIndustry = boolval($filtersByIndustry);
            
            $this->setFiltersByIndustry($filtersByIndustry);
        }

        return $this->filtersByIndustry;
    }
    
    /**
     * @param bool $filtersByIndustry
     * @return $this
     */
    public function setFiltersByIndustry(bool $filtersByIndustry): self
    {
        $this->filtersByIndustry = $filtersByIndustry;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFiltersByType()
    {
        if((is_null($this->filtersByType) || (is_admin() && acf_is_block_editor()))) {
            $filtersByType = get_field('filters_by_type');
            
            $filtersByType = boolval($filtersByType);
            
            $this->setFiltersByType($filtersByType);
        }

        return $this->filtersByType;
    }
    
    /**
     * @param bool $filtersByType
     * @return $this
     */
    public function setFiltersByType(bool $filtersByType): self
    {
        $this->filtersByType = $filtersByType;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFiltersByTopic()
    {
        if((is_null($this->filtersByTopic) || (is_admin() && acf_is_block_editor()))) {
            $filtersByTopic = get_field('filters_by_topic');
            
            $filtersByTopic = boolval($filtersByTopic);
            
            $this->setFiltersByTopic($filtersByTopic);
        }

        return $this->filtersByTopic;
    }
    
    /**
     * @param bool $filtersByTopic
     * @return $this
     */
    public function setFiltersByTopic(bool $filtersByTopic): self
    {
        $this->filtersByTopic = $filtersByTopic;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFiltersByProduct()
    {
        if((is_null($this->filtersByProduct) || (is_admin() && acf_is_block_editor()))) {
            $filtersByProduct = get_field('filters_by_product');
            
            $filtersByProduct = boolval($filtersByProduct);
            
            $this->setFiltersByProduct($filtersByProduct);
        }

        return $this->filtersByProduct;
    }
    
    /**
     * @param bool $filtersByProduct
     * @return $this
     */
    public function setFiltersByProduct(bool $filtersByProduct): self
    {
        $this->filtersByProduct = $filtersByProduct;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFiltersByKeyword()
    {
        if((is_null($this->filtersByKeyword) || (is_admin() && acf_is_block_editor()))) {
            $filtersByKeyword = get_field('filters_by_keyword');
            
            $filtersByKeyword = boolval($filtersByKeyword);
            
            $this->setFiltersByKeyword($filtersByKeyword);
        }

        return $this->filtersByKeyword;
    }
    
    /**
     * @param bool $filtersByKeyword
     * @return $this
     */
    public function setFiltersByKeyword(bool $filtersByKeyword): self
    {
        $this->filtersByKeyword = $filtersByKeyword;

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