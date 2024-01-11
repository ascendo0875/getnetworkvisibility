<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Transcript;
use FINNPartners\Theme\Block\Register\Transcript as TranscriptRegister;

/** @var Transcript $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Transcript($post_id, $block, $is_preview);
$f = $blockObj->getFields();

?>

<div class="transcript-block <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <?= TranscriptRegister::getInnerBlocksHTMLTag(TranscriptRegister::class) ?>

</div>
