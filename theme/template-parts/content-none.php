<?php

/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package KIE
 * @subpackage KIE_Theme
 * @since KIE Theme 1.0.0
 */
?>

<section class="no-results not-found">
    <h2 class="entry-title"><?php _e('Nothing Found', 'kie'); ?></h2>

    <div class="page-content">
        <?php if (is_search() || is_archive()) : ?>

            <p><?php _e('Sorry, but nothing matched your filter or search terms. Please try again with some different filter or keywords.', 'kie'); ?></p>

        <?php elseif (is_home() && current_user_can('publish_posts')) : ?>

            <p><?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kie'), esc_url(admin_url('post-new.php'))); ?></p>

        <?php else : ?>

            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kie'); ?></p>

        <?php endif; ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->