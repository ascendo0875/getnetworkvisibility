<?php
/**
 * @package WordPress
 * @subpackage FinnPartners
 * @since FinnPartners 1.0
 */

use FINNPartners\Theme\Api;
use FINNPartners\Theme\Block;
use FINNPartners\Theme\BlockCategory;
use FINNPartners\Theme\OptionPage;
use FINNPartners\Theme\PostType;
use FINNPartners\Theme\Taxonomy;
use FINNPartners\Theme\Service;

/*
$array = [
    PostType\Register\Bio::class => 'getInstance',
    PostType\Register\BlogPost::class => 'getInstance',
    PostType\Register\Event::class => 'getInstance',
    PostType\Register\Market::class => 'getInstance',
    PostType\Register\Partner::class => 'getInstance',
    PostType\Register\Product::class => 'getInstance',
    PostType\Register\Resource::class => 'getInstance',
    PostType\Register\Solution::class => 'getInstance',
    PostType\Register\Topic::class => 'getInstance',
    PostType\Register\Industry::class => 'getInstance',
];

if (!empty($array)) {
    uksort($array, function ($class1, $class2) {
        return strcasecmp($class1, $class2);
    });

    $sortArray = [];
    foreach ($array as $class => $instance) {
        if (is_null($instance)) {
            $sortArray[] = "\\{$class}::class => null,";
        } else {
            $sortArray[] = "\\{$class}::class => '{$instance}',";
        }
    }

    \FINNPartners\Theme\Theme::x(implode("\n", $sortArray), true);
}*/


return [
    /**
     * Other
     */
    Service\NavMenu::class => null,

    /**
     * Options Page
     */
    OptionPage\SiteSettings::class => 'getInstance',

    /**
     * Post Type
     */
    PostType\Register\Bio::class => 'getInstance',
    PostType\Register\Event::class => 'getInstance',
    PostType\Register\Customer::class => 'getInstance',
    PostType\Register\Partner::class => 'getInstance',
    PostType\Register\Product::class => 'getInstance',
    PostType\Register\Resource::class => 'getInstance',
    PostType\Register\Solution::class => 'getInstance',
    PostType\Register\Topic::class => 'getInstance',
    PostType\Register\Industry::class => 'getInstance',

    /**
     * Taxonomy
     */
    Taxonomy\Keyword::class => 'getInstance',
    Taxonomy\PartnerType::class => 'getInstance',
    Taxonomy\Persona::class => 'getInstance',
    Taxonomy\Region::class => 'getInstance',
    Taxonomy\Type::class => 'getInstance',

    /**
     * Custom Block Category
     */
    BlockCategory\CustomBlocks::class => 'getInstance',

    /**
     * Custom Block
     */
    Block\Register\Anchors::class => 'getInstance',
    Block\Register\ContentWithCallout::class => 'getInstance',
    Block\Register\FeaturedList::class => 'getInstance',
    Block\Register\Frame::class => 'getInstance',
    Block\Register\Hero::class => 'getInstance',
    Block\Register\HighlightedResourcesList::class => 'getInstance',
    Block\Register\Newsletter::class => 'getInstance',
    Block\Register\ResourcesList::class => 'getInstance',
    Block\Register\SearchResources::class => 'getInstance',
    Block\Register\ContentWithImage::class => 'getInstance',
    Block\Register\Topics::class => 'getInstance',
    Block\Register\Values::class => 'getInstance',
    Block\Register\ValuesItem::class => 'getInstance',
    Block\Register\ValuesList::class => 'getInstance',
    Block\Register\PartnersFeatured::class => 'getInstance',
    Block\Register\SearchPartners::class => 'getInstance',
    Block\Register\FindTheResources::class => 'getInstance',
    Block\Register\FindPartners::class => 'getInstance',
    Block\Register\MoreSolutionIndustry::class => 'getInstance',
    Block\Register\MediaVisual::class => 'getInstance',
    Block\Register\Carousel::class => 'getInstance',
    Block\Register\Transcript::class => 'getInstance',
    Block\Register\ReadMore::class => 'getInstance',
    Block\Register\CustomersFeatured::class => 'getInstance',
    Block\Register\EventsArchive::class => 'getInstance',
    Block\Register\EventsList::class => 'getInstance',

    /**
     * Block Styles
     */
    Block\Register\Buttons::class => 'getInstance',
    Block\Register\Heading::class => 'getInstance',
    Block\Register\Lists::class => 'getInstance',
    Block\Register\Paragraph::class => 'getInstance',
    Block\Register\SocialLink::class => 'getInstance',

    /**
     * Endpoints
     */
    Api\Resource::class => null,
    Api\Partner::class => null,
    Api\Event::class => null,
];
