<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\TopicsFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class Topics extends Block {

    /**
     * @var TopicsFields 
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
        $this->setFields(new TopicsFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return TopicsFields
     */
    public function getFields(): TopicsFields
    {
        return $this->fields;
    }
    
    /**
     * @param TopicsFields $fields
     * @return $this
     */
    protected function setFields(TopicsFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}