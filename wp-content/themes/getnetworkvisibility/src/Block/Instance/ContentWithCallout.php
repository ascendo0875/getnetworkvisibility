<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\ContentWithCalloutFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class ContentWithCallout extends Block {

    /**
     * @var ContentWithCalloutFields 
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
        $this->setFields(new ContentWithCalloutFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return ContentWithCalloutFields
     */
    public function getFields(): ContentWithCalloutFields
    {
        return $this->fields;
    }
    
    /**
     * @param ContentWithCalloutFields $fields
     * @return $this
     */
    protected function setFields(ContentWithCalloutFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}