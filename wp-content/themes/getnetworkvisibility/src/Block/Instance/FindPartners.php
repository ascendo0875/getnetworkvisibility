<?php
namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\FindPartnersFields;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;

class FindPartners extends Block {

    /**
     * @var FindPartnersFields 
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
        $this->setFields(new FindPartnersFields($postId, !empty($block['id']) ? $block['id'] : false));
        
        parent::__construct($block);
        
        $this->setIsPreview($isPreview)->execute();
    }
    
    /**
     * @return FindPartnersFields
     */
    public function getFields(): FindPartnersFields
    {
        return $this->fields;
    }
    
    /**
     * @param FindPartnersFields $fields
     * @return $this
     */
    protected function setFields(FindPartnersFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}