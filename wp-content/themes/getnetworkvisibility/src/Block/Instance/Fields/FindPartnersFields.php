<?php
namespace FINNPartners\Theme\Block\Instance\Fields;

use FINNPartners\Theme\Block\Instance\Fields\ACF\FindPartners;
use FINNPartners\Theme\Block\Instance\SearchPartners;

class FindPartnersFields extends FindPartners {
    /**
     * @var string|false
     */
    private $landingSearchPage = null;

    /**
     * @return false|string
     */
    public function getLandingSearchPage()
    {
        if (is_null($this->landingSearchPage)) {
            $landingSearchPage = get_field('search_partners_landing', 'option');

            $this->setLandingSearchPage(!empty($landingSearchPage) ? $landingSearchPage : false);
        }

        return $this->landingSearchPage;
    }

    /**
     * @param false|string $landingSearchPage
     * @return FindPartners
     */
    public function setLandingSearchPage($landingSearchPage)
    {
        $this->landingSearchPage = $landingSearchPage;
        return $this;
    }
}