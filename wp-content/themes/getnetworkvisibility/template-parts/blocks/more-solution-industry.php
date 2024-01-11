<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\MoreSolutionIndustry;
use FINNPartners\Theme\PostType\Instance\Industry;
use FINNPartners\Theme\PostType\Instance\Solution;
use FINNPartners\Theme\Theme;

/** @var MoreSolutionIndustry $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new MoreSolutionIndustry($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<?php if ($blockObj->getArticles()) : ?>
    <section class="more-solution-market <?= $blockObj->getCSSClassesAsString() ?>"
        <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
             id="<?= $blockObj->getId() ?>">

        <?php if ($f->getHeading()) : ?>
            <h2 class="has-text-align-center"><?= $f->getHeading() ?></h2>
        <?php endif; ?>

        <div class="articles-list">
            <?php
            foreach ($blockObj->getArticles() as $article) {
                /** @var Industry|Solution $article */
                echo get_template_part('template-parts/content/article', null, ['article' => [
                    'id' => $article->getFields()->getPostId(),
                    'title' => $article->getFields()->getTitle(),
                    'image' => $article->getFields()->getThumbnail() ? $article->getFields()->getThumbnail()->getUrl() : (Theme::getImagePlaceholder() ? Theme::getImagePlaceholder()->getUrl() : ''),
                    'isPreview' => $blockObj->isPreview(),
                    'permalink' => $article->getFields()->getPermalink(),
                ]]);
            }
            ?>
        </div>
    </section>
<?php endif; ?>

<?php $blockObj->previewNotAvailableHTML(); ?>
