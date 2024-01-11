<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\ValuesListFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class ValuesList extends Block {

    /**
     * @var ValuesListFields 
     */
    private $fields;
    
    /**
     * @param int|false $postId
     * @param array $block
     * @param bool $isPreview
     * @return void
     */
    public function __construct($postId = false, array $block = [], bool $isPreview = false)
    {        
        $this->setFields(new ValuesListFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return ValuesListFields
     */
    public function getFields(): ValuesListFields
    {
        return $this->fields;
    }
    
    /**
     * @param ValuesListFields $fields
     * @return $this
     */
    protected function setFields(ValuesListFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}