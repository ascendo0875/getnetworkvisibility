<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage FinnPartners
 * @since FinnPartners 1.0
 */

namespace FINNPartners\Theme;

use WpAdvanceCustomFieldsExtend\Service\Media;
use FINNPartners\Theme\Service\ThemeCacheHelper;
use WP_Post;

final class Theme
{
    const DOMAIN = 'getnetworkvisibility';
    const CLIENT_NAME = 'GetNetworkVisibility';

    /**
     * For setting post thumbnail
     */
    const POST_THUMBNAIL_SIZE_WIDTH = 1200;
    const POST_THUMBNAIL_SIZE_HEIGHT = 0;
    const POST_THUMBNAIL_SIZE_CROP = true;

    /**
     * Image crop
     */
    const IMAGE_SIZES = [
        'hero' => ['label' => 'Hero', 'name' => 'hero', 'width' => 2304, 'height' => 407, 'crop' => true],
        'hero_tall' => ['label' => 'Hero Tall', 'name' => 'hero_tall', 'width' => 2304, 'height' => 1080, 'crop' => true],
        'logo_header_desktop' => ['label' => 'Logo Header (Desktop)', 'name' => 'logo_header_desktop', 'width' => 500, 'height' => 121, 'crop' => true],
        'logo_header_mobile' => ['label' => 'Logo Header (Mobile)', 'name' => 'logo_header_mobile', 'width' => 269, 'height' => 200, 'crop' => true],
        'frame' => ['label' => 'Frame', 'name' => 'frame', 'width' => 2304, 'height' => 0, 'crop' => true],
        'content-with-image' => ['label' => 'Content With Image', 'name' => 'content-with-image', 'width' => 810, 'height' => 505, 'crop' => true],
        'highlighted_resource' => ['label' => 'Highlighted Resource', 'name' => 'highlighted_resource', 'width' => 929, 'height' => 520, 'crop' => true],
        'highlighted_resources_list' => ['label' => 'Highlighted Resources List', 'name' => 'highlighted_resources_list', 'width' => 150, 'height' => 90, 'crop' => true],
        'resources_list' => ['label' => 'Resources List', 'name' => 'resources_list', 'width' => 378, 'height' => 283, 'crop' => true],
        'featured_list' => ['label' => 'Featured List', 'name' => 'featured_list', 'width' => 391, 'height' => 294, 'crop' => true],
        'carousel' => ['label' => 'Carousel', 'name' => 'carousel', 'width' => 391, 'height' => 294, 'crop' => true],
        'partners-featured' => ['label' => 'Partners Featured', 'name' => 'partners-featured', 'width' => 153, 'height' => 139, 'crop' => true],
        'customers-featured' => ['label' => 'Customers Featured', 'name' => 'customers-featured', 'width' => 153, 'height' => 139, 'crop' => true],
        'search-partners' => ['label' => 'Search Partners', 'name' => 'search-partners', 'width' => 480, 'height' => 273, 'crop' => true],
        'media-visual' => ['label' => 'Media Visual', 'name' => 'media-visual', 'width' => 1620, 'height' => 911, 'crop' => true],
        'search-result' => ['label' => 'Search Result', 'name' => 'search-result', 'width' => 228, 'height' => 150, 'crop' => true],
    ];

    /**
     * Nav Menus
     */
    const NAV_MENUS = [
        'navigation' => 'Navigation',
        'sitemap' => 'Sitemap',
        'utility-nav' => 'Utility navigation',
    ];

    const WIDGETS = [
        'right-sidebar' => [
            'name' => 'Sidebar',
            'id' => 'right_sidebar',
            'description' => 'The default sidebar shows on posts and pages',
        ],
        'content-bottom' => [
            'name' => 'Content Bottom',
            'id' => 'content-bottom',
            'description' => '',
        ],
    ];

    const SELECTOR_LOGO_HEADER_DESKTOP = 'logo_header_desktop';
    const SELECTOR_LOGO_HEADER_MOBILE = 'logo_header_mobile';
    const SELECTOR_IMAGE_PLACEHOLDER = 'image_placeholder';

    const POST_VIEWS_COUNT = 'wp_post_views_count';
    const COLORS = [
        'dark-blue' => [
            'name' => 'Dark Blue',
            'slug' => 'dark-blue',
            'color' => '#000039',
        ],
        'grey' => [
            'name' => 'Grey',
            'slug' => 'grey',
            'color' => '#F8F8F8',
        ],
        'horizontal-gradient' => [
            'name' => 'Horizontal gradient',
            'slug' => 'horizontal-gradient',
            'color' => '#B87626',
        ],
        'vertical-gradient' => [
            'name' => 'Vertical gradient',
            'slug' => 'vertical-gradient',
            'color' => '#e0e4ef',
        ],
    ];

    /**
     * @var Theme
     */
    private static $instance;

    /**
     * @var string|false
     */
    private static $blogName = null;

    /**
     * @var Media|false
     */
    private static $logoHeaderDesktop = null;

    /**
     * @var Media|false
     */
    private static $logoHeaderMobile = null;

    /**
     * @var Media|false
     */
    private static $imagePlaceholder = null;

    /**
     * @var WP_Post|false
     */
    private static $page = null;

    /**
     * @var ThemeCacheHelper|false
     */
    private static $cachePage = null;

    /**
     * @var string
     */
    private $path = null;

    /**
     * @var string
     */
    private $pathUrl = null;

    /**
     * @var string|false
     */
    private static $sponsorLabel = null;

    /**
     * @return string|false
     */
    public static function getSponsorLabel()
    {
        if (is_null(self::$sponsorLabel)) {
            $sponsorLabel = get_field('sponsor_label', 'option');
            $sponsorLabel = empty($sponsorLabel) ? false: $sponsorLabel;

            self::setsponsorLabel($sponsorLabel);
        }

        return self::$sponsorLabel;
    }

    /**
     * @param string|false $sponsorLabel
     * @return void
     */
    public static function setSponsorLabel($sponsorLabel): void
    {
        self::$sponsorLabel = $sponsorLabel;
    }


    /**
     * @return void
     */
    public function __construct()
    {
        if (function_exists('get_stylesheet_directory')) {
            $this->setPath(get_stylesheet_directory());
        }

        if (function_exists('get_stylesheet_directory_uri')) {
            $this->setPathUrl(get_stylesheet_directory_uri());
        }

        if (function_exists('add_action')) {
            add_action('init', [$this, 'init']);
            add_action('after_setup_theme', [$this, 'afterSetupTheme']);
            add_action('wp_enqueue_scripts', [$this, 'wpEnqueueScripts']);
            add_action('enqueue_block_editor_assets', [$this, 'enqueueBlockEditorAssets']);
            add_action('admin_head', [$this, 'adminHead']);
            add_action('widgets_init', [$this, 'widgetsInit']);
            add_action('wp_head', [$this, 'trackPostViews']);
            add_action('acf/input/admin_footer', [$this, 'adminColorPicker']);
        }

        if (function_exists('add_filter')) {
            add_filter('body_class', [$this, 'bodyClass']);
            add_filter('mce_css', [$this, 'mceCss']);
            add_filter('image_size_names_choose', [$this, 'imageSizeNamesChoose']);
        }

        if (function_exists('remove_action')) {
            remove_action('wp_head', [$this, 'adjacent_posts_rel_link_wp_head']);
        }

        $this->initConfig();
    }

    /**
     * @return void
     */
    private function initConfig(): void
    {
        $config = require_once("{$this->getPath()}config.php");
        $config = apply_filters(self::DOMAIN . "/load_config", $config, $this);

        if (!empty($config)) {
            foreach ($config as $class => $method) {
                $className = null;
                $methodName = null;

                if (class_exists($class)) {
                    $className = $class;
                    $methodName = $method;
                }

                if (is_null($className) && class_exists($method)) {
                    $className = $method;
                }

                if (!is_null($className) && is_null($methodName)) {
                    new $className();
                }

                if (!is_null($className) && !is_null($methodName) && method_exists($className, $methodName)) {
                    call_user_func([$className, $methodName]);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = trailingslashit($path);

        return $this;
    }

    /**
     * @param $value
     * @param bool $exit
     * @param bool $withBacktrace
     * @return void
     */
    public static function x($value, bool $exit = false, bool $withBacktrace = false)
    {
        if (isset($_GET['debug']) && is_user_logged_in()) {
            $data = $value;

            if ($withBacktrace) {
                $data = [$value];
                $data[] = debug_backtrace();
            }

            printf('<pre>%s</pre>', print_r($data, true));

            if ($exit) {
                exit();
            }
        }
    }

    /**
     * @return Media|false
     */
    public static function getLogoHeaderDesktop()
    {
        if (is_null(self::$logoHeaderDesktop)) {
            if (function_exists('get_field')) {
                $logo = get_field(self::SELECTOR_LOGO_HEADER_DESKTOP, 'option');

                self::setLogoHeaderDesktop(!empty($logo) ? Media::getInstance($logo, self::IMAGE_SIZES['logo_header_desktop']['name']) : false);
            }
        }

        return self::$logoHeaderDesktop;
    }

    /**
     * @param bool|Media $logoHeaderDesktop
     */
    public static function setLogoHeaderDesktop($logoHeaderDesktop): void
    {
        self::$logoHeaderDesktop = ($logoHeaderDesktop instanceof Media) ? $logoHeaderDesktop : false;
    }

    /**
     * @return Theme
     */
    public static function getInstance(): Theme
    {
        if (!(self::$instance instanceof Theme)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return WP_Post|false
     */
    public static function getPage()
    {
        if (is_null(self::$page)) {
            $page = get_queried_object();

            self::setPage(($page instanceof WP_Post) ? $page : false);
        }

        return self::$page;
    }

    /**
     * @param WP_Post|false $page
     */
    private static function setPage($page): void
    {
        self::$page = $page;
    }

    /**
     * @return false|ThemeCacheHelper
     */
    public static function getCachePage()
    {
        if (is_null(self::$cachePage)) {
            $cachePage = false;

            if (class_exists(ThemeCacheHelper::class)) {
                $cachePage = ThemeCacheHelper::getHelper();
            }

            self::setCachePage($cachePage);
        }

        return self::$cachePage;
    }

    /**
     * @param false|ThemeCacheHelper $cachePage
     */
    public static function setCachePage($cachePage): void
    {
        self::$cachePage = $cachePage;
    }

    /**
     * @return false|Media
     */
    public static function getLogoHeaderMobile()
    {
        if (is_null(self::$logoHeaderMobile)) {
            if (function_exists('get_field')) {
                $logo = get_field(self::SELECTOR_LOGO_HEADER_MOBILE, 'option');

                self::setLogoHeaderMobile(!empty($logo) ? Media::getInstance($logo, self::IMAGE_SIZES['logo_header_mobile']['name']) : false);
            }
        }

        return self::$logoHeaderMobile;
    }

    /**
     * @param false|Media $logoHeaderMobile
     */
    public static function setLogoHeaderMobile($logoHeaderMobile): void
    {
        self::$logoHeaderMobile = $logoHeaderMobile instanceof Media ? $logoHeaderMobile : false;
    }

    /**
     * @return false|Media
     */
    public static function getImagePlaceholder()
    {
        if (is_null(self::$imagePlaceholder)) {
            if (function_exists('get_field')) {
                $imagePlaceholder = get_field(self::SELECTOR_IMAGE_PLACEHOLDER, 'option');

                self::setImagePlaceholder(!empty($imagePlaceholder) ? Media::getInstance($imagePlaceholder) : false);
            }
        }

        return self::$imagePlaceholder;
    }

    /**
     * @param false|Media $imagePlaceholder
     */
    public static function setImagePlaceholder($imagePlaceholder): void
    {
        self::$imagePlaceholder = $imagePlaceholder;
    }

    /**
     * @return false|string
     */
    public static function getBlogName()
    {
        if (is_null(self::$blogName)) {
            $blogName = get_bloginfo('name');

            self::setBlogName(!empty($blogName) ? $blogName : false);
        }

        return self::$blogName;
    }

    /**
     * @param false|string $blogName
     */
    public static function setBlogName($blogName): void
    {
        self::$blogName = !empty($blogName) ? $blogName : false;
    }

    /**
     * @return void
     */
    public static function postsNavigation()
    {
        $post_type = get_post_type_object(get_post_type());
        $post_type_name = '';
        if (
            is_object($post_type) &&
            property_exists($post_type, 'labels') &&
            is_object($post_type->labels) &&
            property_exists($post_type->labels, 'name')
        ) {
            $post_type_name = $post_type->labels->name;
        }

        the_posts_pagination([
            'before_page_number' => esc_html__('', self::DOMAIN),
            'mid_size' => 2,
            'prev_text' => sprintf(
                '%s <span class="nav-prev-text">%s</span>',
                '',
                sprintf(
                /* translators: %s: The post-type name. */
                    esc_html__('Previous', self::DOMAIN),
                    '<span class="nav-short">' . esc_html($post_type_name) . '</span>'
                )
            ),
            'next_text' => sprintf(
                '<span class="nav-next-text">%s</span> %s',
                sprintf(
                /* translators: %s: The post-type name. */
                    esc_html__('Next', self::DOMAIN),
                    '<span class="nav-short">' . esc_html($post_type_name) . '</span>'
                ),
                ''
            ),
        ]);
    }

    /**
     * @param string $color
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getColorClassFromPalette(string $color, string $prefix = 'has-', string $suffix = '-background-color'): ?string
    {
        $cssClassName = null;

        if (!empty(self::COLORS)) {
            foreach (self::COLORS as $c) {
                if (!empty($c['color']) && strtolower($c['color']) == strtolower($color)) {
                    $cssClassName = $prefix . $c['slug'] . $suffix;
                    break;
                }
            }
        }

        return $cssClassName;
    }

    /**
     * @return void
     */
    public function init()
    {
        Patterns::init();
        self::getCachePage();
    }

    /**
     * @return void
     */
    public function afterSetupTheme(): void
    {
        /**
         * Add default posts and comments RSS feed links to head.
         */
        add_theme_support('automatic-feed-links');
        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');
        add_theme_support('align-wide');
        /**
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_fp_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(self::POST_THUMBNAIL_SIZE_WIDTH, self::POST_THUMBNAIL_SIZE_HEIGHT, self::POST_THUMBNAIL_SIZE_CROP);
        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        /**
         * Disable Colors & Typography
         */
        add_theme_support('disable-custom-colors'); // disable custom colors
        add_theme_support('editor-color-palette', []); // disable color palette
        add_theme_support('disable-custom-font-sizes'); // disable manual font sizes
        add_theme_support('editor-font-sizes', []); // disable font preset size
        /**
         * This theme uses wp_nav_menu() in two locations.
         */
        $navMenus = apply_filters(self::DOMAIN . "/nav_menu", self::NAV_MENUS);
        if (!empty($navMenus)) {
            register_nav_menus($navMenus);
        }
        /**
         * Image Sizes
         */
        $imageSizes = $this->filterThemeImageSizes();
        if (!empty($imageSizes)) {
            foreach ($imageSizes as $imageSize) {
                add_image_size($imageSize['name'], $imageSize['width'], $imageSize['height'], $imageSize['crop']);
                add_filter("media_image_width_{$imageSize['name']}", function ($crop) {
                    return Theme::IMAGE_SIZES[$crop]['width'];
                });
                add_filter("media_image_height_{$imageSize['name']}", function ($crop) {
                    return Theme::IMAGE_SIZES[$crop]['height'];
                });
            }
        }
    }

    /**
     * @return array
     */
    private function filterThemeImageSizes(): array
    {
        return apply_filters(self::DOMAIN . "/image_sizes", self::IMAGE_SIZES);
    }

    /**
     * @return void
     */
    public function wpEnqueueScripts(): void
    {
        wp_enqueue_style(
            'site-css',
            $this->getPathUrl() . '/css/site.min.css',
            [],
            filemtime($this->getPath() . 'css/site.min.css')
        );

        wp_enqueue_script(
            'site-js',
            $this->getPathUrl() . '/js/site.min.js',
            [],
            filemtime($this->getPath() . 'js/site.min.js'),
            true
        );
    }

    /**
     * @return string
     */
    public function getPathUrl(): string
    {
        return $this->pathUrl;
    }

    /**
     * @param string $pathUrl
     * @return $this
     */
    public function setPathUrl(string $pathUrl): self
    {
        $this->pathUrl = trailingslashit($pathUrl);

        return $this;
    }

    /**
     * @return void
     */
    public function enqueueBlockEditorAssets(): void
    {
        if (function_exists('wp_enqueue_style')) {
            wp_enqueue_style(
                self::DOMAIN . '-gutenberg',
                "{$this->getPathUrl()}/css/wp-editor.css",
                false,
                @filemtime("{$this->getPath()}css/wp-editor.css")
            );
        }

        if (function_exists('wp_enqueue_script')) {
            wp_enqueue_script(
                self::DOMAIN . '-gutenberg',
                $this->getPathUrl() . 'assets/js/gutenberg.js',
                ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
                filemtime($this->getPath() . 'assets/js/gutenberg.js')
            );
        }
    }

    /**
     * @return void
     */
    public function adminHead(): void
    {
        $style = <<<HTML
<style>
    #adminmenu div.separator{
        border-bottom: 1px solid #454545 !important;
        width: 85%;
        margin: 5px auto 5px auto;
    }
</style>
HTML;

        echo $style;
    }

    /**
     * @return void
     */
    public function widgetsInit(): void
    {

        if (!empty(self::WIDGETS)) {
            foreach (self::WIDGETS as $widget) {
                register_sidebar([
                    'id' => $widget['id'],
                    'name' => __($widget['name'], self::DOMAIN),
                    'description' => __($widget['description'], self::DOMAIN),
                ]);
            }
        }
    }

    /**
     * @param array $classes
     * @return array
     */
    public function bodyClass(array $classes): array
    {
        if (function_exists('is_front_page') && is_front_page()) {
            $classes[] = 'homepage';
        }

        return $classes;
    }

    /**
     * @param string $mceCss
     * @return string
     */
    public function mceCss(string $mceCss): string
    {
        $mceCss .= ', ' . $this->getPathUrl() . '/css/wp-editor.css?' . @filemtime($this->getPath() . 'css/wp-editor.css');

        return $mceCss;
    }

    /**
     * @param array $sizes
     * @return array
     */
    public function imageSizeNamesChoose(array $sizes): array
    {
        $imageSizes = $this->filterThemeImageSizes();

        if (!empty($imageSizes)) {
            foreach ($imageSizes as $imageSize) {
                if (!isset($imageSize['label'])) {
                    continue;
                }

                $sizes[$imageSize['name']] = __($imageSize['label'], self::DOMAIN);
            }
        }

        return $sizes;
    }

    /**
     * @param $postId
     * @return void
     */
    public function trackPostViews($postId)
    {

        if (!is_single()) {
            return;
        }

        if (empty($postId)) {
            global $post;
            $postId = $post->ID;
        }

        $this->adjacentPostsRelLinkWpHead($postId);
    }

    /**
     * @param $postId
     * @return void
     */
    public function adjacentPostsRelLinkWpHead($postId)
    {
        $count = get_post_meta($postId, self::POST_VIEWS_COUNT, true);

        if ($count === '') {
            $count = 0;
            delete_post_meta($postId, self::POST_VIEWS_COUNT);
            add_post_meta($postId, self::POST_VIEWS_COUNT, $count);
        } else {
            $count++;
            update_post_meta($postId, self::POST_VIEWS_COUNT, $count);
        }
    }

    /**
     * @return void
     */
    public function adminColorPicker(): void
    {
        $filters = apply_filters('fp/acf/color_picker', ['all' => wp_list_pluck(array_values(Theme::COLORS), 'color')]);
        $sets = wp_json_encode($filters);
        ?>
        <script type="text/javascript">
            (function ($) {
                acf.add_filter('color_picker_args', function (args, $field) {
                    var field_name = $field[0].dataset.name,
                        sets = <?php echo $sets ?>;
                    if (typeof (sets[field_name]) != 'undefined') {
                        args.palettes = sets[field_name];
                    } else {
                        args.palettes = sets['all'];
                    }
                    // add the hexadecimal codes here for the colors you want to appear as swatches
                    // return colors
                    return args;
                });
            })(jQuery);
        </script>
        <?php
    }

}
