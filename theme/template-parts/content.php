<?php
/**
 * The template part for displaying content
 *
 * @package Kogito
 * @subpackage Kogito_Theme
 * @since Kogito Theme 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
	<?php echo get_avatar(  get_the_author_meta('email'), '70' ); ?>
	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	
	<?php kogito_entry_meta(); ?>

	<?php kogito_excerpt('blog-post-content'); ?>

</article><!-- #post-## -->
