<?php

use FINNPartners\Theme\Theme;
use FINNPartners\Theme\Service\ThemeCacheHelper;
use FINNPartners\Theme\Service\NavMenu;

/**
 * The header for our theme
 *
 */
if (!session_id()) session_start();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet"> 
    
    <?php if (!current_user_can('edit_posts')):
        if (isset($_ENV['PANTHEON_ENVIRONMENT']) && in_array($_ENV['PANTHEON_ENVIRONMENT'], array('live'))) {
            ?>


            <?php
        }
    endif; ?>

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<div class="fixMinHeight">
    <div class="page-wrap">


        <!-- header -->
        <header class="site-header">
            <div class="wrapper">
                <div class="util-nav">
                    <ul>
                        <li><?=Theme::getSponsorLabel() ?> <a href="https://www.keysight.com/us/en/cmp/2020/network-visibility-network-test.html"><img src="<?php echo get_template_directory_uri(); ?>/images/keysight.svg" alt="Get Network Visibility - Keysight"></a></li>
                        <?php
                        echo Theme::getCachePage()->get(ThemeCacheHelper::APP_NAVIGATION, "utility-nav-". ((!empty(Theme::getPage())) ? Theme::getPage()->ID : wp_unique_id()) , function () {
                            return wp_nav_menu(['theme_location' => 'utility-nav', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 2, 'echo' => false]);
                        });
                        ?>
                    </ul>
                </div>

                <div class="header">
                    <div class="logo">
                        <a href="/">
                            <?php if (Theme::getLogoHeaderDesktop()) : ?>
                                <picture>
                                    <?php if (Theme::getLogoHeaderMobile()) : ?>
                                        <source media="(max-width:650px)"
                                                srcset="<?php echo Theme::getLogoHeaderMobile()->getUrl(); ?>">
                                    <?php endif; ?>

                                    <img src="<?php echo Theme::getLogoHeaderDesktop()->getUrl(); ?>"
                                         alt="<?php echo Theme::getBlogName(); ?>"/>
                                </picture>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="navigation">
                        <ul>
                            <?php
                            echo Theme::getCachePage()->get(ThemeCacheHelper::APP_NAVIGATION, "navigation-". ((!empty(Theme::getPage())) ? Theme::getPage()->ID : wp_unique_id()) , function () {
                                return wp_nav_menu(['theme_location' => 'navigation', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 2, 'echo' => false, 'walker' => NavMenu::getInstance()]);
                            });
                            ?>
                        </ul>
                    </div>

                    <div class="search">
                        <a href="#"><i class="icon icon-search"></i><i class="icon icon-close"></i></a>
                        <form class="search-form" action="/" role="search">
                            <label for="main-search" class="screen-reader-text">Search</label>
                            <input type="search" placeholder="Search" name="s" id="main-search" value="" autofocus="" ><input type="submit" value="&#xe901">
                        </form>
                    </div>
                    <!-- mobile navigation -->
                    <p class="mobile-nav"><a href="#"><span></span><span></span><span></span><span></span></a></p>
                </div>
            </div>

        </header>

        <!-- main content -->
        <main>
            <div>

