<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\IndustryFields;

class Industry {

    /**
     * @var IndustryFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new IndustryFields($postId));
    }
    
    /**
     * @return IndustryFields
     */
    public function getFields(): IndustryFields
    {
        return $this->fields;
    }
    
    /**
     * @param IndustryFields $fields
     * @return $this
     */
    protected function setFields(IndustryFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}