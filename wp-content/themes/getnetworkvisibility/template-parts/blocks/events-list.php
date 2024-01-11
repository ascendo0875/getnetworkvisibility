<?php
/**
 * Events Archive - BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 * @var null|EventsList $blockObj
 */

use FINNPartners\Theme\Block\Instance\EventsList;
use FINNPartners\Theme\PostType\Register\Event;

$blockObj = $blockObj ?? new EventsList($post_id, $block, $is_preview);
/** @var EventsList $blockObj */

$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
$blockObj->previewNotAvailableHTML();

if (!empty($blockObj->getEvents())) {
    ?>
    <div class="events-list <?= $blockObj->getCSSClassesAsString() ?>"
        <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
         id="<?= $blockObj->getId() ?>">

        <h3><?= $f->getHeading() ?></h3>

        <div class="events">
            <?php


            set_query_var('isPreview', $blockObj->isPreview());

            foreach ($blockObj->getEvents() as $event) {
                set_query_var('event', $event);
                get_template_part('template-parts/content/result', Event::POST_TYPE, ['displayExcerpt' => false, 'displayLearnMoreBtn' => false]);
            }
            ?>

        </div>

    </div>
    <?php
}
wp_reset_query();
