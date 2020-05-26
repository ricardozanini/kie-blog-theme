<?php
/**
 * The template part for displaying content
 *
 * @package KIE
 * @subpackage KIE_Theme
 * @since KIE Theme 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
	<a href="<?php echo kie_get_author_href() ?>"><?php echo get_avatar(  get_the_author_meta('email'), '70' ); ?></a>
	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	
	<?php kie_entry_meta(); ?>

	<?php kie_excerpt('blog-post-content'); ?>

</article><!-- #post-## -->
