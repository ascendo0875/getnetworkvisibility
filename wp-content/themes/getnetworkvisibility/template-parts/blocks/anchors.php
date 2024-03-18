<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Anchors;

/** @var Anchors $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Anchors($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>
<style>
.admin-bar .anchors {
    top:177px !important;
}
</style>

<div class="anchors <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <div class="wrapper">

        <?php if ($f->getNavigation()) : ?>
            <ul>

                <?php foreach ($f->getNavigation() as $key => $navigation) : ?>
                    <?php if (is_array($navigation) && isset($navigation['link']) && is_array($navigation['link'])) : ?>
                    <li class="<?= $key === 0 ? "active" : "" ?>"><a href="<?= $navigation['link']['url'] ?>"><?= $navigation['link']['title'] ?></a></li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <select name="anchors" data-anchors-scroll="true">

                <?php foreach ($f->getNavigation() as $key => $navigation) : ?>
                    <?php if (is_array($navigation) && isset($navigation['link']) && is_array($navigation['link'])) : ?>
                        <option value="<?= isset($navigation['link']['url']) ? $navigation['link']['url'] : '' ?>" <?= $key === 0 ? "selected" : "" ?>>
                            <?= isset($navigation['link']['title']) ? $navigation['link']['title'] : '' ?>
                        </option>
                    <?php endif; ?>

                    <?php endforeach; ?>
            </select>
        <?php endif; ?>

    </div>

</div>
