<?php

namespace FINNPartners\Theme\Block\Instance\Fields;

use FINNPartners\Theme\Block\Instance\Fields\ACF\ResourcesList;

class ResourcesListFields extends ResourcesList
{
    /**
     * @var string|false
     */
    private $searchLandingPage = null;

    /**
     * @return false|string
     */
    public function getSearchLandingPage()
    {
        if (is_null($this->searchLandingPage)) {
            $searchLandingPage = get_field('search_landing', 'option');
            $searchLandingPage = !empty($searchLandingPage) ? $searchLandingPage : false;

            $this->setSearchLandingPage($searchLandingPage);
        }
        return $this->searchLandingPage;
    }

    /**
     * @param false|string $searchLandingPage
     */
    public function setSearchLandingPage($searchLandingPage): void
    {
        $this->searchLandingPage = $searchLandingPage;
    }

}