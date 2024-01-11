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

get_header();

if (have_posts()) {

    do {

        the_post();

        the_content();

    } while (have_posts());

}

get_footer();
