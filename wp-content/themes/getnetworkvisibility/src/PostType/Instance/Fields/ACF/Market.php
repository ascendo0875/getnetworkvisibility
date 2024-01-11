<?php
namespace FINNPartners\Theme\PostType\Instance\Fields\ACF;

class Market {


    /**
     * @var Market[]
     */
    private static $instaces = [];

    /**
     * @param int $postId
     * @return Market
     */
    public static function getInstance(int $postId): Market
    {
        if(!isset(self::$instaces[$postId]) || !self::$instaces[$postId] instanceof Market) {
            self::$instaces[$postId] = new self($postId);
        }

        return self::$instaces[$postId];
    }

    /**
     * @var int
     */
    private $postId;

    /**
     * @param int $postId
     */
    public function __construct(int $postId) {
        $this->setPostId($postId);
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
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
    
}