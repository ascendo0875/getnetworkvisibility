<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GTIndependence
 * @since 1.0
 * @version 1.0
 */

use FINNPartners\Theme\Service\ThemeCacheHelper;
use FINNPartners\Theme\Theme;
use FINNPartners\Theme\Service\NavMenu;

if (is_active_sidebar('content-bottom'))
    dynamic_sidebar('content-bottom');
?>

</div></main>

<!-- footer -->
<footer class="site-footer">
    <div class="wrapper">
        <div class="logo"><a href="home.html"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg"
                                                   width="335" height="67" alt="Network Visibility"/></a></div>
        <div class="sitemap">
            <ul>
                <?php
                echo Theme::getCachePage()->get(ThemeCacheHelper::APP_NAVIGATION, "sitemap-" . ((!empty(Theme::getPage())) ? Theme::getPage()->ID : wp_unique_id()), function () {
                    return wp_nav_menu(['theme_location' => 'sitemap', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 2, 'echo' => false]);
                });
                ?>
            </ul>
        </div>

        <div class="util">
            <?php
            $copyright = get_field('site_copyright', 'option');

            if (!empty($copyright)) {
                echo $copyright;
            }
            ?>
        </div>

    </div>
</footer>

</div></div>

<!-- mobile navigation -->
<div class="mobile-overlayer"></div>
<div class="global-mobile-nav">
    <div class="global-mobile-bg">

        <ul>
            <?php
            echo Theme::getCachePage()->get(ThemeCacheHelper::APP_NAVIGATION, "navigation-" . ((!empty(Theme::getPage())) ? Theme::getPage()->ID : wp_unique_id()), function () {
                return wp_nav_menu(['theme_location' => 'navigation', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 2, 'echo' => false, 'walker' => NavMenu::getInstance()]);
            });
            ?>
        </ul>

        <ul>
            <?php
            echo Theme::getCachePage()->get(ThemeCacheHelper::APP_NAVIGATION, "utility-nav-" . ((!empty(Theme::getPage())) ? Theme::getPage()->ID : wp_unique_id()), function () {
                return wp_nav_menu(['theme_location' => 'utility-nav', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 2, 'echo' => false]);
            });
            ?>
            <li class="img-logo"><?= Theme::getSponsorLabel() ?> <a href=" https://keysight.com/"><img
                            src="<?php echo get_template_directory_uri(); ?>/images/keysight-dark.svg"
                            alt="Get Network Visibility - Keysight"></a></li>
        </ul>

    </div>
</div>


<?php wp_footer(); ?>

</body>
</html>
