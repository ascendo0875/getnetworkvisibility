<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class SearchPartners {

    /**
     * @var SearchPartners[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return SearchPartners
     */
    public static function getInstance($postId = false, $blockId = false): SearchPartners
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof SearchPartners) {
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
    private $filtersByPartnerTypes = null;

    /**
    * @var bool|false
    */
    private $filtersByRegions = null;

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
    public function isFiltersByPartnerTypes()
    {
        if((is_null($this->filtersByPartnerTypes) || (is_admin() && acf_is_block_editor()))) {
            $filtersByPartnerTypes = get_field('filters_by_partner_types');
            
            $filtersByPartnerTypes = boolval($filtersByPartnerTypes);
            
            $this->setFiltersByPartnerTypes($filtersByPartnerTypes);
        }

        return $this->filtersByPartnerTypes;
    }
    
    /**
     * @param bool $filtersByPartnerTypes
     * @return $this
     */
    public function setFiltersByPartnerTypes(bool $filtersByPartnerTypes): self
    {
        $this->filtersByPartnerTypes = $filtersByPartnerTypes;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isFiltersByRegions()
    {
        if((is_null($this->filtersByRegions) || (is_admin() && acf_is_block_editor()))) {
            $filtersByRegions = get_field('filters_by_regions');
            
            $filtersByRegions = boolval($filtersByRegions);
            
            $this->setFiltersByRegions($filtersByRegions);
        }

        return $this->filtersByRegions;
    }
    
    /**
     * @param bool $filtersByRegions
     * @return $this
     */
    public function setFiltersByRegions(bool $filtersByRegions): self
    {
        $this->filtersByRegions = $filtersByRegions;

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