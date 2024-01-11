<?php
/**
 * Accordion Content - BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Theme;
use FINNPartners\Theme\Block;

/** @var Block\Instance\AccordionContent $AccordionContent */
$AccordionContent = new Block\Instance\AccordionContent($post_id, $block);

/* START - InnerBlocks Properties */
$props = [];
$template = [];

if (!empty($template)) {
    $props[] = 'template="' . esc_attr(wp_json_encode($template)) . '"';
}

$allowed_blocks = [];
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

$classes[] = $is_preview || $AccordionContent->getFields()->isExpended() ? "expended" : "";

$classes = array_filter($classes);
$addClasses = implode(' ', $classes);

$addStyle = $is_preview || $AccordionContent->getFields()->isExpended() ? "style='display: block;'" : "";
?>

    <div class="<?php echo $addClasses ?>" id="<?php echo $block['id'] ?>">
        <a href="#" class="title">
            <?php echo $AccordionContent->getFields()->getHeading() ?>
        </a>
        <div class="expanded-content" <?php echo $addStyle; ?>>
            <InnerBlocks <?php echo $addProps; ?> />
        </div>
    </div>

<?php
Theme::x($AccordionContent);
