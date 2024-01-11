<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\CustomersFeatured;
use FINNPartners\Theme\PostType\Instance\Customer;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var CustomersFeatured $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new CustomersFeatured($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="customers-featured <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?php if ($blockObj->getCustomers()) : ?>
        <div class="partners-list <?= $blockObj->isSideImg() ? 'is-style-side-img' : '' ?>">

            <?php foreach ($blockObj->getCustomers() as $customer) : /** @var Customer $customer */ ?>
                <div class="partner">
                    <?php if ($blockObj->isSideImg() && $customer->getFields()->getThumbnail() instanceof Media) : ?>
                        <div class="img">
                            <img src="<?= $customer->getFields()->getThumbnail()->getUrl(Theme::IMAGE_SIZES['customers-featured']['name']) ?>"
                                 width="<?= $customer->getFields()->getThumbnail()->getWidth(Theme::IMAGE_SIZES['customers-featured']['name']) ?>"
                                 height="<?= $customer->getFields()->getThumbnail()->getHeight(Theme::IMAGE_SIZES['customers-featured']['name']) ?>"
                                 alt="<?= $customer->getFields()->getThumbnail()->getAlt() ?>"/>
                        </div>
                    <?php endif; ?>
                    <?php if ($blockObj->isSideImg() && !($customer->getFields()->getThumbnail() instanceof Media) && ($f->getImagePlaceholder() instanceof Media)) : ?>
                        <div class="img">
                            <img src="<?= $f->getImagePlaceholder()->getUrl(Theme::IMAGE_SIZES['customers-featured']['name']) ?>"
                                 width="<?= $f->getImagePlaceholder()->getWidth(Theme::IMAGE_SIZES['customers-featured']['name']) ?>"
                                 height="<?= $f->getImagePlaceholder()->getHeight(Theme::IMAGE_SIZES['customers-featured']['name']) ?>"
                                 alt="<?= $f->getImagePlaceholder()->getAlt() ?>"/>
                        </div>
                    <?php endif; ?>
                    <div class="blurb">
                        <h4><?= $customer->getFields()->getTitle() ?></h4>
                        <?= $customer->getFields()->getExcerpt() ? wpautop($customer->getFields()->getExcerpt()) : '' ?>
                        <p><a href="<?= $customer->getFields()->getPermalink() ?>" class="btn">
                                <?= sprintf($f->getLabelForCustomerCta(), $customer->getFields()->getTitle()) ?>
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
