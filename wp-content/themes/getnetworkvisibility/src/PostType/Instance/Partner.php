<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\PartnerFields;

class Partner {

    /**
     * @var PartnerFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new PartnerFields($postId));
    }
    
    /**
     * @return PartnerFields
     */
    public function getFields(): PartnerFields
    {
        return $this->fields;
    }
    
    /**
     * @param PartnerFields $fields
     * @return $this
     */
    protected function setFields(PartnerFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}