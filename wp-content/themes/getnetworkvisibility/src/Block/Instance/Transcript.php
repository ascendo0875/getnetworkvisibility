<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\TranscriptFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class Transcript extends Block {

    /**
     * @var TranscriptFields 
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
        $this->setFields(new TranscriptFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return TranscriptFields
     */
    public function getFields(): TranscriptFields
    {
        return $this->fields;
    }
    
    /**
     * @param TranscriptFields $fields
     * @return $this
     */
    protected function setFields(TranscriptFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}