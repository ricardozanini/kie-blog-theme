<?php

/**
 * Custom KIE template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package KIE
 * @subpackage KIE_Theme
 * @since KIE Theme 1.0.0
 */

if (!function_exists('kie_entry_meta')) :
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * Create your own kie_entry_meta() function to override in a child theme.
	 *
	 * @since KIE 1.0.0
	 */
	function kie_entry_meta()
	{
		$author_link =  get_the_author_link();
		if (class_exists('Search_Filter_Shared')) {
			$author_link = '<a href="' . kie_get_author_href() .
				'" rel="author" title="Posts by ' . get_the_author_meta('display_name') . '">' .
				get_the_author_meta('display_name') . '</a>';
		}
		printf('<div class="blog-post-meta">by %1$s - %2$s %3$s</div>', $author_link, get_the_date(), kie_entry_taxonomies());
	}
endif;

if (!function_exists('kie_get_author_href')) :
	define("PAGE_FILTER", "filter");

	function kie_get_author_href()
	{
		$author_link =  get_the_author_meta('url');
		if (class_exists('Search_Filter_Shared')) {
			$author_link = esc_url(site_url('/' . PAGE_FILTER .  '?authors=') . get_the_author_meta('user_nicename'));
		}
		return $author_link;
	}
endif;

if (!function_exists('kie_entry_taxonomies')) :
	/**
	 * Prints HTML with category and tags for current post.
	 *
	 * Create your own kie_entry_taxonomies() function to override in a child theme.
	 *
	 * @since KIE 1.0.0
	 */
	function kie_entry_taxonomies()
	{
		$categories = get_the_category();
		$separator = ' ';
		$output = '';
		if (!empty($categories)) {
			foreach ($categories as $category) {
				$output .= '<a class="blog-post-meta-box blog-post-meta-box--category" href="' .
					esc_url(get_category_link($category->term_id)) .
					'" alt="' .
					esc_attr(sprintf(__('View all posts in %s', 'kie'), $category->name)) .
					'">' . esc_html($category->name) .
					'</a>' . $separator;
			}
		}

		$terms = get_the_terms(get_the_ID(), 'content_type');
		if (is_wp_error($terms)) {
			$terms = get_the_tags(get_the_ID());
		}
		if (!empty($terms)) {
			foreach ($terms as $term) {
				$output .= '<a class="blog-post-meta-box blog-post-meta-box--term" href="' .
					esc_url(get_term_link($term->term_id)) .
					'" alt="' .
					esc_attr(sprintf(__('View all posts in %s', 'kie'), $term->name)) .
					'">' .
					esc_html($term->name) .
					'</a>' .
					$separator;
			}
		}
		return $output;
	}
endif;

if (!function_exists('kie_post_thumbnail')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * Create your own kie_post_thumbnail() function to override in a child theme.
	 *
	 * @since KIE 1.0.0
	 */
	function kie_post_thumbnail()
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

if (!function_exists('kie_excerpt')) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own kie_excerpt() function to override in a child theme.
	 *
	 * @since KIE 1.0.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function kie_excerpt($class = 'entry-summary')
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

if (!function_exists('kie_excerpt_more') && !is_admin()) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Continue reading' link.
	 *
	 * Create your own kie_excerpt_more() function to override in a child theme.
	 *
	 * @since KIE 1.0.0
	 *
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	function kie_excerpt_more()
	{
		$link = sprintf(
			'<a href="%1$s" class="more-link">%2$s</a>',
			esc_url(get_permalink(get_the_ID())),
			/* translators: %s: Name of current post */
			sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'kie'), get_the_title(get_the_ID()))
		);
		return ' &hellip; ' . $link;
	}
	add_filter('excerpt_more', 'kie_excerpt_more');
endif;

if (!function_exists('kie_categorized_blog')) :
	/**
	 * Determines whether blog/site has more than one category.
	 *
	 * Create your own kie_categorized_blog() function to override in a child theme.
	 *
	 * @since KIE 1.0.0
	 *
	 * @return bool True if there is more than one category, false otherwise.
	 */
	function kie_categorized_blog()
	{
		if (false === ($all_the_cool_cats = get_transient('kie_categories'))) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(array(
				'fields'     => 'ids',
				// We only need to know if there is more than one category.
				'number'     => 2,
			));

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count($all_the_cool_cats);

			set_transient('kie_categories', $all_the_cool_cats);
		}

		if ($all_the_cool_cats > 1) {
			// This blog has more than 1 category so kie_categorized_blog should return true.
			return true;
		}
		// This blog has only 1 category so kie_categorized_blog should return false.
		return false;
	}
endif;

/**
 * Flushes out the transients used in kie_categorized_blog().
 *
 * @since KIE 1.0.0
 */
function kie_category_transient_flusher()
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient('kie_categories');
}
add_action('edit_category', 'kie_category_transient_flusher');
add_action('save_post',     'kie_category_transient_flusher');

if (!function_exists('kie_the_custom_logo')) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since KIE 1.2
	 */
	function kie_the_custom_logo()
	{
		if (function_exists('the_custom_logo')) {
			the_custom_logo();
		}
	}
endif;
