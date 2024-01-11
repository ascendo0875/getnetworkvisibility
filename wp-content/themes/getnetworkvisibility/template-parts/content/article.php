<?php
/**
 * @var array $args
 */
$article = [
    'id' => false,
    'permalink' => false,
    'title' => false,
    'categories' => false,
    'excerpt' => false,
    'image' => false,
    'cssClass' => '',
    'isPreview' => false,
];

if (isset($args['article']) && !empty($args['article'])) {
    $article['id'] = !empty($args['article']['id']) ? $args['article']['id'] : false;
    $article['permalink'] = !empty($args['article']['permalink']) ? $args['article']['permalink'] : false;
    $article['title'] = !empty($args['article']['title']) ? $args['article']['title'] : false;
    $article['categories'] = !empty($args['article']['categories']) ? $args['article']['categories'] : false;
    $article['excerpt'] = !empty($args['article']['excerpt']) ? $args['article']['excerpt'] : false;
    $article['image'] = !empty($args['article']['image']) ? $args['article']['image'] : false;
    $article['cssClass'] = !empty($args['article']['cssClass']) ? ((is_array($args['article']['cssClass'])) ? implode(' ', $args['article']['cssClass']) : $args['article']['cssClass']) : "";
    $article['isPreview'] = isset($args['article']['isPreview']) ? $args['article']['isPreview'] : false;
}
?>

<?php if (!empty($article['id'])) : ?>
    <a href="<?= $article['permalink'] ?>" <?php post_class($article['cssClass'], $article['id']) ?>>
        <?php if (!empty($article['image'])) : ?>
            <div class="img lazyload"
                <?= ($article['isPreview'] ? "style='background-image: url({$article['image']})'" : "") ?>
                 data-bg="<?= $article['image'] ?>"></div>
        <?php endif; ?>

        <div class="blurb">
            <?php if (!empty($article['categories'])) : ?>
                <h5><?= $article['categories'] ?></h5>
            <?php endif; ?>

            <?php if (!empty($article['title'])) : ?>
                <h4><?= $article['title'] ?></h4>
            <?php endif; ?>

            <?php if (!empty($article['excerpt'])) {
                echo wpautop($article['excerpt']);
            } ?>
        </div>
    </a>
<?php endif; ?>