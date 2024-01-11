<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\AccordionContentFields;

class AccordionContent {

    /**
     * @var AccordionContentFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @param array $block
     * @return void
     */
    public function __construct(int $postId, array $block)
    {
        $this->setFields(new AccordionContentFields($postId, $block['id']));
    }
    
    /**
     * @return AccordionContentFields
     */
    public function getFields(): AccordionContentFields
    {
        return $this->fields;
    }
    
    /**
     * @param AccordionContentFields $fields
     * @return $this
     */
    protected function setFields(AccordionContentFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}