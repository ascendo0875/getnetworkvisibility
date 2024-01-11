<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Values;
use FINNPartners\Theme\Block\Register\Values as ValuesRegister;

/** @var Values $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Values($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="values-block <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?= ValuesRegister::getInnerBlocksHTMLTag(ValuesRegister::class) ?>


</div>
