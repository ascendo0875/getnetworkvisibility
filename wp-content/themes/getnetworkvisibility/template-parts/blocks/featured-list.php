<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\FeaturedList;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;
use FINNPartners\Theme\PostType\Instance\Customer;
use FINNPartners\Theme\PostType\Instance\Resource;
use FINNPartners\Theme\PostType\Instance\Partner;

/** @var FeaturedList $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new FeaturedList($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="featured-list  <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <div class="slider-holder loading">

        <div class="featured-items loading <?= $blockObj->isSlider() ? 'is-slider' : '' ?>">

            <?php if (!empty($blockObj->getArticles())) : ?>
                <?php foreach ($blockObj->getArticles() as $article): ?>
                    <?php
                    $cssClass = [];
                    if ($article instanceof Resource && $article->getFields()->isVideo()) {
                        $cssClass[] = 'video-type';
                    }
                    $image = ($article->getFields()->getThumbnail() instanceof Media) ? $article->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['featured_list']['name']) : (Theme::getImagePlaceholder() ? Theme::getImagePlaceholder()->getUrl(Theme::IMAGE_SIZES['featured_list']['name']) : Theme::getInstance()->getPathUrl() . '/images/placeholder-929x520.jpg');
                    $getPostClass = get_post_class($cssClass, $article->getFields()->getPostId());
                    $title = $f->isDisplayTitle() ? $article->getFields()->getTitle() : false;

                    if ($f->isApplyingUrlOnElement()) {
                        ?>
                        <a href="<?= $article->getFields()->getPermalink() ?>"
                           class="<?= implode(' ', $getPostClass) ?>">
                            <?php if (!empty($image)) : ?>
                                <div class="img lazyload"
                                    <?= ($blockObj->isPreview() ? "style='background-image: url({$image})'" : "") ?>
                                     data-bg="<?= $image ?>"></div>
                            <?php endif; ?>

                            <div class="blurb">
                                <?php if ($title) : ?>
                                    <h4><?= $title ?></h4>
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php
                    } else {
                        ?>
                        <div
                                class="<?= implode(' ', $getPostClass) ?>">
                            <?php if (!empty($image)) : ?>
                                <div class="img lazyload"
                                    <?= ($blockObj->isPreview() ? "style='background-image: url({$image})'" : "") ?>
                                     data-bg="<?= $image ?>"></div>
                            <?php endif; ?>

                            <div class="blurb">
                                <?php if ($title) : ?>
                                    <h4><?= $title ?></h4>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php
            $blockObj->previewNotAvailableHTML();
            ?>

        </div>

    </div>

</div>
