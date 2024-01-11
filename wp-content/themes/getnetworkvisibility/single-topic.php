<?php


use FINNPartners\Theme\Block\Instance\Hero;
use FINNPartners\Theme\Block\Register\Hero as HeroRegister;
use FINNPartners\Theme\PostType\Instance\Resource;
use WpAdvanceCustomFieldsExtend\Service\BlockRenderer;

get_header();

if (have_posts()) {

    do {
        the_post();

        /** @var Resource $Resource */
        $Resource = new Resource(get_the_ID());

        /** @var Hero $Hero */
        $Hero = new Hero();
        $Hero->getFields()
            ->setBackgroundImage($Resource->getFields()->getThumbnail())
            ->setHeading($Resource->getFields()->getTitle())
            ->setSubheading('Hot Topics');
        ?>

        <?php
        BlockRenderer::getService()
            ->setBlockRegister(HeroRegister::class)
            ->setBlockInstance($Hero)
            ->render();
        ?>


        <?php
        the_content();

    } while (have_posts());

}

get_footer();
