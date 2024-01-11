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

use FINNPartners\Theme\Api\Entity\Resource;
use FpStructure\Repository\PostRepository as PostRepositoryStructure;
use FINNPartners\Theme\PostType\Register\Resource as ResourcePostType;

class ResourceRepository extends PostRepositoryStructure
{
    public function __construct(?string $entity = Resource::class, $postType = ResourcePostType::POST_TYPE)
    {
        parent::__construct($entity, $postType);
    }
}