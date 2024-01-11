<?php
namespace FINNPartners\Theme\Block\Instance\Fields;

use FINNPartners\Theme\Block\Instance\Fields\ACF\PartnersFeatured;
use WpAdvanceCustomFieldsExtend\Service\Media;

class PartnersFeaturedFields extends PartnersFeatured {
    /**
     * @var string|false
     */
    private $partnersLanding = null;

    /**
     * @var Media|false
     */
    private $imagePlaceholder = null;

    /**
     * @return false|string
     */
    public function getPartnersLanding()
    {
        if(is_null($this->partnersLanding)) {
            $partnersLanding = get_field('partner_landing', 'option');
            $partnersLanding = !empty($partnersLanding) ? $partnersLanding : false;

            $this->setPartnersLanding($partnersLanding);
        }
        return $this->partnersLanding;
    }

    /**
     * @param false|string $partnersLanding
     * @return PartnersFeaturedFields
     */
    public function setPartnersLanding($partnersLanding)
    {
        $this->partnersLanding = $partnersLanding;
        return $this;
    }

    /**
     * @return false|Media
     */
    public function getImagePlaceholder()
    {
        if(is_null($this->imagePlaceholder)) {
            $imagePlaceholder = get_field('image_placeholder', 'option');
            $imagePlaceholder = !empty($imagePlaceholder) ? Media::getInstance($imagePlaceholder) : false;

            $this->setImagePlaceholder($imagePlaceholder);
        }
        return $this->imagePlaceholder;
    }

    /**
     * @param false|Media $imagePlaceholder
     * @return PartnersFeaturedFields
     */
    public function setImagePlaceholder($imagePlaceholder)
    {
        $this->imagePlaceholder = $imagePlaceholder;
        return $this;
    }
    
}