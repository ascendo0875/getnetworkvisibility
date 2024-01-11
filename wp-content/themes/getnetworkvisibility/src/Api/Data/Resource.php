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

namespace FINNPartners\Theme\Api\Data;

use FINNPartners\Theme\Theme;
use FpStructure\Entity\EntityInterface;
use FpStructure\Services\EntityData\EntityDataInterface;
use FINNPartners\Theme\PostType\Instance\Resource as ResourceInstance;

class Resource implements EntityDataInterface
{
    public static function default(?EntityInterface $post): array
    {
        /** @var ResourceInstance $resource */
        $resource = new ResourceInstance($post->getId());

        // TODO: Implement default() method.
        return [
            'title' => $resource->getFields()->getTitle(),
            'permalink' => $resource->getFields()->getPermalink(),
            'excerpt' => !empty($resource->getFields()->getExcerpt()) ? $resource->getFields()->getExcerpt() : false,
            'date' => $resource->getFields()->getDate(),
            'id' => $resource->getFields()->getPostId(),
            'cssClass' => implode(' ', get_post_class('', $resource->getFields()->getPostId())),
            'image' => $resource->getFields()->getThumbnail() ? $resource->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['search-result']['name']) : false,
            'categories' => $resource->getFields()->getTypesName(),
            'topics' => $resource->getFields()->getPrimaryTopics() ? $resource->getFields()->getPrimaryTopics()->getFields()->getTitle() : false,
        ];
        // TODO: Implement default() method.
    }
}