<?php
/**
 * @var array $block
 * @var int|string $post_id
 * @var MediaVisual $blockObj
 */

use FINNPartners\Theme\Block\Instance\MediaVisual;

/** @var MediaVisual $blockObj */
$blockObj = ($blockObj instanceof MediaVisual) ? $blockObj : new MediaVisual($post_id, $block, isset($is_preview) ? $is_preview : false);
$f = $blockObj->getFields();
?>

<div class="block-media-visual">

    <?php if ($blockObj->isPreview()) { ?>

        <div class="play">

            <?php if ($f->getImage()) { ?>
                <img src="<?php echo $f->getImage()->getUrl(); ?>"
                     width="<?= $f->getImage()->getWidth() ?>"
                     height="<?= $f->getImage()->getHeight() ?>"
                     alt="<?php echo $f->getImage()->getAlt(); ?>"/>
            <?php } ?>

            <?php if ($f->getCaption()) : ?>
                <h3><?= $f->getCaption() ?></h3>
            <?php endif; ?>

        </div>

    <?php } else { ?>

        <a href="<?= ($blockObj->getVideo() && $blockObj->getVideo()->getVideoID()) ? $blockObj->getVideo()->getEmbedURL() : '' ?>"
           class="video-play play">

            <?php if ($f->getImage()) : ?><img src="<?= $f->getImage()->getUrl() ?>" class="img"
                     width="<?= $f->getImage()->getWidth() ?>"
                     height="<?= $f->getImage()->getHeight() ?>"
                     alt="<?= $f->getImage()->getAlt() ?>"
                /><?php endif; ?>

            <?php if ($f->getCaption()) : ?>
                <h3><?= $f->getCaption() ?></h3>
            <?php endif; ?>

            <?php if ($blockObj->getVideo() && $blockObj->getVideo()->getVideoID()) : ?>
                <div class="video-container" data-videourl="<?= $blockObj->getVideo()->getEmbedURL() ?>">

                    <div class="embed-container">

                        <iframe width="750" height="422" src="" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>

                    </div>

                </div>
            <?php endif; ?>

        </a>

    <?php } ?>

</div>
