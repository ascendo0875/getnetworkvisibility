<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\ResourceFields;

class Resource {

    /**
     * @var ResourceFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new ResourceFields($postId));
    }
    
    /**
     * @return ResourceFields
     */
    public function getFields(): ResourceFields
    {
        return $this->fields;
    }
    
    /**
     * @param ResourceFields $fields
     * @return $this
     */
    protected function setFields(ResourceFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}