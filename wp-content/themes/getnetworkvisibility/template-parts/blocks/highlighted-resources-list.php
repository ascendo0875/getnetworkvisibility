<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\HighlightedResourcesList;
use FINNPartners\Theme\PostType\Instance\Resource;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var HighlightedResourcesList $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new HighlightedResourcesList($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="highlighted-articles-list <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?php

    if (!empty($blockObj->getHighlightedResource())) {
        /** @var Resource $resource */
        $resource = $blockObj->getHighlightedResource();
        $highlightedResource = $resource->getFields();
        $cssClass = ['article'];

        if($highlightedResource->isVideo()) {
            $cssClass[] = 'video-type';
        }

        get_template_part('template-parts/content/resource', null, ['resource' => [
            'id' => $highlightedResource->getPostId(),
            'permalink' => $highlightedResource->getPermalink(),
            'excerpt' => $f->isDisplayExcerpt() ? $highlightedResource->getExcerpt() : false,
            'title' => $highlightedResource->getTitle(),
            'categories' => !empty($highlightedResource->getTypesName()) ? implode(', ', $highlightedResource->getTypesName()) : false,
            'image' => ($highlightedResource->getThumbnail() instanceof Media) ? $highlightedResource->getThumbnail()->getUrl(Theme::IMAGE_SIZES['highlighted_resource']['name']) : (Theme::getImagePlaceholder() ? Theme::getImagePlaceholder()->getUrl(Theme::IMAGE_SIZES['highlighted_resource']['name']) : Theme::getInstance()->getPathUrl().'images/placeholder-'.Theme::IMAGE_SIZES['highlighted_resource']['width'].'x'.Theme::IMAGE_SIZES['highlighted_resource']['height'].'.jpg'),
            'cssClass' => implode(' ', $cssClass),
            'isPreview' => $blockObj->isPreview(),
        ]]);
    }

    ?>

    <?php if (!empty($blockObj->getResources())) : ?>
        <div class="slider-holder loading">
            <div class="side-articles loading">

                <?php foreach ($blockObj->getResources() as $resource): ?>
                    <div>
                        <?php
                        $cssClass = ['article'];
                        if($resource->getFields()->isVideo()) {
                            $cssClass[] = 'video-type';
                        }
                        /** @var Resource $resource */
                        get_template_part('template-parts/content/resource', null, ['resource' => [
                            'id'        => $resource->getFields()->getPostId(),
                            'permalink' => $resource->getFields()->getPermalink(),
                            'title' => $resource->getFields()->getTitle(),
                            'categories' => !empty($resource->getFields()->getTypesName()) ? implode(', ', $resource->getFields()->getTypesName()) : false,
                            'image' => ($resource->getFields()->getThumbnail() instanceof Media) ? $resource->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['highlighted_resources_list']['name']) : (Theme::getImagePlaceholder() ? Theme::getImagePlaceholder()->getUrl(Theme::IMAGE_SIZES['highlighted_resources_list']['name']) : Theme::getInstance()->getPathUrl().'images/placeholder-'.Theme::IMAGE_SIZES['highlighted_resources_list']['width'].'x'.Theme::IMAGE_SIZES['highlighted_resources_list']['height'].'.jpg'),
                            'cssClass' => implode(' ', $cssClass),
                            'isPreview' => $blockObj->isPreview(),
                            'excerpt' => $f->isDisplayExcerpt() ? $resource->getFields()->getExcerpt() : false,
                        ]]);
                        ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>

    <?php $blockObj->previewNotAvailableHTML() ?>

</div>
