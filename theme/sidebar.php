<?php

/**
 * The template for the sidebar containing the main widget area
 *
 * @package KIE
 * @subpackage KIE_Theme
 * @since KIE Theme 1.0.0
 */
?>
<div id="blog_sidebar" class="column column-25 blog-sidebar">
    <?php if (has_nav_menu('primary')) : ?>
        <a href="#" class="responsive-menu-button close-button">&#10005;</a>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'responsive',
            'menu_class' => 'kie-responsive-menu',
            'depth' => 1
        ));
        ?>
    <?php endif; ?>
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <div id="sidebar-module-element" class="sidebar-module sidebar-module--collapsed">
            <?php dynamic_sidebar('sidebar-1'); ?>
        </div><!-- .sidebar .widget-area -->
    <?php endif; ?>
    <div><a class="see-more-toggler" id="sidebar-see-more-anchor" href="#">See more »</a></div>
</div><!-- /.blog-sidebar -->