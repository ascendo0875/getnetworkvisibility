<?php
/**
 * Accordion - BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

/* START - InnerBlocks Properties */
$props = [];
$template = [];

if (!empty($template)) {
    $props[] = 'template="' . esc_attr(wp_json_encode($template)) . '"';
}

$allowed_blocks = [
    'acf/' . \FINNPartners\Theme\Block\Register\AccordionContent::NAME,
];

if (!empty($allowed_blocks)) {
    $props[] = 'allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '"';
}
$addProps = implode(' ', $props);
/* END - InnerBlocks Properties */

$classes = [];
$classes[] = !empty($block['className']) ? $block['className'] : null;
$classes[] = !empty($block['align']) ? $block['align'] : null;
$classes[] = !empty($block['align_text']) ? $block['align_text'] : null;
$classes[] = !empty($block['align_content']) ? $block['align_content'] : null;

$classes = array_filter($classes);
$addClasses = implode(' ', $classes);

if ($is_preview) {
    ?>
    <div class="block-anchor-id">
        <p>Block <?php echo $block['title']; ?>. ID: <strong>#<?php echo $block['id']; ?></strong></p>
    </div>
    <?php
}
?>
<section class="expandable-content-fp-block full <?= $addClasses ?>" id="<?= $block['id'] ?>">
    <div class="wrapper">
        <InnerBlocks <?php echo $addProps; ?> />
    </div>
</section>
