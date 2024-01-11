<?php
namespace FINNPartners\Theme\PostType\Instance\Fields\ACF;

class Post {


    /**
     * @var Post[]
     */
    private static $instaces = [];

    /**
     * @param int $postId
     * @return Post
     */
    public static function getInstance(int $postId): Post
    {
        if(!isset(self::$instaces[$postId]) || !self::$instaces[$postId] instanceof Post) {
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