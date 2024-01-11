<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\CustomerFields;

class Customer {

    /**
     * @var CustomerFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new CustomerFields($postId));
    }
    
    /**
     * @return CustomerFields
     */
    public function getFields(): CustomerFields
    {
        return $this->fields;
    }
    
    /**
     * @param CustomerFields $fields
     * @return $this
     */
    protected function setFields(CustomerFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}