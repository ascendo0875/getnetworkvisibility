<?php
/**
 * The template for displaying resource page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FinnPartners
 * @since 1.0
 * @version 1.0
 */

use FINNPartners\Theme\Block\Instance\Hero;
use FINNPartners\Theme\Block\Register\Hero as HeroRegister;
use FINNPartners\Theme\PostType\Instance\Resource;
use WpAdvanceCustomFieldsExtend\Service\BlockRenderer;
use WpAdvanceCustomFieldsExtend\Service\Media;
use FINNPartners\Theme\Block\Instance\ResourcesList;
use FINNPartners\Theme\Block\Instance\Fields\ResourcesListFields;
use FINNPartners\Theme\Block\Register\ResourcesList as ResourcesListRegister;

get_header();

if (have_posts()) {

    do {
        the_post();

        /** @var Resource $Resource */
        $Resource = new Resource(get_the_ID());


        if ($Resource->getFields()->isVideo() || $Resource->getFields()->isVimeo()) {
            get_template_part('template-parts/content/resource', 'single-video', ['resource' => $Resource]);
        } else {
            $heroImage = $Resource->getFields()->getThumbnail();
            if (empty($heroImage)) {
                $heroImage = get_field('single_resource_hero_image', 'option');
                $heroImage = !empty($heroImage) ? Media::getInstance($heroImage) : false;
            }

            /** @var Hero $Hero */
            $Hero = new Hero();
            $Hero->getFields()
                ->setBackgroundImage($heroImage)
                ->setHeading($Resource->getFields()->getTitle())
                ->setSubheading(
                    $Resource->getFields()->getPrimaryTopics() ? "<a href='{$Resource->getFields()->getPrimaryTopics()->getFields()->getPermalink()}'>{$Resource->getFields()->getPrimaryTopics()->getFields()->getTitle()}</a>" : false
                );
            ?>

            <?php
            BlockRenderer::getService()
                ->setBlockRegister(HeroRegister::class)
                ->setBlockInstance($Hero)
                ->render();
            ?>

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
                </div>
                <?php if ($Resource->getFields()->getAuthorName() || $Resource->getFields()->getAuthorTitle()) : ?>
                    <p>
                        <?= $Resource->getFields()->getAuthorName() ? "By {$Resource->getFields()->getAuthorName()}" : '' ?>
                        <?= ($Resource->getFields()->getAuthorName() && $Resource->getFields()->getAuthorTitle()) ? ':' : '' ?>
                        <?= $Resource->getFields()->getAuthorTitle() ? $Resource->getFields()->getAuthorTitle() : '' ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php
            the_content();
            ?>
            <?php if ($Resource->getFields()->getResourceFile()) : ?>
                <p class="align-center"><a href="<?= $Resource->getFields()->getResourceFile()->getUrl() ?>"
                                           class="btn is-style-download">Download the PDF</a></p>
            <?php endif; ?>
            <?php if ($Resource->getFields()->getResourceUrl()) : ?>
                <p class="align-center"><a href="<?= $Resource->getFields()->getResourceUrl() ?>" class="btn">View
                        resource</a></p>
            <?php endif; ?>
            <?php
        }


    } while (have_posts());

}

get_footer();
