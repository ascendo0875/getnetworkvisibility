<?php

namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Api\AbstractClass\AbstractApiController;
use FINNPartners\Theme\Api\Partner as ApiPartner;
use FINNPartners\Theme\Block\Instance\Fields\SearchPartnersFields;
use FINNPartners\Theme\PostType\Register\Partner as PartnerPostType;
use FINNPartners\Theme\Service\ThemeCacheHelper;
use FINNPartners\Theme\Taxonomy\Keyword;
use FINNPartners\Theme\Taxonomy\PartnerType;
use FINNPartners\Theme\Taxonomy\Region;
use FINNPartners\Theme\Taxonomy\Type;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;
use WpAdvanceCustomFieldsExtend\Service\React;
use WpAdvanceCustomFieldsExtend\Service\TaxonomyHelper;

class SearchPartners extends Block
{

    /**
     * @var SearchPartnersFields
     */
    private $fields;

    /**
     * @var string|false
     */
    private $landingSearchPage = null;

    /**
     * @param int|false $postId
     * @param array $block
     * @param bool $isPreview
     * @return void
     */
    public function __construct($postId = false, array $block = [], bool $isPreview = false)
    {
        $this->setFields(new SearchPartnersFields($postId, !empty($block['id']) ? $block['id'] : false));

        parent::__construct($block);

        $this->setIsPreview($isPreview)->execute();
    }

    public function execute(): Block
    {
        /** @var React $React */
        $React = React::getInstance($this->getBlockId(), [
            'php' => getTheme()->getPath() . "templates/src/modules/list/build/list.build.asset.php",
            'js' => getTheme()->getPathUrl() . "templates/src/modules/list/build/list.build.js"
        ]);

        $source = ApiPartner::url();
        $React->setApp('Partners')
            ->addData('source', $source)
            ->addData('loadMore', 'pagination')
            ->addData('maxFiltersDisplay', 6)
            ->addData('filtersShowMore', true)
            ->addData('redirectToSearch', $this->getFields()->isRedirectOnSearchPage() ? $this->getLandingSearchPage() : false)
            ->addData('disabledAutoScroll', false)
            ->addData('domLoadedAutoScroll', $this->getFields()->isWhenLoadingPagesApplyScrolling())
            ->addText('textFilterShowMore', 'Show More')
            ->addText('textFilterShowLess', 'Show Less')
            ->addText('textSearchLabel', 'type a keyword')
            ->addText('textButtonSearchLabel', 'search')
            ->addText('textFilterLabel', 'filter ')
            ->addText('textClearAllLabel', 'clear all')
            ->addText('textShowNumberResults', 'show (%countResults%) results');

        $filters = [];
        $filters['search'] = [
            'key' => AbstractApiController::API_QUERY_SEARCH,
            'default' => !empty($_GET[AbstractApiController::API_QUERY_SEARCH]) ? esc_sql($_GET[AbstractApiController::API_QUERY_SEARCH]) : false,
        ];

        if ($this->getFields()->isFilters()) {
            /** @var TaxonomyHelper $taxonomyHelper */
            $taxonomyHelper = TaxonomyHelper::getHelper();

            if ($this->getFields()->isFiltersByPartnerTypes()) {
                $partnerTypes = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "search-partners-" . PartnerType::TAXONOMY_NAME, function () use ($taxonomyHelper) {
                    $terms = $taxonomyHelper->getTermsAssignedToPostType(PartnerType::TAXONOMY_NAME, PartnerPostType::POST_TYPE);
                    $terms = (!empty($terms) && !is_wp_error($terms)) ? $terms : false;

                    if ($terms) {
                        foreach ($terms as &$term) {
                            /** @var \WP_Term $term */
                            $term = ['label' => ucfirst($term->name), 'value' => $term->slug];
                        }

                        $terms = wp_list_sort($terms, 'label');
                    }

                    return $terms;
                });

                $filters[PartnerType::TAXONOMY_NAME] = [
                    'key' => PartnerType::TAXONOMY_NAME,
                    'element' => 'Input',
                    'type' => 'checkbox',
                    'default' => !empty($_GET[PartnerType::TAXONOMY_NAME]) ? $_GET[PartnerType::TAXONOMY_NAME] : false,
                    'label' => PartnerType::PLURAL_NAME,
                    'choices' => $partnerTypes ?: [],
                    'isVisible' => true,
                ];
            }

            if ($this->getFields()->isFiltersByRegions()) {
                $regions = Theme::getCachePage()->get(ThemeCacheHelper::APP_POST, "search-partners-".Region::TAXONOMY_NAME, function () use ($taxonomyHelper) {
                    $terms = $taxonomyHelper->getTermsAssignedToPostType(Region::TAXONOMY_NAME, PartnerPostType::POST_TYPE);
                    $terms = !empty($terms) ? $terms : false;

                    if ($terms) {
                        foreach ($terms as &$term) {
                            /** @var \WP_Term $term */
                            $term = ['label' => ucfirst($term->name), 'value' => $term->slug];
                        }

                        $terms = wp_list_sort($terms, 'label');
                    }

                    return $terms;
                });

                $filters[Region::TAXONOMY_NAME] = [
                    'key' => Region::TAXONOMY_NAME,
                    'element' => 'Input',
                    'type' => 'checkbox',
                    'default' => !empty($_GET[Region::TAXONOMY_NAME]) ? $_GET[Region::TAXONOMY_NAME] : false,
                    'label' => Region::PLURAL_NAME,
                    'choices' => $regions ?: [],
                    'isVisible' => false,
                ];
            }
        }

        $React->addData('filters', $filters);
        $React->render();

        return parent::execute(); // TODO: Change the autogenerated stub
    }

    /**
     * @return SearchPartnersFields
     */
    public function getFields(): SearchPartnersFields
    {
        return $this->fields;
    }

    /**
     * @param SearchPartnersFields $fields
     * @return $this
     */
    protected function setFields(SearchPartnersFields $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

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
     * @return SearchPartners
     */
    public function setLandingSearchPage($landingSearchPage)
    {
        $this->landingSearchPage = $landingSearchPage;
        return $this;
    }
}