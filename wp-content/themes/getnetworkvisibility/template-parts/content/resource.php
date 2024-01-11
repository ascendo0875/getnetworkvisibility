<?php
/**
 * @var array $args
 */
$resource = [
    'id' => false,
    'permalink' => false,
    'title' => false,
    'categories' => false,
    'excerpt' => false,
    'image' => false,
    'cssClass' => '',
    'isPreview' => false,
];

if (isset($args['resource']) && !empty($args['resource'])) {
    $resource['id'] = !empty($args['resource']['id']) ? $args['resource']['id'] : false;
    $resource['permalink'] = !empty($args['resource']['permalink']) ? $args['resource']['permalink'] : false;
    $resource['title'] = !empty($args['resource']['title']) ? $args['resource']['title'] : false;
    $resource['categories'] = !empty($args['resource']['categories']) ? $args['resource']['categories'] : false;
    $resource['excerpt'] = !empty($args['resource']['excerpt']) ? $args['resource']['excerpt'] : false;
    $resource['image'] = !empty($args['resource']['image']) ? $args['resource']['image'] : false;
    $resource['cssClass'] = !empty($args['resource']['cssClass']) ? ((is_array($args['resource']['cssClass'])) ? implode(' ', $args['resource']['cssClass']) : $args['resource']['cssClass']) : "";
    $resource['isPreview'] = isset($args['resource']['isPreview']) ? $args['resource']['isPreview'] : false;
}
?>

<?php if (!empty($resource['id'])) : ?>
    <a href="<?= $resource['permalink'] ?>" <?php post_class($resource['cssClass'], $resource['id']) ?>>
        <?php if (!empty($resource['image'])) : ?>
            <div class="img lazyload"
                <?= ($resource['isPreview'] ? "style='background-image: url({$resource['image']})'" : "") ?>
                 data-bg="<?= $resource['image'] ?>"></div>
        <?php endif; ?>

        <div class="blurb">
            <?php if (!empty($resource['categories'])) : ?>
                <h5><?= $resource['categories'] ?></h5>
            <?php endif; ?>

            <?php if (!empty($resource['title'])) : ?>
                <h4><?= $resource['title'] ?></h4>
            <?php endif; ?>

            <?php if (!empty($resource['excerpt'])) : ?>
            <p><?=$resource['excerpt']?></p>
            <?php endif; ?>
        </div>
    </a>
<?php endif; ?>