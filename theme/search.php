<?php

/**
 * The search result template file
 *
 * Use this theme file to display the results of a search
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package KIE
 * @subpackage KIE_Theme
 * @since KIE 1.0.0
 */

get_header(); ?>

<div id="content" class="container wrapper">
	<div class="row">
		<main id="main" class="column column-75 blog-main" role="main">
			<div id="blog-posts">
				<?php if (have_posts()) : ?>
				<?php
					// Start the loop.
					while (have_posts()) : the_post();

						/*
						* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part('template-parts/content', get_post_format());

					// End the loop.
					endwhile;
					
					// Previous/next page navigation.
					the_posts_pagination(
						array(
							'prev_text'          => __('← Previous page', 'kie'),
							'next_text'          => __('Next page →', 'kie'),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'kie') . ' </span>',
						)
					);

				// If no content, include the "No posts found" template.
				else :
					get_template_part('template-parts/content', 'none');

				endif;
				?>
			</div>
		</main><!-- .site-main -->
		<?php get_sidebar(); ?>
	</div>
</div><!-- .content-area -->
<?php get_footer(); ?>