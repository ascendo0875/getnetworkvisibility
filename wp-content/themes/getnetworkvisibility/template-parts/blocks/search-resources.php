<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\SearchResources;

/** @var SearchResources $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new SearchResources($post_id, $block, $is_preview);
$f = $blockObj->getFields();
$blockObj->displayAdminAnchorHTML();
?>

<section class="main-search <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
         id="<?= $blockObj->getId() ?>">

    <?php $blockObj->previewNotAvailableHTML() ?>

</section>
