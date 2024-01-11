<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package GTIndependence
 * @since 1.0
 * @version 1.0
 */


use FINNPartners\Theme\Block\Instance\Hero;
use FINNPartners\Theme\Block\Register\Hero as HeroRegister;
use FINNPartners\Theme\PostType\Instance\Event;
use WpAdvanceCustomFieldsExtend\Service\BlockRenderer;

get_header();

if (have_posts()) {

    do {

        the_post();

        /** @var Event $Event */
        $Event = new Event(get_the_ID());

        /** @var Hero $Hero */
        $Hero = new Hero();
        $Hero->getFields()
            ->setBackgroundImage($Event->getFields()->getThumbnail())
            ->setHeading($Event->getFields()->getTitle())
            ->setCopy($Event->getDateAndLocation())
            ->setFormType(false)
            ->setSubheading(get_post_type());

        BlockRenderer::getService()
            ->setBlockRegister(HeroRegister::class)
            ->setBlockInstance($Hero)
            ->render();

        ?>
        <div class="article-info">
            <div>
                <p><?= $Event->getFields()->getLocation() ? "{$Event->getFields()->getLocation()} | " : "" ?><?= $Event->getDate() ?></p>
                <ul>
                    <li><a href="#" class="social-share linkedin"><i class="icon icon-linkedin"></i></a></li>
                    <li><a href="#" class="social-share twitter"><i class="icon icon-twitter"></i></a></li>
                    <li><a href="#" class="social-share facebook"><i class="icon icon-facebook"></i></a></li>
                </ul>
            </div>
            <?php /*<p><a href="#">By </a> | 10min read</p>*/ ?>
        </div>
<?php
        the_content();
        ?>

        <?php if ($Event->getFields()->getRegisterPage()) : ?>
            <p class="align-center"><a href="<?= $Event->getFields()->getRegisterPage()['url'] ?>"
                                       target="<?= $Event->getFields()->getRegisterPage()['target'] ?>"
                                       class="btn is-style-download"><?= $Event->getFields()->getRegisterPage()['title'] ?></a></p>
        <?php endif; ?>

<?php

    } while (have_posts());

}

get_footer();
