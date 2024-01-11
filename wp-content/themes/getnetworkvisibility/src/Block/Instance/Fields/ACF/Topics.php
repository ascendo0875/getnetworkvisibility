<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Topics {

    /**
     * @var Topics[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return Topics
     */
    public static function getInstance($postId = false, $blockId = false): Topics
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof Topics) {
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
    private $addButtonShowMore = null;

    /**
    * @var string|false
    */
    private $labelButtonShowMore = null;

    /**
    * @var array|false
    */
    private $primaryTopics = null;

    /**
    * @var array|false
    */
    private $otherTopics = null;

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
    public function isAddButtonShowMore()
    {
        if((is_null($this->addButtonShowMore) || (is_admin() && acf_is_block_editor()))) {
            $addButtonShowMore = get_field('add_button_show_more');
            
            $addButtonShowMore = boolval($addButtonShowMore);
            
            $this->setAddButtonShowMore($addButtonShowMore);
        }

        return $this->addButtonShowMore;
    }
    
    /**
     * @param bool $addButtonShowMore
     * @return $this
     */
    public function setAddButtonShowMore(bool $addButtonShowMore): self
    {
        $this->addButtonShowMore = $addButtonShowMore;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getLabelButtonShowMore()
    {
        if((is_null($this->labelButtonShowMore) || (is_admin() && acf_is_block_editor()))) {
            $labelButtonShowMore = get_field('label_button_show_more');

            $this->setLabelButtonShowMore(!empty($labelButtonShowMore) ? $labelButtonShowMore : "Show more");
        }

        return $this->labelButtonShowMore;
    }

    /**
     * @param string|false $labelButtonShowMore
     * @return $this
     */
    public function setLabelButtonShowMore($labelButtonShowMore): self
    {
        $this->labelButtonShowMore = !empty($labelButtonShowMore) ? $labelButtonShowMore : false;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getPrimaryTopics()
    {
        if((is_null($this->primaryTopics) || (is_admin() && acf_is_block_editor()))) {
            $primaryTopics = get_field('primary_topics');
            
            $this->setPrimaryTopics(!empty($primaryTopics) ? $primaryTopics : null);
        }

        return $this->primaryTopics;
    }
    
    /**
     * @param array|false $primaryTopics
     * @return $this
     */
    public function setPrimaryTopics($primaryTopics): self
    {
        $this->primaryTopics = $primaryTopics;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getOtherTopics()
    {
        if((is_null($this->otherTopics) || (is_admin() && acf_is_block_editor()))) {
            $otherTopics = get_field('other_topics');
            
            $this->setOtherTopics(!empty($otherTopics) ? $otherTopics : null);
        }

        return $this->otherTopics;
    }
    
    /**
     * @param array|false $otherTopics
     * @return $this
     */
    public function setOtherTopics($otherTopics): self
    {
        $this->otherTopics = $otherTopics;

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