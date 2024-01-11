<?php
/**
 * Events Archive - BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 * @var null|EventsArchive $blockObj
 */

use FINNPartners\Theme\Block\Instance\EventsArchive;
use FINNPartners\Theme\PostType\Register\Event;

$blockObj = $blockObj ?? new EventsArchive($post_id, $block, $is_preview);
/** @var EventsArchive $blockObj */

$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<section class="main-search main-events <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
         id="<?= $blockObj->getId() ?>">

    <?php $blockObj->previewNotAvailableHTML() ?>

</section>
