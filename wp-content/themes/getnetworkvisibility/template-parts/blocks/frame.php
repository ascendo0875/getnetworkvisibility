<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Frame;
use FINNPartners\Theme\Block\Register\Frame as FrameRegister;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var Frame $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Frame($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="frame-fp-block <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?php if (($f->getBackgroundImage() instanceof Media)) : ?>
        <div class="img lazyload"
            <?= ($blockObj->isPreview() ? "style='background-image: url({$f->getBackgroundImage()->getUrl(Theme::IMAGE_SIZES['frame']['name'])})'" : "") ?>
             data-bg="<?= $f->getBackgroundImage()->getUrl(Theme::IMAGE_SIZES['frame']['name']) ?>"></div>
    <?php endif; ?>

    <div class="wrapper">

        <?= FrameRegister::getInnerBlocksHTMLTag(FrameRegister::class) ?>
        
    </div>

</div>
