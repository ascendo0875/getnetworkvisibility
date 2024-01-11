<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\ProductFields;

class Product {

    /**
     * @var ProductFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new ProductFields($postId));
    }
    
    /**
     * @return ProductFields
     */
    public function getFields(): ProductFields
    {
        return $this->fields;
    }
    
    /**
     * @param ProductFields $fields
     * @return $this
     */
    protected function setFields(ProductFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}