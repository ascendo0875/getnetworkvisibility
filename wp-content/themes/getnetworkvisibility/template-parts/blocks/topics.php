<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Topics;
use FINNPartners\Theme\PostType\Instance\Topic;

/** @var Topics $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Topics($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$index = 0;

$blockObj->displayAdminAnchorHTML();
?>

<?php if ($f->getPrimaryTopics() || $f->getOtherTopics()) : ?>
    <div class="slider-holder loading <?= $blockObj->getCSSClassesAsString() ?>"
        <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
         id="<?= $blockObj->getId() ?>">
        <div class="topics-slider loading <?=$f->isAddButtonShowMore()?'is-show-more':''?>">

            <?php if ($f->getPrimaryTopics()) : ?>

                <?php foreach ($f->getPrimaryTopics() as $key => $topic) : $topic = new Topic($topic); /** @var Topic $topic */ ?>
                    <div class="is-style-main-topic" data-topic-index="<?=$index++?>">
                        <a href="<?= $topic->getFields()->getPermalink() ?>" class="topic-item">
                            <div class="icon">
                                <div class="icon-int">
                                    <?php if ($topic->getFields()->getIcon()) : ?>
                                        <img src="<?= $topic->getFields()->getIcon()->getUrl() ?>"
                                             width="335" height="67"
                                             alt="<?= $topic->getFields()->getTitle() ?>"/>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?= $topic->getFields()->getTitle() ?>
                        </a>
                    </div>
                <?php endforeach; ?>
                <break data-topic-index="<?=$index++?>"></break>
            <?php endif; ?>

            <?php if ($f->getOtherTopics()) : ?>

                <?php foreach ($f->getOtherTopics() as $topic) : $topic = new Topic($topic); /** @var Topic $topic */ ?>
                    <div class="is-style-topic" data-topic-index="<?=$index++?>">
                        <a href="<?= $topic->getFields()->getPermalink() ?>" class="topic-item">
                            <div class="icon">
                                <div class="icon-int">
                                    <?php if ($topic->getFields()->getIcon()) : ?>
                                        <img src="<?= $topic->getFields()->getIcon()->getUrl() ?>"
                                             width="335" height="67"
                                             alt="<?= $topic->getFields()->getTitle() ?>"/>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?= $topic->getFields()->getTitle() ?>
                        </a>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>

        <?php if ($f->isAddButtonShowMore()): ?>
            <button class="show-more" data-show-more="#<?= $blockObj->getId() ?> .is-show-more"><?= $f->getLabelButtonShowMore() ?></button>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($blockObj->isPreview() && !$f->getPrimaryTopics() && !$f->getOtherTopics()) {
    $blockObj->previewNotAvailableHTML();
}
