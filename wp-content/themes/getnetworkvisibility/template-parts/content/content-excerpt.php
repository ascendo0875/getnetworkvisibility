<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

use FINNPartners\Theme\PostType\Instance\Event;
use FINNPartners\Theme\PostType\Register\Event as EventRegister;
use FINNPartners\Theme\Taxonomy\Type;
use FINNPartners\Theme\Theme;
use FINNPartners\Theme\PostType\Instance\Resource;
use FINNPartners\Theme\PostType\Register\Resource as ResourceRegister;

if (get_post_type() === EventRegister::POST_TYPE) {
    set_query_var('event', new Event(get_the_ID()));
    get_template_part('template-parts/content/result', EventRegister::POST_TYPE);
} else {

    $resource = (get_post_type() === ResourceRegister::POST_TYPE) ? new Resource(get_the_ID()) : false;
    $getposttype = get_post_type_object(get_post_type());

    if (get_post_type() === 'post') {
        $getposttype = get_the_terms(get_the_ID(), Type::TAXONOMY_NAME);
        $getposttype = !empty($getposttype) ? join(', ', wp_list_pluck($getposttype, 'name')) : false;
    } else {
        $getposttype = $getposttype->labels->singular_name;
    }
    ?>

    <article id="post-<?php the_ID(); ?>">

        <div class="article-body">
            <div class="blurb">
                <?php if (!empty($getposttype)) : ?>
                    <h5>
                        <?php
                        echo $getposttype;
                        ?>
                    </h5>
                <?php endif; ?>
                <?php if ($resource instanceof Resource && $resource->getFields()->getPrimaryTopics()) : ?>
                    <h5 class="is-style-blue">
                        <a href="<?= $resource->getFields()->getPrimaryTopics()->getFields()->getPermalink() ?>">
                            <?php
                            echo $resource->getFields()->getPrimaryTopics()->getFields()->getTitle();
                            ?>
                        </a>
                    </h5>
                <?php endif; ?>

                <?php get_template_part('template-parts/header/excerpt-header', get_post_format()); ?>

                <?php get_template_part('template-parts/excerpt/excerpt', get_post_format()); ?>
                <!-- .entry-content -->
            </div>
            <?php if (!empty(get_the_post_thumbnail_url())) : ?>
                <div class="img lazyload"
                    <?= (get_the_post_thumbnail_url() ? "style='background-image: url(" . get_the_post_thumbnail_url(get_the_ID(), Theme::IMAGE_SIZES['search-result']['name']) . ")'" : "") ?>
                     data-bg="<?= get_the_post_thumbnail_url(get_the_ID(), Theme::IMAGE_SIZES['search-result']['name']) ?>"></div>
            <?php endif; ?>
        </div>

    </article><!-- #post-${ID} -->
    <?php
}