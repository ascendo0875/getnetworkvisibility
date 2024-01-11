<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\ReadMoreFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class ReadMore extends Block {

    /**
     * @var ReadMoreFields 
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
        $this->setFields(new ReadMoreFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return ReadMoreFields
     */
    public function getFields(): ReadMoreFields
    {
        return $this->fields;
    }
    
    /**
     * @param ReadMoreFields $fields
     * @return $this
     */
    protected function setFields(ReadMoreFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}