<?php

get_header();

if (have_posts()) {

    do {

        the_post();

        the_content();

        $bio = new \FINNPartners\Theme\PostType\Instance\Bio(get_the_ID());
        ?>
        <p>First Name: <?php echo $bio->getFields()->getFirstName(); ?></p>
        <p>Last Name: <?php echo $bio->getFields()->getLastName(); ?></p>
        <p>Email: <?php echo $bio->getFields()->getEmail(); ?></p>
        <?php


    } while (have_posts());

}

get_footer();
