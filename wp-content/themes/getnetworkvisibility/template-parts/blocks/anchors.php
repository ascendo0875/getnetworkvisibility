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

<div class="anchors <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <div class="wrapper">

        <?php if ($f->getNavigation()) : ?>
            <ul>

                <?php foreach ($f->getNavigation() as $key => $navigation) : ?>
                    <li class="<?= $key === 0 ? "active" : "" ?>"><a href="<?=$navigation['link']['url']?>"><?=$navigation['link']['title']?></a></li>
                <?php endforeach; ?>
            </ul>
            <select name="anchors" data-anchors-scroll="true">

                <?php foreach ($f->getNavigation() as $key => $navigation) : ?>
                    <option value="<?=$navigation['link']['url']?>" <?= $key === 0 ? "selected" : "" ?>><?=$navigation['link']['title']?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

    </div>

</div>
