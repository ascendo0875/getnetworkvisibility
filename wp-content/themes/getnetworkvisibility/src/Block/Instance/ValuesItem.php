<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\ValuesItemFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class ValuesItem extends Block {

    /**
     * @var ValuesItemFields 
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
        $this->setFields(new ValuesItemFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return ValuesItemFields
     */
    public function getFields(): ValuesItemFields
    {
        return $this->fields;
    }
    
    /**
     * @param ValuesItemFields $fields
     * @return $this
     */
    protected function setFields(ValuesItemFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}