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

use FINNPartners\Theme\Api\Entity\Event;
use FpStructure\Repository\PostRepository as PostRepositoryStructure;
use FINNPartners\Theme\PostType\Register\Event as EventPostType;

class EventRepository extends PostRepositoryStructure
{
    public function __construct(?string $entity = Event::class, $postType = EventPostType::POST_TYPE)
    {
        parent::__construct($entity, $postType);
    }
}