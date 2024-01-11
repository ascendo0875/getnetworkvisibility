<?php

// Sidebar
if (is_active_sidebar('main-sidebar')) {
    ?>
    <div class="left-content">

        <ul class="callouts-container">

            <?php dynamic_sidebar('main-sidebar'); ?>

        </ul>
    </div>
    <?php
}