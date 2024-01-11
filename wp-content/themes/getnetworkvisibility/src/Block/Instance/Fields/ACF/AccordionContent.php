<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;

class AccordionContent {

    /**
     * @var AccordionContent[]
     */
    private static $instaces = [];

    public static function getInstance(int $postId, string $blockId = ""): AccordionContent
    {
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof AccordionContent) {
            self::$instaces[$postId][$blockId] = new self($postId);
        }

        return self::$instaces[$postId][$blockId];
    }

    /**
     * @var int
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
    * @var bool|false
    */
    private $expended = null;

    public function __construct(int $postId, string $blockId = "") {
        $this->setPostId($postId)
                ->setBlockId($blockId);
    }

    /**
     * @return int
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
     * @return string|false
     */
    public function isExpended()
    {
        if((is_null($this->expended) || (is_admin() && acf_is_block_editor()))) {
            $expended = get_field('expended');

            if(empty($expended)) {
                $expended = false;
            }
            
            $this->setExpended($expended);
        }

        return $this->expended;
    }
    
    /**
     * @param bool $expended
     * @return $this
     */
    public function setExpended(bool $expended): self
    {
        $this->expended = $expended;

        return $this;
    }

    /**
     * @param int $postId
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