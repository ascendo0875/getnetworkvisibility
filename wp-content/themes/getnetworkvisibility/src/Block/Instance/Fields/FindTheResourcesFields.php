<?php
namespace FINNPartners\Theme\Block\Instance\Fields;

use FINNPartners\Theme\Block\Instance\Fields\ACF\FindTheResources;

class FindTheResourcesFields extends FindTheResources {
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
            $landingSearchPage = get_field('search_resources_landing', 'option');

            $this->setLandingSearchPage(!empty($landingSearchPage) ? $landingSearchPage : false);
        }

        return $this->landingSearchPage;
    }

    /**
     * @param false|string $landingSearchPage
     * @return FindTheResources
     */
    public function setLandingSearchPage($landingSearchPage)
    {
        $this->landingSearchPage = $landingSearchPage;
        return $this;
    }
}