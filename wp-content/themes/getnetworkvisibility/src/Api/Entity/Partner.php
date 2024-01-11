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

namespace FINNPartners\Theme\Api\Entity;

use FpStructure\Entity\Post as PostStructure;
use FINNPartners\Theme\PostType\Register\Partner as PartnerPostType;

final class Partner extends PostStructure
{
    public function __construct($wpObject, $postType = PartnerPostType::POST_TYPE)
    {
        parent::__construct($wpObject, $postType);
    }
}