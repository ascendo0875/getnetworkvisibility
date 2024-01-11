<?php
/**
 * Show the excerpt.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @since 1.0.0
 */

$excerpt = get_the_excerpt();
?>
<p><?php echo $excerpt; ?></p>
