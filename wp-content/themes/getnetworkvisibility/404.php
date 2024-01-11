<?php
/**
 * The template for displaying 404 pages (not found).
 */

get_header();
?>
    <div class="corner"></div>
    <div class="corner-top-right"></div>
    <div class="corner-bottom-left"></div>
    <div class="content">
        <h2 class="big is-style-blue align-center"><?php the_field('err_404_heading', 'option'); ?></h2>
        <?php echo get_field('err_404_copy', 'option'); ?>
    </div>
<?php
get_footer();
