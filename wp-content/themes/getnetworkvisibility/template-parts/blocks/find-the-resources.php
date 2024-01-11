<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\FindTheResources;

/** @var FindTheResources $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new FindTheResources($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<section class="find-the-resources <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
        id="<?= $blockObj->getId() ?>"><?= $f->getLabel() ?></section>
