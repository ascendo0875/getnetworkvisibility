<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\ContentWithImage;
use FINNPartners\Theme\Block\Register\ContentWithImage as ContentWithImageRegister;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var ContentWithImage $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new ContentWithImage($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="content-with-image <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">
    <div class="blurb">

        <?= ContentWithImageRegister::getInnerBlocksHTMLTag(ContentWithImageRegister::class) ?>

    </div>

    <?php if ($f->getImage() instanceof Media) : ?>
        <img src="<?= $f->getImage()->getUrl(Theme::IMAGE_SIZES['content-with-image']['name']) ?>" width="<?= $f->getImage()->getWidth(Theme::IMAGE_SIZES['content-with-image']['name']) ?>"
             height="<?= $f->getImage()->getHeight(Theme::IMAGE_SIZES['content-with-image']['name']) ?>" alt="<?= $f->getImage()->getAlt() ?>"/>
    <?php endif; ?>
</div>