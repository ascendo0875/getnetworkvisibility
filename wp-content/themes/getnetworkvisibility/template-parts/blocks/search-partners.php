<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\SearchPartners;

/** @var SearchPartners $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new SearchPartners($post_id, $block, $is_preview);

$blockObj->displayAdminAnchorHTML();
?>

<section class="main-search <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
         id="<?= $blockObj->getId() ?>">

    <?php $blockObj->previewNotAvailableHTML() ?>

</section>
