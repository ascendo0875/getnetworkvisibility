<?php
/**
 * @var array $args
 */

use FINNPartners\Theme\PostType\Instance\Resource as ResourceInstance;
use FINNPartners\Theme\Block\Instance\MediaVisual;
use FINNPartners\Theme\Block\Register\MediaVisual as MediaVisualRegister;
use WpAdvanceCustomFieldsExtend\Service\Media;
use WpAdvanceCustomFieldsExtend\Service\BlockRenderer;
use FINNPartners\Theme\Theme;
use FINNPartners\Theme\PostType\Instance\Topic;
use FINNPartners\Theme\PostType\Instance\Industry;
use FINNPartners\Theme\PostType\Instance\Product;
use FINNPartners\Theme\PostType\Instance\Solution;

if (isset($args['resource'])) {
    /** @var ResourceInstance $Resource */
    $Resource = $args['resource'];

    if ($Resource->getFields()->isVideo()) {
        $image = ($Resource->getFields()->getStartImageOfTheVideo() instanceof Media) ? $Resource->getFields()->getStartImageOfTheVideo() : (($Resource->getFields()->getThumbnail() instanceof Media) ? $Resource->getFields()->getThumbnail() : Theme::getImagePlaceholder());

        /** @var MediaVisual $MediaVisual */
        $MediaVisual = new MediaVisual(false, []);
        $MediaVisual->getFields()->setVideoUrl($Resource->getFields()->getResourceUrl())
            ->setImage($image);

        BlockRenderer::getService()
            ->setBlockRegister(MediaVisualRegister::class)
            ->setBlockInstance($MediaVisual)
            ->render();
    }

    ?>

    <div class="content-with-callout is-style-video-hdr">
        <div>
            <h4>Videos</h4>

            <h3><?= $Resource->getFields()->getTitle() ?></h3>

            <div class="article-info">
                <div>
                    <p>
                        <?php if ($Resource->getFields()->getPrimaryTopics()) : ?>
                            <a href="<?= $Resource->getFields()->getPrimaryTopics()->getFields()->getPermalink() ?>">
                                <?= $Resource->getFields()->getPrimaryTopics()->getFields()->getTitle() ?>
                            </a> |
                        <?php endif; ?>
                        <?= $Resource->getFields()->getDate() ?>
                    </p>
                    <ul>
                        <li><a href="#" class="social-share linkedin"><i class="icon icon-linkedin"></i></a></li>
                        <li><a href="#" class="social-share twitter"><i class="icon icon-twitter"></i></a></li>
                        <li><a href="#" class="social-share facebook"><i class="icon icon-facebook"></i></a></li>
                    </ul>
                    <p class="subscribe"><a href="#" class="btn">Subscribe</a></p>
                </div>

                <?php if ($Resource->getFields()->getAuthorName() || $Resource->getFields()->getAuthorTitle()) : ?>
                    <p>
                        <?= $Resource->getFields()->getAuthorName() ? "By {$Resource->getFields()->getAuthorName()}" : '' ?>
                        <?= ($Resource->getFields()->getAuthorName() && $Resource->getFields()->getAuthorTitle()) ? ':' : '' ?>
                        <?= $Resource->getFields()->getAuthorTitle() ? $Resource->getFields()->getAuthorTitle() : '' ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($Resource->getFields()->getTopics()) || !empty($Resource->getFields()->getProducts()) || !empty($Resource->getFields()->getSolutions()) || !empty($Resource->getFields()->getIndustries())) : ?>
            <aside>
                <p>Categories</p>
                <p>
                    <?php if (!empty($Resource->getFields()->getTopics())) : ?>

                        <?php foreach ($Resource->getFields()->getTopics() as $topic) : /** @var Topic $topic */ ?>
                            <a href="<?= $topic->getFields()->getPermalink() ?>"
                               class="btn is-style-solid"><?= $topic->getFields()->getTitle() ?></a>
                        <?php endforeach; ?>

                    <?php endif; ?>

                    <?php if (!empty($Resource->getFields()->getIndustries())) : ?>

                        <?php foreach ($Resource->getFields()->getIndustries() as $industry) : /** @var Industry $industry */ ?>
                            <a href="<?= $industry->getFields()->getPermalink() ?>"
                               class="btn is-style-solid"><?= $industry->getFields()->getTitle() ?></a>
                        <?php endforeach; ?>

                    <?php endif; ?>

                    <?php if (!empty($Resource->getFields()->getProducts())) : ?>

                        <?php foreach ($Resource->getFields()->getProducts() as $product) : /** @var Product $product */ ?>
                            <a href="<?= $product->getFields()->getPermalink() ?>"
                               class="btn is-style-solid"><?= $product->getFields()->getTitle() ?></a>
                        <?php endforeach; ?>

                    <?php endif; ?>

                    <?php if (!empty($Resource->getFields()->getSolutions())) : ?>

                        <?php foreach ($Resource->getFields()->getSolutions() as $solution) : /** @var Solution $solution */ ?>
                            <a href="<?= $solution->getFields()->getPermalink() ?>"
                               class="btn is-style-solid"><?= $solution->getFields()->getTitle() ?></a>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </p>
            </aside>
        <?php endif; ?>
    </div>

    <?php
    the_content();

}