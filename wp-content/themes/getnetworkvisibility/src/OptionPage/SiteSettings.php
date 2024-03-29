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

namespace FINNPartners\Theme\OptionPage;

use WpAdvanceCustomFieldsExtend\AbstractClass\AddOptionPage;

class SiteSettings extends AddOptionPage
{
    public static function getInstance(string $class = SiteSettings::class): SiteSettings
    {
        return parent::getInstance($class); // TODO: Change the autogenerated stub
    }

    public function __construct()
    {
        $this->setPageTitle('Site Settings')
        ->setMenuTitle('Site Settings');

        parent::__construct();
    }
}
