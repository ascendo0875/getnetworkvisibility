<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\NewsletterFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class Newsletter extends Block {

    /**
     * @var NewsletterFields 
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
        $this->setFields(new NewsletterFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return NewsletterFields
     */
    public function getFields(): NewsletterFields
    {
        return $this->fields;
    }
    
    /**
     * @param NewsletterFields $fields
     * @return $this
     */
    protected function setFields(NewsletterFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}