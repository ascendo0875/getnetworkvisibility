<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Carousel;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var Carousel $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Carousel($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<?php if (!empty($f->getCarousel())) : ?>
    <div class="carousel <?= $blockObj->getCSSClassesAsString() ?>"
        <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
         id="<?= $blockObj->getId() ?>">

        <div class="slider-holder loading">

            <div class="carousel-items loading is-slider">

                <?php
                if (!empty($f->getCarousel())) {
                    foreach ($f->getCarousel() as $carousel) {
                        $image = Media::getInstance($carousel['image']);
                        if (!empty($carousel['url'])) {
                            ?>

                            <a href="<?= $carousel['url']['url'] ?>" target="<?= $carousel['url']['target'] ?>">
                                <?php if ($image instanceof Media) : ?>
                                    <div class="img lazyload"
                                        <?= ($blockObj->isPreview() ? "style='background-image: url({$image->getUrl(Theme::IMAGE_SIZES['carousel']['name'])})'" : "") ?>
                                         data-bg="<?= $image->getUrl(Theme::IMAGE_SIZES['carousel']['name']) ?>"></div>
                                <?php endif; ?>

                                <div class="blurb">
                                    <?php if ($carousel['title']) {
                                        ?>
                                        <h4><?= $carousel['title'] ?></h4>
                                        <?php
                                    } ?>
                                </div>
                            </a>

                            <?php
                        } else {
                            ?>
                            <div>
                                <?php if ($image instanceof Media) : ?>
                                    <div class="img lazyload"
                                        <?= ($blockObj->isPreview() ? "style='background-image: url({$image->getUrl(Theme::IMAGE_SIZES['carousel']['name'])})'" : "") ?>
                                         data-bg="<?= $image->getUrl(Theme::IMAGE_SIZES['carousel']['name']) ?>"></div>
                                <?php endif; ?>

                                <div class="blurb">
                                    <?php if ($carousel['title']) {
                                        ?>
                                        <h4><?= $carousel['title'] ?></h4>
                                        <?php
                                    } ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>

        </div>

    </div>
<?php endif; ?>

<?php
$blockObj->previewNotAvailableHTML();
?>
