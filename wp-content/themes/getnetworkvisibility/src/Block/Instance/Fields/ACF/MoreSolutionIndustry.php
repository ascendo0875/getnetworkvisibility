<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class MoreSolutionIndustry {

    const DATAPOST_INDUSTRY_LABEL = "Industry";
    const DATAPOST_INDUSTRY_VALUE = "industry";

    const DATAPOST_SOLUTION_LABEL = "Solution";
    const DATAPOST_SOLUTION_VALUE = "solution";

    const DATASOURCE_CONNECT_TO_CURRENT_POST_LABEL = "Connect to current post";
    const DATASOURCE_CONNECT_TO_CURRENT_POST_VALUE = "Connect to current post";

    const DATASOURCE_RELATED_LABEL = "Related";
    const DATASOURCE_RELATED_VALUE = "Related";

    const DATASOURCE_MANUAL_LABEL = "Manual";
    const DATASOURCE_MANUAL_VALUE = "Manual";

    /**
     * @var MoreSolutionIndustry[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return MoreSolutionIndustry
     */
    public static function getInstance($postId = false, $blockId = false): MoreSolutionIndustry
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof MoreSolutionIndustry) {
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
    private $isIndustry = null;

    /**
     * @var bool 
     */
    private $isSolution = null;

    /**
    * @var array|false
    */
    private $dataPost = null;

    /**
     * @var bool 
     */
    private $isConnectToCurrentPost = null;

    /**
     * @var bool 
     */
    private $isRelated = null;

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
    private $solutions = null;

    /**
    * @var array|false
    */
    private $industries = null;

    /**
    * @var array|false
    */
    private $relaters = null;

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
    public function isIndustry() {
        if((is_null($this->isIndustry)  || (is_admin() && acf_is_block_editor()))) {
            $this->setIndustry(in_array(self::DATAPOST_INDUSTRY_VALUE, $this->getDataPost()));
        }
        
        return $this->isIndustry;
    }
    
    /**
     * @param bool $industry 
     * @return $this
     */
    public function setIndustry(bool $industry): self
    {
        $this->isIndustry = !empty($industry) ? $industry : false;
        
        return $this;
    }
    
    /**
     * @return bool 
     */
    public function isSolution() {
        if((is_null($this->isSolution)  || (is_admin() && acf_is_block_editor()))) {
            $this->setSolution(in_array(self::DATAPOST_SOLUTION_VALUE, $this->getDataPost()));
        }
        
        return $this->isSolution;
    }
    
    /**
     * @param bool $solution 
     * @return $this
     */
    public function setSolution(bool $solution): self
    {
        $this->isSolution = !empty($solution) ? $solution : false;
        
        return $this;
    }
    
    /**
     * @return array|false
     */
    public function getDataPost()
    {
        if((is_null($this->dataPost) || (is_admin() && acf_is_block_editor()))) {
            $dataPost = get_field('data_post');

            $this->setDataPost(!empty($dataPost) ? $dataPost : []);
        }

        return $this->dataPost;
    }

    /**
     * @param array|false $dataPost
     * @return $this
     */
    public function setDataPost($dataPost): self
    {
        $this->dataPost = $dataPost;

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
    public function isRelated() {
        if((is_null($this->isRelated)  || (is_admin() && acf_is_block_editor()))) {
            $this->setRelated(($this->getDataSource() === self::DATASOURCE_RELATED_VALUE));
        }
        
        return $this->isRelated;
    }
    
    /**
     * @param bool $related 
     * @return $this
     */
    public function setRelated(bool $related): self
    {
        $this->isRelated = !empty($related) ? $related : false;
        
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

            $this->setDataSource(!empty($dataSource) ? $dataSource : "Related");
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
    public function getSolutions()
    {
        if((is_null($this->solutions) || (is_admin() && acf_is_block_editor()))) {
            $solutions = get_field('solutions');
            
            $this->setSolutions(!empty($solutions) ? $solutions : null);
        }

        return $this->solutions;
    }
    
    /**
     * @param array|false $solutions
     * @return $this
     */
    public function setSolutions($solutions): self
    {
        $this->solutions = $solutions;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getIndustries()
    {
        if((is_null($this->industries) || (is_admin() && acf_is_block_editor()))) {
            $industries = get_field('industries');
            
            $this->setIndustries(!empty($industries) ? $industries : null);
        }

        return $this->industries;
    }
    
    /**
     * @param array|false $industries
     * @return $this
     */
    public function setIndustries($industries): self
    {
        $this->industries = $industries;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getRelaters()
    {
        if((is_null($this->relaters) || (is_admin() && acf_is_block_editor()))) {
            $relaters = get_field('relaters');
            
            $this->setRelaters(!empty($relaters) ? $relaters : null);
        }

        return $this->relaters;
    }
    
    /**
     * @param array|false $relaters
     * @return $this
     */
    public function setRelaters($relaters): self
    {
        $this->relaters = $relaters;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getLimit()
    {
        if((is_null($this->limit) || (is_admin() && acf_is_block_editor()))) {
            $limit = get_field('limit');

            $this->setLimit(!empty($limit) ? $limit : 5);
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