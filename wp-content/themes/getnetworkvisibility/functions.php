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

use FINNPartners\Theme\Theme;

require_once('vendor/autoload.php');

/**
 * @return Theme
 */
function getTheme(): Theme
{
    return Theme::getInstance();
}

/**
 * @param $value
 * @param bool $exit
 * @return void
 */
function x($value, bool $exit = false)
{
    printf('<pre>%s</pre>', print_r($value, true));
    if ($exit) exit;
}

getTheme();
