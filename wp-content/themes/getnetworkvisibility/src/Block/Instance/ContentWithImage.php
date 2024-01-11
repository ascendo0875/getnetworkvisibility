<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\ContentWithImageFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class ContentWithImage extends Block {

    /**
     * @var ContentWithImageFields 
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
        $this->setFields(new ContentWithImageFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return ContentWithImageFields
     */
    public function getFields(): ContentWithImageFields
    {
        return $this->fields;
    }
    
    /**
     * @param ContentWithImageFields $fields
     * @return $this
     */
    protected function setFields(ContentWithImageFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}