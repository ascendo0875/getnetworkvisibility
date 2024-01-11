<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @since 1.0.0
 */

use FINNPartners\Theme\Block\Instance\Hero;
use FINNPartners\Theme\Block\Register\Hero as HeroRegister;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\BlockRenderer;


global $wp_query;


get_header();

/** @var Hero $Hero */
$Hero = new Hero();
if (have_posts()) {
    $Hero->getFields()
        ->setHeading('"' . esc_html(get_search_query()) . '"')
        ->setSubheading('Search Results for ');
} else {
    $Hero->getFields()
        ->setHeading('Search');
}


BlockRenderer::getService()
    ->setBlockRegister(HeroRegister::class)
    ->setBlockInstance($Hero)
    ->render();


if (have_posts()) {
    ?>

    <div class="main-search">
        <?php get_search_form(); ?>
    </div>


    <div class="search-result-count default-max-width">
        <?php
        printf(
            esc_html(
            /* translators: %d: the number of search results. */
                _n(
                    'We found %d result for your search.',
                    'We found %d results for your search.',
                    (int)$wp_query->found_posts,
                    Theme::DOMAIN
                )
            ),
            (int)$wp_query->found_posts
        );
        ?>
    </div><!-- .search-result-count -->

    <div class="articles-list stacked">
        <?php
        // Start the Loop.
        while (have_posts()) {
            the_post();

            /*
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part('template-parts/content/content-excerpt', get_post_format());
        } // End the loop.   ?>
    </div>
    <?php
    // Previous/next page navigation.
    FINNPartners\Theme\Theme::postsNavigation();
    ?>

    <p class="copy-content"><strong><a href="/search/?query-search=<?= urlencode(get_search_query()) ?>">Not finding what you're looking for?
                Check the Advanced Resources Search Tool</a></strong></p>
    <?php

    // If no content, include the "No posts found" template.
} else {
    get_template_part('template-parts/content/content-none');
}

?><?php
get_footer();
