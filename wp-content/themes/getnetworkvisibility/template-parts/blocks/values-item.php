<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\ValuesItem;
use FINNPartners\Theme\Block\Register\ValuesItem as ValuesItemRegister;

/** @var ValuesItem $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new ValuesItem($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="values-item <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?php if (!empty($f->getHeading())) : ?>
        <h3><?= $f->getHeading() ?></h3>
    <?php endif; ?>

    <div class="expend">
        <?= ValuesItemRegister::getInnerBlocksHTMLTag(ValuesItemRegister::class) ?>
    </div>

</div>
