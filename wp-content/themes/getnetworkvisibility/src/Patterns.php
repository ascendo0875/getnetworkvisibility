<?php

namespace FINNPartners\Theme;

class Patterns
{
    const CATEGORY_NAME = 'fp_patterns';

    public function __construct()
    {

        /* Insert patterns */
        $this->RegisterBlockPatterns();
    }

    /**
     * @return void
     */
    public function RegisterBlockPatterns(): void
    {
        if (!class_exists('WP_Block_Patterns_Registry'))
            return;

        register_block_pattern_category(
            self::CATEGORY_NAME,
            [
                'label' => _x(Theme::CLIENT_NAME . ' Patterns', 'Custom patterns category', Theme::DOMAIN)
            ]
        );

        $patterns = [];
        $patterns['fp_pattern/anchors'] = [
            'title' => __('Anchors', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/anchors {"name":"acf/anchors","data":{"navigation_0_link":{"title":"Overview","url":"#overview","target":""},"_navigation_0_link":"field_633ec1f44c280","navigation_1_link":{"title":"Security Tech Partners","url":"#security-tech-partners","target":""},"_navigation_1_link":"field_633ec1f44c280","navigation_2_link":{"title":"Monitoring Tech Partners","url":"#monitoring-tech-partners","target":""},"_navigation_2_link":"field_633ec1f44c280","navigation_3_link":{"title":"Channel Partners","url":"#channel-partners","target":""},"_navigation_3_link":"field_633ec1f44c280","navigation_4_link":{"title":"Find a Partner","url":"#find-a-partner","target":""},"_navigation_4_link":"field_633ec1f44c280","navigation_5_link":{"title":"Become a Partner","url":"#become-a-partner","target":""},"_navigation_5_link":"field_633ec1f44c280","navigation":6,"_navigation":"field_633ec1964c27f"},"align":"full","mode":"preview"} /-->
HTML
        ];
        $patterns['fp_pattern/featured-resources-list'] = [
            'title' => __('Featured Resources Slider List', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:heading {"textAlign":"center","level":3,"className":"is-style-gradient"} -->
<h3 class="has-text-align-center is-style-gradient">Resources</h3>
<!-- /wp:heading -->
<!-- wp:heading {"textAlign":"center","className":"is-style-default"} -->
<h2 class="has-text-align-center is-style-default">at a glance</h2>
<!-- /wp:heading -->
<!-- wp:acf/featured-list {"name":"acf/featured-list","data":{"field_633fee4a156a2":"Resource","field_633ad9a2b0b67":"Latest","field_633ada0eb0b69":"6"},"align":"","mode":"preview","className":"is-style-slider"} /-->
HTML
        ];
        $patterns['fp_pattern/featured-partners-list'] = [
            'title' => __('Featured Partners Slider List', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:heading {"textAlign":"center","level":3,"className":"is-style-gradient"} -->
<h3 class="has-text-align-center is-style-gradient">Partners</h3>
<!-- /wp:heading -->
<!-- wp:heading {"textAlign":"center","className":"is-style-default"} -->
<h2 class="has-text-align-center is-style-default">at a glance</h2>
<!-- /wp:heading -->
<!-- wp:acf/featured-list {"name":"acf/featured-list","data":{"field_633fee4a156a2":"Partner","field_633ad9a2b0b67":"Latest","field_633ada0eb0b69":"6"},"align":"","mode":"preview","className":"is-style-slider"} /-->
HTML
        ];
        $patterns['fp_pattern/featured-customers-list'] = [
            'title' => __('Featured Customers Slider List', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:heading {"textAlign":"center","level":3,"className":"is-style-gradient"} -->
<h3 class="has-text-align-center is-style-gradient">Customers</h3>
<!-- /wp:heading -->
<!-- wp:heading {"textAlign":"center","className":"is-style-default"} -->
<h2 class="has-text-align-center is-style-default">at a glance</h2>
<!-- /wp:heading -->
<!-- wp:acf/featured-list {"name":"acf/featured-list","data":{"field_633fee4a156a2":"Customer","field_633ad9a2b0b67":"Latest","field_633ada0eb0b69":"6"},"align":"","mode":"preview","className":"is-style-slider"} /-->
HTML
        ];
        $patterns['fp_pattern/subscribe-form'] = [
            'title' => __('Subscribe Form', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"background_color":"#b87626","_background_color":"field_629f5ebbe8b0f"},"align":"full","mode":"preview"} -->
<!-- wp:acf/newsletter {"name":"acf/newsletter","data":{"heading":"Get Resources Like This Delivered To Your Inbox","_heading":"field_632d97117e12d","ninja_forms":"2","_ninja_forms":"field_632d971d7e12e"},"align":"","mode":"preview"} /-->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/follow-us'] = [
            'title' => __('Follow Us', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"background_color":"#b87626","_background_color":"field_629f5ebbe8b0f","background_image":"","_background_image":"field_633182c0edc37"},"align":"full","mode":"preview"} -->
<!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"level":3} -->
<h3 class="">Follow us</h3>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph -->
<p><strong>Fllow @Getnetworkvisibility on social media and stay up to date on all recent news, resources, updates and more</strong></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-large-icon-size","className":"is-style-logos-only","layout":{"type":"flex","justifyContent":"center"}} -->
<ul class="wp-block-social-links has-large-icon-size is-style-logos-only"><!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"youtube"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/callout-rich'] = [
            'title' => __('Callout Rich', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"background_color":"","_background_color":"field_629f5ebbe8b0f","background_image":2231,"_background_image":"field_633182c0edc37"},"align":"full","mode":"preview"} -->
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"className":"is-style-gradient"} -->
<h3 class="is-style-gradient">FEATURED SOLUTION</h3>
<!-- /wp:heading -->

<!-- wp:heading -->
<h2 class="">Request a live Demo</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"is-style-large-txt"} -->
<p class="is-style-large-txt">Nullam id dolor id nibh ultolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-solid"} -->
<div class="wp-block-button is-style-solid"><a class="wp-block-button__link" href="/request-a-demo/">Request a demo now</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-default"} -->
<div class="wp-block-button is-style-default"><a class="wp-block-button__link" href="/get-a-quote/">Get a quote</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/callout-rich-with-image'] = [
            'title' => __('Callout Rich With Image', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"background_color":"#000039","_background_color":"field_629f5ebbe8b0f","background_image":"","_background_image":"field_633182c0edc37"},"align":"full","mode":"preview"} -->
<!-- wp:acf/content-with-image {"name":"acf/content-with-image","data":{"image":2231,"_image":"field_632da390a3bf9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"level":3} -->
<h3 class="">Service/News featured headline</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"left"} -->
<p class="has-text-align-left">Nullam id dolor id nibh ultolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur. ricies vehicula ut id elit.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-solid"} -->
<div class="wp-block-button is-style-solid"><a class="wp-block-button__link" href="#">Learn more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:acf/content-with-image -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/copy-highlighted-columns'] = [
            'title' => __('Copy Highlighted Columns', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/values {"name":"acf/values","data":{"":"","_":"field_633adfe5a87d9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"level":3,"className":"is-style-gradient"} -->
<h3 class="is-style-gradient">CORE</h3>
<!-- /wp:heading -->

<!-- wp:heading -->
<h2 class="">Values</h2>
<!-- /wp:heading -->

<!-- wp:acf/values-list {"name":"acf/values-list","data":{"":"","_":"field_633adfe5a87d9"},"align":"","mode":"preview"} -->
<!-- wp:acf/values-item {"name":"acf/values-item","data":{"":"","_":"field_633adfe5a87d9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"level":3} -->
<h3 class="">What is Lorem Ipsum?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/values-item -->

<!-- wp:acf/values-item {"name":"acf/values-item","data":{"":"","_":"field_633adfe5a87d9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"level":3} -->
<h3 class="">Where does it come from?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical </p>
<!-- /wp:paragraph -->
<!-- /wp:acf/values-item -->

<!-- wp:acf/values-item {"name":"acf/values-item","data":{"":"","_":"field_633adfe5a87d9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"level":3} -->
<h3 class="">Why do we use it?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
<!-- /wp:paragraph -->
<!-- /wp:acf/values-item -->

<!-- wp:acf/values-item {"name":"acf/values-item","data":{"":"","_":"field_633adfe5a87d9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"level":3} -->
<h3 class="">Where can I get some?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/values-item -->
<!-- /wp:acf/values-list -->
<!-- /wp:acf/values -->
HTML
        ];
        $patterns['fp_pattern/intro'] = [
            'title' => __('Intro', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"","field_633182c0edc37":""},"align":"full","mode":"preview","className":"is-style-narrow"} -->
<!-- wp:heading {"level":3,"className":"is-style-gradient"} -->
<h3 class="is-style-gradient">How we can serve you</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class=""><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/intro-narrow'] = [
            'title' => __('Intro Narrow', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"","field_633182c0edc37":""},"align":"full","mode":"preview","className":"is-style-narrow"} -->
<!-- wp:heading {"level":3,"className":"is-style-narrow"} -->
<h3 class="is-style-narrow"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-narrow"} -->
<p class="is-style-narrow">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/intro-variation'] = [
            'title' => __('Intro Variation', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"background_color":"#000039","_background_color":"field_629f5ebbe8b0f","background_image":"","_background_image":"field_633182c0edc37"},"align":"full","mode":"preview","className":"is-style-narrow"} -->
<!-- wp:heading {"level":3} -->
<h3 class="">History/Mission/Vision headline</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Nullam id dolor id nibh ultolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur. ricies vehicula ut id elit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="#">Read More</a></p>
<!-- /wp:paragraph -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/copy-with-callout'] = [
            'title' => __('Copy With Callout', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/content-with-callout {"name":"acf/content-with-callout","data":{"aside":"\u003cstrong\u003eLorem ipsum t. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur. ricies vehicula ut id elit.\u003c/strong\u003e","_aside":"field_633ae43e6388a"},"align":"","mode":"preview"} -->
<!-- wp:heading {"className":"is-style-gradient"} -->
<h2 class="is-style-gradient">Additional about us information</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="">Culture headline commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Nullam id dolor id nibh ultolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur. ricies vehicula ut id elit.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/content-with-callout -->
HTML
        ];
        $patterns['fp_pattern/full-image'] = [
            'title' => __('Full Image', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"#f8f8f8","field_633182c0edc37":""},"align":"full","mode":"preview"} -->
<!-- wp:image {"align":"center","id":3747,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image aligncenter size-large"><img src="http://192.168.0.203:8426/wp-content/uploads/2022/10/graph-1024x437.png" alt="" class="wp-image-3747"/><figcaption>Figure 1. A network monitoring switch sits between network SPANs and taps and the monitoring tools.</figcaption></figure>
<!-- /wp:image -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/copy-highlighted'] = [
            'title' => __('Copy Highlighted', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"#000039","field_633182c0edc37":""},"align":"full","mode":"preview"} -->
<!-- wp:heading {"level":3} -->
<h3 class="">Summary</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>IT teams are under ever-increasing pressure to improve the performance and security of corporate networks. To meet these challenges, IT teams rely on monitoring tools.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Monitoring for security, compliance, as well as application and network performance requires access to an increasing amount of network data, optimally-performing monitoring tools and full visibility into the network. Unfortunately, the limited number of data access points prevents effective monitoring. The NPB is a necessary tool in addressing these challenges. Not only does a NPB solve the problems of tap and SPAN shortages, it also optimizes the traffic to all monitoring tools, improving overall monitoring tool performance and protecting the IT team’s monitoring tool investment.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/list-highlighted'] = [
            'title' => __('List Highlighted', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"#e0e4ef","field_633182c0edc37":""},"align":"","mode":"preview"} -->
<!-- wp:list {"ordered":true,"className":"is-style-highlighted-numbers"} -->
<ol class="is-style-highlighted-numbers"><li><strong>Create a logging and network visibility strategy – your EL0 process</strong><br>Before you blindly dive in and enable logging on every asset, you should start by verifying your existing assets and determine what your security posture should look like. For many agencies, log data is just the beginning because it’s low-hanging fruit in terms of implementation difficulty, limited disruption, and budget friendly. However, you will be wellserved by taking the time to look beyond logging towards a long-term visibility strategy that can reduce risk by removing blind spots in your network.</li><li><strong>Capture the right packet data to start the EL1 process</strong><br>Capture the right packet data to start the EL1 process Better logging practices start with capturing good data. The first thing to do is to deploy lots of taps across your network. This gives you access to the critical monitoring data that you need and creates visibility into the network. Taps are passive network elements that are quick and easy to deploy. There are versions for your physical on-premises environment as well as cloud-based taps to capture your virtual data. Keysight has the largest range of taps on the market.</li><li><strong>Decrypt relevant data as part of EL2 compliance</strong><br>More than 70% of malware may now hide in encrypted packet data. Passive and active TLS decryption allows you to look into those packets and see what’s hidden. After that, you can monitor and flag potentially malicious communication. This functionality helps with compliance to the EL2 stage that expressly calls for decryption capability.</li><li><strong>Process network metadata to enhance EL2 compliance</strong><br>Network metadata provides another source of crucial information at a fraction of the space of full packet and log data. Metadata (NetFlow, J-Flow, IPFIX, IxFlow, JSON) generated from collected packets creates better network efficiency and is easier for security managers, like SIEMs, to process. This metadata can provide actionable insights.</li><li><strong>Aggregate, filter, and transmit relevant data to security tools</strong><br>The last component is to use a packet broker to collect and access the relevant data your security analysis tools need. A purpose-built packet broker uses advanced filtering, deduplication, and packet trimming features to enhance the efficiency of log collector and analysis tools. The data can then be forwarded to your storage solutions. In addition, these data brokers can collect traffic from any segment of the network and perform header stripping so that the data can be tunneled (i.e. GRE) back to a central datacenter. Keysight offers on-premises, virtual (hypervisor and public or private cloud solutions), or a hybrid mixture of both solutions that delivers lossless data capture, aggregation, and filtration of data packets. Keysight also offers a time sync reliability solution, since data logs are useless if the network isn’t properly synchronized.</li></ol>
<!-- /wp:list -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/cta-blue-background'] = [
            'title' => __('CTA - blue background', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"background_color":"#000039","_background_color":"field_629f5ebbe8b0f","background_image":"","_background_image":"field_633182c0edc37"},"align":"full","mode":"preview"} -->
<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">Ready to become a partner?</h3>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"align":"center","className":"is-style-solid"} -->
<div class="wp-block-button aligncenter is-style-solid"><a class="wp-block-button__link" href="#">View partner portal</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/cta-white-background'] = [
            'title' => __('CTA - white background', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"","field_633182c0edc37":""},"align":"full","mode":"preview"} -->
<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">Ready to become a partner?</h3>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"align":"center","className":"is-style-solid"} -->
<div class="wp-block-button aligncenter is-style-solid"><a class="wp-block-button__link" href="#">View partner portal</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/content-with-image'] = [
            'title' => __('Content with image', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/content-with-image {"name":"acf/content-with-image","data":{"image":2282,"_image":"field_632da390a3bf9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"className":"is-style-gradient"} -->
<h2 class="is-style-gradient">Value proposition headline</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Etiam porta sem malesuada magna mollis euismod.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/content-with-image -->
HTML
        ];
        $patterns['fp_pattern/content-with-image-solid-color-background'] = [
            'title' => __('Content with image - solid color background', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"#000039","field_633182c0edc37":""},"align":"full","mode":"preview"} -->
<!-- wp:acf/content-with-image {"name":"acf/content-with-image","data":{"image":2282,"_image":"field_632da390a3bf9"},"align":"","mode":"preview"} -->
<!-- wp:heading {"className":"is-style-gradient"} -->
<h2 class="is-style-gradient">Value proposition headline</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Etiam porta sem malesuada magna mollis euismod.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/content-with-image -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/content-with-left-image'] = [
            'title' => __('Content with left image', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/content-with-image {"name":"acf/content-with-image","data":{"image":2282,"_image":"field_632da390a3bf9"},"align":"left","mode":"preview"} -->
<!-- wp:heading {"className":"is-style-gradient"} -->
<h2 class="is-style-gradient">Value proposition headline</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Etiam porta sem malesuada magna mollis euismod.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/content-with-image -->
HTML
        ];
        $patterns['fp_pattern/copy-columns'] = [
            'title' => __('Copy columns', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"className":"is-style-narrow"} -->
<h3 class="is-style-narrow">Proof point or Benefit</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-narrow"} -->
<p class="is-style-narrow">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit .</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"className":"is-style-narrow"} -->
<h3 class="is-style-narrow">Benefit</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-narrow"} -->
<p class="is-style-narrow">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit .</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
HTML
        ];
        $patterns['fp_pattern/copy-section'] = [
            'title' => __('Copy section', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"","field_633182c0edc37":""},"align":"","mode":"preview"} -->
<!-- wp:heading {"className":"is-style-gradient"} -->
<h2 class="is-style-gradient">Lorem Ipsum</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="">Lorem ipsum dolor sit amet, consectetur at eget adipiscing elit. Donec id elit non mi porta gravida</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">What is Lorem Ipsum?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Why do we use it?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Where does it come from?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Where can I get some?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-solid"} -->
<div class="wp-block-button is-style-solid"><a class="wp-block-button__link">see all Lorem IPSUM</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/copy-section-variation'] = [
            'title' => __('Copy section variation', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"#000039","field_633182c0edc37":""},"align":"full","mode":"preview"} -->
<!-- wp:heading {"className":"is-style-gradient"} -->
<h2 class="is-style-gradient">Lorem Ipsum</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="">Lorem ipsum dolor sit amet, consectetur at eget adipiscing elit. Donec id elit non mi porta gravida</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">What is Lorem Ipsum?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Why do we use it?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Where does it come from?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Where can I get some?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-solid"} -->
<div class="wp-block-button is-style-solid"><a class="wp-block-button__link">see all Lorem IPSUM</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/partners-featured'] = [
            'title' => __('Partners Featured', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/partners-featured {"name":"acf/partners-featured","data":{"field_63401e8db7db2":"Latest","field_63401ec75e4d2":"3","field_634027a29fb2e":"","field_63401f1bfb29a":"1","field_634028a5f8c0f":"See all security tech partners","field_63401f33fb29b":""},"align":"","mode":"preview","className":"is-style-side-img"} /-->
HTML
        ];
        $patterns['fp_pattern/partners-featured-simple'] = [
            'title' => __('Partners Featured Simple', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/partners-featured {"name":"acf/partners-featured","data":{"field_63401e8db7db2":"Latest","field_63401ec75e4d2":"3","field_634027a29fb2e":"","field_63401f1bfb29a":"1","field_634028a5f8c0f":"See all security tech partners","field_63401f33fb29b":""},"align":"","mode":"preview","className":"is-style-default"} /-->
HTML
        ];
        $patterns['fp_pattern/customers-featured'] = [
            'title' => __('Customers Featured', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/customers-featured {"name":"acf/customers-featured","data":{"field_63401e8db7db2":"Latest","field_63401ec75e4d2":"3","field_634027a29fb2e":"","field_63401f1bfb29a":"1","field_634028a5f8c0f":"See all security tech partners","field_63401f33fb29b":""},"align":"","mode":"preview","className":"is-style-side-img"} /-->
HTML
        ];
        $patterns['fp_pattern/customers-featured-simple'] = [
            'title' => __('Customers Featured Simple', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/customers-featured {"name":"acf/customers-featured","data":{"field_63401e8db7db2":"Latest","field_63401ec75e4d2":"3","field_634027a29fb2e":"","field_63401f1bfb29a":"1","field_634028a5f8c0f":"See all security tech partners","field_63401f33fb29b":""},"align":"","mode":"preview","className":"is-style-default"} /-->
HTML
        ];
        $patterns['fp_pattern/search-resources'] = [
            'title' => __('Search Resources', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/search-resources {"name":"acf/search-resources","data":{"connected_to_current_post":"0","_connected_to_current_post":"field_633c2886a0f50","filters":"1","_filters":"field_6331baab1f64d","filters_by_solution":"1","_filters_by_solution":"field_6331bc4e5566e","filters_by_industry":"1","_filters_by_industry":"field_633d66a7681b2","filters_by_type":"1","_filters_by_type":"field_6331bc8c55670","filters_by_topic":"1","_filters_by_topic":"field_6331bc6b5566f","filters_by_product":"1","_filters_by_product":"field_6331bc2c5566d","filters_by_industry":"1","_filters_by_industry":"field_6331bbe35566c","filters_by_keyword":"1","_filters_by_keyword":"field_6331bb915566b"},"align":"","mode":"preview"} /-->
HTML
        ];
        $patterns['fp_pattern/read-more'] = [
            'title' => __('Read More', ''),
            'description' => _x('Read More Pattern', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/read-more {"name":"acf/read-more","data":{"more_label":"Read More","_more_label":"field_634d5538c7bec","less_label":"Read Less","_less_label":"field_634d5580c7bed"},"align":"","mode":"preview"} -->
<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam in pellentesque mauris. Sed at tempor risus. Sed aliquam nisl eget libero tincidunt ullamcorper non non eros. Praesent euismod, risus id porttitor imperdiet, elit odio ultricies augue, ac rhoncus purus lectus eu tortor. Fusce eget ante enim. Sed lobortis, orci quis euismod ornare, mauris lacus pharetra urna, non laoreet elit magna sed quam. Duis malesuada tempor efficitur. Donec id eros arcu. Quisque quis ante interdum urna ultrices egestas ut eget magna. Nullam vitae ex quis lorem vehicula posuere id eu mauris. Curabitur molestie dolor et quam feugiat, nec molestie velit bibendum. Donec fringilla dui eget felis mattis fermentum. Nam facilisis, ex volutpat egestas fringilla, orci enim mollis libero, quis tincidunt diam augue at nulla. Integer posuere ornare dapibus.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Etiam euismod vestibulum turpis non rhoncus. Vivamus non sapien eget ante mollis convallis a eu massa. Quisque vitae dictum dui, quis laoreet lorem. Donec laoreet, mauris in venenatis fringilla, lectus velit ultricies risus, ut rhoncus nibh enim nec velit. Cras eu massa eu eros faucibus sagittis. Curabitur vitae nibh sed magna condimentum facilisis aliquam et ante. Praesent ac porttitor mauris, sed varius leo. Nam semper arcu eu mattis tempor.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Aliquam dui mi, varius quis pretium id, volutpat vitae risus. Curabitur blandit suscipit diam et accumsan. Suspendisse dictum hendrerit elit at eleifend. Nunc consequat risus ullamcorper nibh congue luctus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis ultricies augue erat, ac pellentesque risus interdum a. Proin porta ut mi vel pretium.</p>
<!-- /wp:paragraph -->
<!-- /wp:acf/read-more -->
HTML
        ];
        $patterns['fp_pattern/copy-featured-simple'] = [
            'title' => __('Copy Featured Simple', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"","field_633182c0edc37":""},"align":"","mode":"preview"} -->
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">What is Lorem Ipsum?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Why do we use it?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Where does it come from?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="">Where can I get some?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">See Lorem Ipsum</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-solid"} -->
<div class="wp-block-button is-style-solid"><a class="wp-block-button__link">see all Lorem IPSUM</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/find-partners'] = [
            'title' => __('Find Partners', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/find-partners {"name":"acf/find-partners","data":{"field_634684cbad274":"Partners","field_634684d6ad275":"Find"},"align":"","mode":"preview"} /-->
HTML
        ];
        $patterns['fp_pattern/more-solution-industry-related-solutions'] = [
            'title' => __('More Solution/Industry: Related Solutions', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/more-solution-industry {"name":"acf/more-solution-industry","data":{"field_6346b7cf8b4d7":"Related Solutions","field_6346b3e43e364":["solution"],"field_6346b4159ac1f":"Related","field_6346b53018786":"4"},"align":"","mode":"preview"} /-->
HTML
        ];
        $patterns['fp_pattern/more-solution-industry-related-solutions-with-background-color'] = [
            'title' => __('More Solution/Industry: Related Solutions With Background Color', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"#f8f8f8","field_633182c0edc37":""},"align":"full","mode":"preview"} -->
<!-- wp:acf/more-solution-industry {"name":"acf/more-solution-industry","data":{"heading":"Related Solutions","_heading":"field_6346b7cf8b4d7","data_post":["solution"],"_data_post":"field_6346b3e43e364","data_source":"Related","_data_source":"field_6346b4159ac1f","limit":"4","_limit":"field_6346b53018786"},"align":"","mode":"preview"} /-->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/more-solution-industry-related-industries'] = [
            'title' => __('More Solution/Industry: Related Industry', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/more-solution-industry {"name":"acf/more-solution-industry","data":{"field_6346b7cf8b4d7":"Related Industries","field_6346b3e43e364":["industry"],"field_6346b4159ac1f":"Related","field_6346b53018786":"4"},"align":"","mode":"preview"} /-->
HTML
        ];
        $patterns['fp_pattern/more-solution-industry-related-industries-with-background-color'] = [
            'title' => __('More Solution/Industry: Related Industries With Background Color', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"field_633edfe68d903":"0","field_629f5ebbe8b0f":"#000039","field_633182c0edc37":""},"align":"full","mode":"preview"} -->
<!-- wp:acf/more-solution-industry {"name":"acf/more-solution-industry","data":{"heading":"Related Industries","_heading":"field_6346b7cf8b4d7","data_post":["industry"],"_data_post":"field_6346b3e43e364","data_source":"Related","_data_source":"field_6346b4159ac1f","limit":"4","_limit":"field_6346b53018786"},"align":"","mode":"preview"} /-->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/carousel'] = [
            'title' => __('Carousel', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/carousel {"name":"acf/carousel","data":{"carousel_0_title":"Lorem ipsum dolor sit amet","_carousel_0_title":"field_634d3a29515e0","carousel_0_url":{"title":"Example solution","url":"/solution/example-solution/","target":""},"_carousel_0_url":"field_634d3a4e515e2","carousel_0_image":4512,"_carousel_0_image":"field_634d3a3d515e1","carousel_1_title":"Ut eu ornare ex. Phasellus quis porta lacus. ","_carousel_1_title":"field_634d3a29515e0","carousel_1_url":"","_carousel_1_url":"field_634d3a4e515e2","carousel_1_image":4454,"_carousel_1_image":"field_634d3a3d515e1","carousel_2_title":"Duis ut molestie tellus, vel iaculis erat","_carousel_2_title":"field_634d3a29515e0","carousel_2_url":{"title":"Riverbed","url":"/partner/riverbed/","target":""},"_carousel_2_url":"field_634d3a4e515e2","carousel_2_image":4171,"_carousel_2_image":"field_634d3a3d515e1","carousel_3_title":"Aenean mattis libero sit amet mauris egestas tempor.","_carousel_3_title":"field_634d3a29515e0","carousel_3_url":"","_carousel_3_url":"field_634d3a4e515e2","carousel_3_image":4150,"_carousel_3_image":"field_634d3a3d515e1","carousel_4_title":"Nam congue sagittis ex.","_carousel_4_title":"field_634d3a29515e0","carousel_4_url":{"title":"Google","url":"/partner/google/","target":""},"_carousel_4_url":"field_634d3a4e515e2","carousel_4_image":4197,"_carousel_4_image":"field_634d3a3d515e1","carousel_5_title":"Aliquam lobortis elementum nisl, ut tincidunt purus sagittis at","_carousel_5_title":"field_634d3a29515e0","carousel_5_url":"","_carousel_5_url":"field_634d3a4e515e2","carousel_5_image":4436,"_carousel_5_image":"field_634d3a3d515e1","carousel_6_title":"Morbi rhoncus sed lorem eget iaculis","_carousel_6_title":"field_634d3a29515e0","carousel_6_url":"","_carousel_6_url":"field_634d3a4e515e2","carousel_6_image":4454,"_carousel_6_image":"field_634d3a3d515e1","carousel":7,"_carousel":"field_634d3a0a515df"},"align":"","mode":"preview"} /-->
HTML
        ];
        $patterns['fp_pattern/highlighted-resources-list'] = [
            'title' => __('Highlighted Resources List', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/frame {"name":"acf/frame","data":{"clear_background_on_mobile":"0","_clear_background_on_mobile":"field_633edfe68d903","background_color":"#f8f8f8","_background_color":"field_629f5ebbe8b0f","background_image":"","_background_image":"field_633182c0edc37"},"align":"","mode":"preview"} -->
<!-- wp:heading {"level":4} -->
<h4 class="">Lorem Ipsum</h4>
<!-- /wp:heading -->

<!-- wp:acf/highlighted-resources-list {"name":"acf/highlighted-resources-list","data":{"field_632da95d84b34":"Latest","field_632dad97e4704":"5","field_6331b18aa0639":"","field_6331b26ea063e":["147"],"field_63500a6f30945":"0"},"align":"","mode":"preview"} /-->
<!-- /wp:acf/frame -->
HTML
        ];
        $patterns['fp_pattern/highlighted-resources-list-display-excerpt'] = [
            'title' => __('Highlighted Resources List With Excerpt', ''),
            'description' => _x('Frame', '', Theme::DOMAIN),
            'categories' => [self::CATEGORY_NAME],
            'content' => <<<HTML
<!-- wp:acf/highlighted-resources-list {"name":"acf/highlighted-resources-list","data":{"field_632da95d84b34":"Latest","field_632dad97e4704":"5","field_6331b18aa0639":"","field_6331b26ea063e":["147"],"field_63500a6f30945":"1"},"align":"","mode":"preview"} /-->
HTML
        ];

        // Sort Alphabetically by Title
        uasort($patterns, function ($x, $y) {
            return strcmp($x['title'], $y['title']);
        });
        foreach ($patterns as $key => $pattern) {
            register_block_pattern($key, $pattern);
        }
    }

    /**
     * @return Patterns
     */
    public static function init(): Patterns
    {
        return new Patterns;
    }
}
