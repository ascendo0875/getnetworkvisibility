<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\ContentWithCallout;
use FINNPartners\Theme\Block\Register\ContentWithCallout as ContentWithCalloutRegister;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var ContentWithCallout $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new ContentWithCallout($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="content-with-callout <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <div>

        <?= ContentWithCalloutRegister::getInnerBlocksHTMLTag(ContentWithCalloutRegister::class) ?>

    </div>

    <?php if ($f->getAside()): ?>
        <aside>
            <?= $f->getAside() ?>
        </aside>
    <?php endif; ?>

</div>