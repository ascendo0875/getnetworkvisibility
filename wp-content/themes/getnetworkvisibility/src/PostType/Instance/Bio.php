<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\BioFields;

class Bio {

    /**
     * @var BioFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new BioFields($postId));
    }
    
    /**
     * @return BioFields
     */
    public function getFields(): BioFields
    {
        return $this->fields;
    }
    
    /**
     * @param BioFields $fields
     * @return $this
     */
    protected function setFields(BioFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}