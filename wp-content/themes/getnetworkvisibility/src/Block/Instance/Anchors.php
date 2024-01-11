<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\AnchorsFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class Anchors extends Block {

    /**
     * @var AnchorsFields 
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
        $this->setFields(new AnchorsFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return AnchorsFields
     */
    public function getFields(): AnchorsFields
    {
        return $this->fields;
    }
    
    /**
     * @param AnchorsFields $fields
     * @return $this
     */
    protected function setFields(AnchorsFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}