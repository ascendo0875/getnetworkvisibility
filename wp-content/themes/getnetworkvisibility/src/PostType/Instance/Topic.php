<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\TopicFields;

class Topic {

    /**
     * @var TopicFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new TopicFields($postId));
    }
    
    /**
     * @return TopicFields
     */
    public function getFields(): TopicFields
    {
        return $this->fields;
    }
    
    /**
     * @param TopicFields $fields
     * @return $this
     */
    protected function setFields(TopicFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}