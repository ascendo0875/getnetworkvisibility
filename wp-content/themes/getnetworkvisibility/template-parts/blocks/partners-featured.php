<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\PartnersFeatured;
use FINNPartners\Theme\PostType\Instance\Partner;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var PartnersFeatured $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new PartnersFeatured($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="partners-featured <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?php if ($blockObj->getPartners()) : ?>
        <div class="partners-list <?= $blockObj->isSideImg() ? 'is-style-side-img' : '' ?>">

            <?php foreach ($blockObj->getPartners() as $partner) : /** @var Partner $partner */ ?>
                <div class="partner">
                    <?php if ($blockObj->isSideImg() && $partner->getFields()->getThumbnail() instanceof Media) : ?>
                        <div class="img">
                            <img src="<?= $partner->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['partners-featured']['name']) ?>"
                                 width="<?= $partner->getFields()->getThumbnail()->getWidth(Theme::IMAGE_SIZES['partners-featured']['name']) ?>"
                                 height="<?= $partner->getFields()->getThumbnail()->getHeight(Theme::IMAGE_SIZES['partners-featured']['name']) ?>"
                                 alt="<?= $partner->getFields()->getThumbnail()->getAlt() ?>"/>
                        </div>
                    <?php endif; ?>
                    <?php if ($blockObj->isSideImg() && !($partner->getFields()->getThumbnail() instanceof Media) && ($f->getImagePlaceholder() instanceof Media)) : ?>
                        <div class="img">
                            <img src="<?= $f->getImagePlaceholder()->getUrl(Theme::IMAGE_SIZES['partners-featured']['name']) ?>"
                                 width="<?= $f->getImagePlaceholder()->getWidth(Theme::IMAGE_SIZES['partners-featured']['name']) ?>"
                                 height="<?= $f->getImagePlaceholder()->getHeight(Theme::IMAGE_SIZES['partners-featured']['name']) ?>"
                                 alt="<?= $f->getImagePlaceholder()->getAlt() ?>"/>
                        </div>
                    <?php endif; ?>
                    <div class="blurb">
                        <h4><?= $partner->getFields()->getTitle() ?></h4>
                        <?= $partner->getFields()->getExcerpt() ? wpautop($partner->getFields()->getExcerpt()) : '' ?>
                        <p><a href="<?= $partner->getFields()->getPermalink() ?>" class="btn">
                                <?= sprintf($f->getLabelForPartnerCta(), $partner->getFields()->getTitle()) ?>
                            </a></p>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <?php if ($f->isAddCta() && $f->getLinkCta()) : ?>
            <div class="wp-block-separator"></div>
            <p class="align-center">
                <a href="<?= $f->getLinkCta() ?>" class="btn is-style-solid"><?= $f->getLabelCta() ?></a>
            </p>
        <?php endif; ?>

    <?php endif; ?>

    <?php $blockObj->previewNotAvailableHTML(); ?>

</div>
