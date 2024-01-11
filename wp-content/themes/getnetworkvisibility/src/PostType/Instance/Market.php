<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\MarketFields;

class Market {

    /**
     * @var MarketFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new MarketFields($postId));
    }
    
    /**
     * @return MarketFields
     */
    public function getFields(): MarketFields
    {
        return $this->fields;
    }
    
    /**
     * @param MarketFields $fields
     * @return $this
     */
    protected function setFields(MarketFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}