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
use FINNPartners\Theme\PostType\Instance\Partner as PartnerInstance;

class Partner implements EntityDataInterface
{
    public static function default(?EntityInterface $post): array
    {
        /** @var PartnerInstance $resource */
        $resource = new PartnerInstance($post->getId());

        // TODO: Implement default() method.
        return [
            'title' => $resource->getFields()->getTitle(),
            'permalink' => $resource->getFields()->getPermalink(),
            'date' => $resource->getFields()->getDate(),
            'excerpt' => $resource->getFields()->getExcerpt(),
            'id' => $resource->getFields()->getPostId(),
            'cssClass' => implode(' ', get_post_class('', $resource->getFields()->getPostId())),
            'image' => $resource->getFields()->getThumbnail() ? $resource->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['search-partners']['name']) : false,
        ];
        // TODO: Implement default() method.
    }
}