<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Newsletter;

/** @var Newsletter $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Newsletter($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="newsletter <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">
    <div class="blurb">

        <?php if ($f->getHeading()) : ?>
            <h3><?= $f->getHeading() ?></h3>
        <?php endif; ?>

    </div>
    <div class="form">

        <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
        <script>
            hbspt.forms.create({
                region: "na1",
                portalId: "21949588",
                formId: "4e2769f3-0505-440a-b8e2-68c0d3337667"
            });
        </script>

    </div>
</div>
