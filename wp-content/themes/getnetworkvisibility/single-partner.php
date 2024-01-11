<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package GTIndependence
 * @since 1.0
 * @version 1.0
 */


use FINNPartners\Theme\Block\Instance\Hero;
use FINNPartners\Theme\Block\Register\Hero as HeroRegister;
use FINNPartners\Theme\PostType\Instance\Partner;
use FINNPartners\Theme\PostType\Instance\Resource;
use WpAdvanceCustomFieldsExtend\Service\BlockRenderer;

get_header();

if (have_posts()) {

    do {

        the_post();

        /** @var Partner $Partner */
        $Partner = new Partner(get_the_ID());

        /** @var Hero $Hero */
        $Hero = new Hero();
        $Hero->getFields()
            ->setBackgroundImage($Partner->getFields()->getHeroImage())
            ->setHeading($Partner->getFields()->getTitle())
            ->setSubheading(get_post_type());

        BlockRenderer::getService()
            ->setBlockRegister(HeroRegister::class)
            ->setBlockInstance($Hero)
            ->render();


        the_content();

    } while (have_posts());

}

get_footer();
