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

namespace FINNPartners\Theme\Api\Repository;

use FINNPartners\Theme\Api\Entity\Partner;
use FpStructure\Repository\PostRepository as PostRepositoryStructure;
use FINNPartners\Theme\PostType\Register\Partner as PartnerPostType;

class PartnerRepository extends PostRepositoryStructure
{
    public function __construct(?string $entity = Partner::class, $postType = PartnerPostType::POST_TYPE)
    {
        parent::__construct($entity, $postType);
    }
}