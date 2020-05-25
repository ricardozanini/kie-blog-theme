<?php

/**
 * Custom Kogito template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Kogito 1.0.0
 */

if (!function_exists('kogito_entry_meta')) :
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * Create your own kogito_entry_meta() function to override in a child theme.
	 *
	 * @since Kogito 1.0.0
	 */
	function kogito_entry_meta()
	{
		printf('<div class="blog-post-meta">by %1$s - %2$s %3$s</div>', get_the_author_link(), get_the_date(), kogito_entry_taxonomies());
	}
endif;


if (!function_exists('kogito_entry_taxonomies')) :
	/**
	 * Prints HTML with category and tags for current post.
	 *
	 * Create your own kogito_entry_taxonomies() function to override in a child theme.
	 *
	 * @since Kogito 1.0.0
	 */
	function kogito_entry_taxonomies()
	{
		$categories = get_the_category();
		$separator = ' ';
		$output = '';
		if (!empty($categories)) {
			foreach ($categories as $category) {
				$output .= '<a class="blog-post-meta-box blog-post-meta-box--category" href="' .
					esc_url(get_category_link($category->term_id)) .
					'" alt="' .
					esc_attr(sprintf(__('View all posts in %s', 'kogito'), $category->name)) .
					'">' . esc_html($category->name) .
					'</a>' . $separator;
			}
		}

		$terms = get_the_tags(get_the_ID());
		if (!empty($terms)) {
			foreach ($terms as $term) {
				$output .= '<a class="blog-post-meta-box blog-post-meta-box--term" href="' .
					esc_url(get_term_link($term->term_id)) .
					'" alt="' .
					esc_attr(sprintf(__('View all posts in %s', 'kogito'), $term->name)) .
					'">' .
					esc_html($term->name) .
					'</a>' .
					$separator;
			}
		}
		return $output;
	}
endif;

if (!function_exists('kogito_post_thumbnail')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * Create your own kogito_post_thumbnail() function to override in a child theme.
	 *
	 * @since Kogito 1.0.0
	 */
	function kogito_post_thumbnail()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()) :
?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php the_post_thumbnail('post-thumbnail', array('alt' => the_title_attribute('echo=0'))); ?>
			</a>

		<?php endif; // End is_singular()
	}
endif;

if (!function_exists('kogito_excerpt')) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own kogito_excerpt() function to override in a child theme.
	 *
	 * @since Kogito 1.0.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function kogito_excerpt($class = 'entry-summary')
	{
		$class = esc_attr($class);

		if (!is_single()) : ?>
			<div class="<?php echo $class; ?>" id="excerpt-<?php the_ID(); ?>"><?php the_excerpt(); ?></div>
			<div class="<?php echo $class; ?>" id="content-<?php the_ID(); ?>" hidden="true"><?php the_content(); ?></div>
		<?php else : ?>
			<div class="<?php echo $class; ?>" id="content-<?php the_ID(); ?>"><?php the_content(); ?></div>
<?php endif;
		echo '<!-- .' . $class . ' -->';
	}
endif;

if (!function_exists('kogito_excerpt_more') && !is_admin()) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Continue reading' link.
	 *
	 * Create your own kogito_excerpt_more() function to override in a child theme.
	 *
	 * @since Kogito 1.0.0
	 *
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	function kogito_excerpt_more()
	{
		$link = sprintf(
			'<a href="%1$s" class="more-link">%2$s</a>',
			esc_url(get_permalink(get_the_ID())),
			/* translators: %s: Name of current post */
			sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'kogito'), get_the_title(get_the_ID()))
		);
		return ' &hellip; ' . $link;
	}
	add_filter('excerpt_more', 'kogito_excerpt_more');
endif;

if (!function_exists('kogito_categorized_blog')) :
	/**
	 * Determines whether blog/site has more than one category.
	 *
	 * Create your own kogito_categorized_blog() function to override in a child theme.
	 *
	 * @since Kogito 1.0.0
	 *
	 * @return bool True if there is more than one category, false otherwise.
	 */
	function kogito_categorized_blog()
	{
		if (false === ($all_the_cool_cats = get_transient('kogito_categories'))) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(array(
				'fields'     => 'ids',
				// We only need to know if there is more than one category.
				'number'     => 2,
			));

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count($all_the_cool_cats);

			set_transient('kogito_categories', $all_the_cool_cats);
		}

		if ($all_the_cool_cats > 1) {
			// This blog has more than 1 category so kogito_categorized_blog should return true.
			return true;
		}
		// This blog has only 1 category so kogito_categorized_blog should return false.
		return false;
	}
endif;

/**
 * Flushes out the transients used in kogito_categorized_blog().
 *
 * @since Kogito 1.0.0
 */
function kogito_category_transient_flusher()
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient('kogito_categories');
}
add_action('edit_category', 'kogito_category_transient_flusher');
add_action('save_post',     'kogito_category_transient_flusher');

if (!function_exists('kogito_the_custom_logo')) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since Kogito 1.2
	 */
	function kogito_the_custom_logo()
	{
		if (function_exists('the_custom_logo')) {
			the_custom_logo();
		}
	}
endif;
