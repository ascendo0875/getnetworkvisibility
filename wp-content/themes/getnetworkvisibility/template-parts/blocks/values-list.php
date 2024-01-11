<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\ValuesList;
use FINNPartners\Theme\Block\Register\ValuesList as ValuesListRegister;

/** @var ValuesList $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new ValuesList($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="values-list <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?= ValuesListRegister::getInnerBlocksHTMLTag(ValuesListRegister::class) ?>

</div>
