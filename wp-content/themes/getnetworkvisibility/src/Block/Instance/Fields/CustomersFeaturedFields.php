<?php
namespace FINNPartners\Theme\Block\Instance\Fields;

use FINNPartners\Theme\Block\Instance\Fields\ACF\CustomersFeatured;
use WpAdvanceCustomFieldsExtend\Service\Media;

class CustomersFeaturedFields extends CustomersFeatured {
    /**
     * @var string|false
     */
    private $customersLanding = null;

    /**
     * @var Media|false
     */
    private $imagePlaceholder = null;

    /**
     * @return false|string
     */
    public function getCustomersLanding()
    {
        if(is_null($this->customersLanding)) {
            $customersLanding = get_field('customer_landing', 'option');
            $customersLanding = !empty($customersLanding) ? $customersLanding : false;

            $this->setCustomersLanding($customersLanding);
        }

        return $this->customersLanding;
    }

    /**
     * @param false|string $customersLanding
     * @return CustomersFeaturedFields
     */
    public function setCustomersLanding($customersLanding)
    {
        $this->customersLanding = $customersLanding;
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
     * @return CustomersFeaturedFields
     */
    public function setImagePlaceholder($imagePlaceholder)
    {
        $this->imagePlaceholder = $imagePlaceholder;
        return $this;
    }
}