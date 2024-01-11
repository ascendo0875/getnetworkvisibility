<?php
namespace FINNPartners\Theme\PostType\Instance;

use FINNPartners\Theme\PostType\Instance\Fields\EventFields;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\DateInterval;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Event {

    /**
     * @var EventFields 
     */
    private $fields;
    
    /**
     * @param int $postId
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->setFields(new EventFields($postId));

        if(($this->getFields()->getThumbnail() instanceof Media)) {
            $this->getFields()->getThumbnail()->setCrop(Theme::IMAGE_SIZES['resources_list']['name']);
        }
    }

    public function getDate()
    {
        return DateInterval::getDate($this->getFields()->getStartDate(), $this->getFields()->getEndDate());
    }

    /**
     * @return null|string
     */
    public function getDateAndLocation(): ?string
    {
        $dateLocation = $this->getDate();

        if (!empty($this->getFields()->getLocation())){
            $dateLocation .= ', ' . $this->getFields()->getLocation();
        }

        return $dateLocation;
    }
    
    /**
     * @return EventFields
     */
    public function getFields(): EventFields
    {
        return $this->fields;
    }
    
    /**
     * @param EventFields $fields
     * @return $this
     */
    protected function setFields(EventFields $fields): self
    {
        $this->fields = $fields;
        
        return $this;
    }
}