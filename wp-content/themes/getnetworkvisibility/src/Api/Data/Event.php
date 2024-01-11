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
use FINNPartners\Theme\PostType\Instance\Event as EventInstance;

class Event implements EntityDataInterface
{
    public static function default(?EntityInterface $post): array
    {
        /** @var EventInstance $event */
        $event = new EventInstance($post->getId());

        // TODO: Implement default() method.
        return [
            'title' => $event->getFields()->getTitle(),
            'permalink' => $event->getFields()->getPermalink(),
            'date' => $event->getDate(),
            'dontLinkToDetailPage' => $event->getFields()->isDontLinkToDetailPage(),
            'location' => $event->getFields()->getLocation() ? wp_list_pluck($event->getFields()->getLocation(), 'address') : false,
            'excerpt' => $event->getFields()->getExcerpt(),
            'id' => $event->getFields()->getPostId(),
            'cssClass' => implode(' ', get_post_class($event->getFields()->isDontLinkToDetailPage() ? 'dont-link' : '', $event->getFields()->getPostId())),
            'image' => $event->getFields()->getThumbnail() ? $event->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['resources_list']['name']) : false,
            'registerPage' => $event->getFields()->getRegisterPage() ? $event->getFields()->getRegisterPage()['url'] : false,
            'registerPageLabel' => $event->getFields()->getRegisterPage() ? $event->getFields()->getRegisterPage()['title'] : false,
            'registerPageTarget' => $event->getFields()->getRegisterPage() ? $event->getFields()->getRegisterPage()['target'] : '',
        ];
        // TODO: Implement default() method.
    }
}