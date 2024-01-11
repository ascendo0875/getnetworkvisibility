<?php
/**
 * BlockTemplate
 * @var array $block
 * @var string $content
 * @var bool $is_preview
 * @var int|string $post_id
 */

use FINNPartners\Theme\Block\Instance\Hero;
use FINNPartners\Theme\Block\Register\Hero as HeroRegister;
use WpAdvanceCustomFieldsExtend\Service\Media;

/** @var Hero $blockObj */
$blockObj = !empty($blockObj) ? $blockObj : new Hero($post_id, $block, $is_preview);
$f = $blockObj->getFields();

$blockObj->displayAdminAnchorHTML();
?>

<div class="main-hero full <?= $blockObj->getCSSClassesAsString() ?>"
    <?= !empty($blockObj->getStyle()) ? "style='{$blockObj->getStyle()}'" : '' ?>
     id="<?= $blockObj->getId() ?>">

    <div class="wrapper">

        <div class="content">

            <div class="blurb">

                <?php if ($blockObj->isSampleHero() || empty($f->getFormType())) : ?>
                    <?php if ($f->getSubheading()) : ?>
                        <h3 class="is-style-gradient"><?= $f->getSubheading() ?></h3>
                    <?php endif; ?>

                    <h1 class="is-style-heading2"><?= $f->getHeading() ?></h1>
                <?php endif; ?>

                <?php if (!$blockObj->isSampleHero() && !empty($f->getFormType())) : ?>
                    <div class="left">
                        <h3 class="is-style-gradient"><?= $f->getSubheading() ?></h3>
                        <h1 class="is-style-heading2"><?= $f->getHeading() ?></h1>

                        <?php if (!empty($f->getCopy())) : ?>
                            <h3><?= $f->getCopy() ?></h3>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($f->getFormType())) : ?>
                    <div class="right">
                        <div class="contact-box">
                            <?php
                            if ($f->isNinjaForm()) {

                                echo do_shortcode("[ninja_form id={$f->getNinjaForms()}]");

                            } elseif ($f->isHubSpotForm()) { ?>

                                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
                                <script>
                                    hbspt.forms.create({
                                        region: "na1",
                                        portalId: "<?= $f->getHubspotPortalId() ?>",
                                        formId: "<?= $f->getHubspotFormId() ?>"
                                    });
                                </script>

                            <?php } ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

            <?php if (!$blockObj->isSampleHero() && $blockObj->isBox()) : ?>
                <div class="box">

                    <?= HeroRegister::getInnerBlocksHTMLTag(HeroRegister::class) ?>

                </div>
            <?php endif; ?>

        </div>

        <?php if (!$blockObj->isSampleHero() && ($f->getBackgroundImage() instanceof Media)) : ?>
            <div class="img"
                <?= "style='background-image: url({$f->getBackgroundImage()->getUrl($blockObj->getCrop())})'" ?>
                 ></div>
        <?php endif; ?>

    </div>

</div>
