<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\ValuesFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class Values extends Block {

    /**
     * @var ValuesFields 
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
        $this->setFields(new ValuesFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return ValuesFields
     */
    public function getFields(): ValuesFields
    {
        return $this->fields;
    }
    
    /**
     * @param ValuesFields $fields
     * @return $this
     */
    protected function setFields(ValuesFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}