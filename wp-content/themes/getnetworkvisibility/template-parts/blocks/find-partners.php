<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\FindPartners;
use FINNPartners\Theme\Api\Partner as PartnerApi;

/** @var FindPartners $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new FindPartners($post_id, $block, $is_preview);
$f = $blockObj->getFields();
$blockObj->displayAdminAnchorHTML();
?>

<div class="main-search is-style-center">
    <?php if ($f->getSubheading()) : ?>
        <h3 class="is-style-gradient"><?= $f->getSubheading() ?></h3>
    <?php endif; ?>

    <?php if ($f->getHeading()) : ?>
        <h3><?= $f->getHeading() ?></h3>
    <?php endif; ?>

    <form action="<?= $f->getLandingSearchPage() ?>">
        <div class="search-area">
            <input type="search" name="<?= PartnerApi::API_QUERY_SEARCH ?>" placeholder="type a keyword" value=""/>
            <input type="submit" value="search"/>
        </div>
    </form>
</div>
