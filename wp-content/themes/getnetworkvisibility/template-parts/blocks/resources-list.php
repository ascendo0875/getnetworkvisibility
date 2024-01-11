<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\ResourcesList;
use FINNPartners\Theme\PostType\Instance\Resource;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var ResourcesList $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new ResourcesList($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<?php if (!empty($blockObj->getResources())) : ?>
    <?php if ($f->isAddButtonSeeAllRelated() && $f->getSearchLandingPage()) : ?>
        <p class="alignright"><a class="btn" href="<?= $f->getSearchLandingPage() ?>?query-<?= get_post_type($f->getPostId()) ?>=<?= get_post_field('post_name', $f->getPostId()) ?>"><?= $f->getLabelButtonSeeAllRelated() ?></a></p>
    <?php endif; ?>
    
    <?php if ($f->getHeading()) : ?>
        <h2><?= $f->getHeading() ?></h2>
    <?php endif; ?>


    <div class="articles-list <?= $blockObj->getCSSClassesAsString() ?>"
        <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
         id="<?= $blockObj->getId() ?>">

        <?php if (!empty($blockObj->getResources())) : ?>
            <?php foreach ($blockObj->getResources() as $resource): ?>
                <?php
                $cssClass = ['article'];

                if($resource->getFields()->isVideo()) {
                    $cssClass[] = 'video-type';
                }

                /** @var Resource $resource */
                get_template_part('template-parts/content/resource', null, ['resource' => [
                    'id' => $resource->getFields()->getPostId(),
                    'permalink' => $resource->getFields()->getPermalink(),
                    'title' => $resource->getFields()->getTitle(),
                    'categories' => !empty($resource->getFields()->getTypesName()) ? implode(', ', $resource->getFields()->getTypesName()) : false,
                    'image' => ($f->isDisplayImage() && ($resource->getFields()->getThumbnail() instanceof Media)) ? $resource->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['resources_list']['name']) : (($f->isDisplayImage()) ? (Theme::getImagePlaceholder() ? Theme::getImagePlaceholder()->getUrl(Theme::IMAGE_SIZES['resources_list']['name']) : Theme::getInstance()->getPathUrl() . '/images/placeholder-'.Theme::IMAGE_SIZES['resources_list']['width'].'x'.Theme::IMAGE_SIZES['resources_list']['height'].'.jpg') : ''),
                    'cssClass' => implode(' ', $cssClass),
                    'isPreview' => $blockObj->isPreview(),
                ]]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php $blockObj->previewNotAvailableHTML() ?>

    </div>
<?php endif; ?>

<?php
$blockObj->previewNotAvailableHTML();
?>