<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\SolutionFields;

class Solution {

    /**
     * @var SolutionFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new SolutionFields($postId));
    }
    
    /**
     * @return SolutionFields
     */
    public function getFields(): SolutionFields
    {
        return $this->fields;
    }
    
    /**
     * @param SolutionFields $fields
     * @return $this
     */
    protected function setFields(SolutionFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}