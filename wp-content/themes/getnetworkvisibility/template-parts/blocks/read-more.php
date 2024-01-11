<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\ReadMore;
use FINNPartners\Theme\Block\Register\ReadMore as ReadMoreRegister;

/** @var ReadMore $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new ReadMore($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();

$linkClass = (in_array('center', (array)$blockObj->getCSSClasses())) ? 'has-text-align-center' : '';
?>

<div class="read-more <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>" data-role="read-more">

    <div class="read-more-content" <?= $blockObj->isPreview() ? '' : 'style="display:none;"' ?>>
        <?= ReadMoreRegister::getInnerBlocksHTMLTag(ReadMoreRegister::class) ?>
    </div>

    <p class="<?= $linkClass ?>">
        <a href="#" aria-controls="#<?= $blockObj->getId() ?>"
           class="more read-more<?= !$blockObj->isPreview() ? '' : ' hidden' ?>"><?= $f->getMoreLabel() ?></a>
        <a href="#" aria-controls="#<?= $blockObj->getId() ?>"
           class="more read-less<?= $blockObj->isPreview() ? '' : ' hidden' ?>"><?= $f->getLessLabel() ?></a>
    </p>
</div>
