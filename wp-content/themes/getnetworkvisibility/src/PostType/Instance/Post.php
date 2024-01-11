<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\PostFields;

class Post {

    /**
     * @var PostFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new PostFields($postId));
    }
    
    /**
     * @return PostFields
     */
    public function getFields(): PostFields
    {
        return $this->fields;
    }
    
    /**
     * @param PostFields $fields
     * @return $this
     */
    protected function setFields(PostFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}