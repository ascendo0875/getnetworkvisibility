<?php
/**
 * @var ?bool $isPreview
 * @var ?Event $event
 * @var array $args
 */

use FINNPartners\Theme\PostType\Instance\Event;
use FINNPartners\Theme\PostType\Instance\Fields\EventFields;
use FINNPartners\Theme\PostType\Register\Event as EventRegister;
use FINNPartners\Theme\Theme;
use WpAdvanceCustomFieldsExtend\Service\Media;

$displayExcerpt = $args['displayExcerpt'] ?? true;
$displayLearnMoreBtn = $args['displayLearnMoreBtn'] ?? true;

/** @var bool $isPreview */
$isPreview = $isPreview ?? false;
$event = $event ?? new Event(get_the_ID());
/** @var Event $event */

/** @var EventFields $ef */
$ef = $event->getFields();
?>

<div <?php post_class(false, $ef->getPostId()) ?>>
    <div class="article-body">

        <div class="blurb">
            <?php if (is_search()) : ?>
                <h5><?= EventRegister::SINGULAR_NAME ?></h5>
            <?php endif; ?>

            <p class="date"><?= $event->getDateAndLocation() ?></p>

            <h3><a href="<?= $ef->getPermalink() ?>"><?= $ef->getTitle() ?></a></h3>

            <?php if ($displayExcerpt && !empty($ef->getExcerpt())) : ?>
                <p><?= $ef->getExcerpt() ?></p>
            <?php endif; ?>

            <p class="more-link">
                <?php if ($displayLearnMoreBtn) : ?>
                    <a href="<?= $ef->getPermalink() ?>"><?= __('LEARN MORE', Theme::DOMAIN) ?></a>
                <?php endif; ?>
                <?php if ($ef->getRegisterPage()) : ?>
                    <a class="btn" href="<?= $ef->getRegisterPage()['url'] ?>" target="<?= $ef->getRegisterPage()['target'] ?>"><?= $ef->getRegisterPage()['title'] ?></a>
                <?php endif; ?>
           </p>

            
        </div>

        <?php if ($ef->getThumbnail() instanceof Media) : ?>
            <a href="<?= $ef->getPermalink() ?>" class="img lazyload" <?= $isPreview ? "style='background-image: url({$ef->getThumbnail()->getUrl()})'" : "" ?>
                 data-bg="<?= $ef->getThumbnail()->getUrl() ?>">
            </a>
        <?php endif; ?>

    </div>
</div>
