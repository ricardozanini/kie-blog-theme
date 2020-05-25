<?php

/**
 * Kogito Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Kogito
 * @subpackage Kogito_Theme
 * @since Kogito Theme 1.0.0.0
 */

/**
 * Kogito Theme only works in WordPress 4.4 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {
	require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('kogito_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own kogito_setup() function to override in a child theme.
	 *
	 * @since  Kogito Theme 1.0.0
	 */
	function kogito_setup()
	{
		/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/kogito
	 * If you're building a theme based on  Kogito Theme, use a find and replace
	 * to change 'kogito' to the name of your theme in all the template files
	 */
		load_theme_textdomain('kogito');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
		add_theme_support('title-tag');

		/*
	 * Enable support for custom logo.
	 *
	 *  @since  Kogito Theme 1.0.0
	 */
		add_theme_support('custom-logo', array(
			'height'      => 240,
			'width'       => 240,
			'flex-height' => true,
		));

		/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(1200, 9999);

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'kogito'),
			'responsive' => __('Responsive Menu', 'kogito'),
		));

		/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		));

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support('customize-selective-refresh-widgets');
	}
endif; // kogito_setup
add_action('after_setup_theme', 'kogito_setup');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since  Kogito Theme 1.0.0
 */
function kogito_content_width()
{
	$GLOBALS['content_width'] = apply_filters('kogito_content_width', 840);
}
add_action('after_setup_theme', 'kogito_content_width', 0);

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since  Kogito Theme 1.0.0
 */
function kogito_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Sidebar', 'kogito'),
		'id'            => 'sidebar-1',
		'description'   => __('Add widgets here to appear in your sidebar.', 'kogito'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => __('Content Bottom 1', 'kogito'),
		'id'            => 'sidebar-2',
		'description'   => __('Appears at the bottom of the content on posts and pages.', 'kogito'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => __('Content Bottom 2', 'kogito'),
		'id'            => 'sidebar-3',
		'description'   => __('Appears at the bottom of the content on posts and pages.', 'kogito'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'kogito_widgets_init');

if (!function_exists('kogito_fonts_url')) :
	/**
	 * Register Google fonts for  Kogito Theme.
	 *
	 * Create your own kogito_fonts_url() function to override in a child theme.
	 *
	 * @since  Kogito Theme 1.0.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function kogito_fonts_url()
	{
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		if ('off' !== _x('on', 'PT Serif font: on or off', 'kogito')) {
			$fonts[] = 'PTSerif:400,700,900,400italic,700italic,900italic';
		}

		if ('off' !== _x('on', 'Overpass font: on or off', 'kogito')) {
			$fonts[] = 'Overpass:400,700,900,400italic,700italic,900italic';
		}

		if ($fonts) {
			$fonts_url = add_query_arg(array(
				'family' => urlencode(implode('|', $fonts)),
				'subset' => urlencode($subsets),
			), 'https://fonts.googleapis.com/css');
		}

		return $fonts_url;
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since  Kogito Theme 1.0.0
 */
function kogito_javascript_detection()
{
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'kogito_javascript_detection', 0);

/**
 * Enqueues scripts and styles.
 *
 * @since  Kogito Theme 1.0.0
 */
function kogito_scripts()
{
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style('kogito-fonts', kogito_fonts_url(), array(), null);

	// Add Genericons, used in the main stylesheet.
	//wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style('kogito-style', get_stylesheet_uri());

	wp_enqueue_style('kogito-main', get_template_directory_uri() . '/assets/main.css', array('kogito-style'), '20200525');

	wp_enqueue_style('kogito-normalize', get_template_directory_uri() . '/assets/normalize.css', array('kogito-style'), '20200525');


	// Load the Internet Explorer specific stylesheet.
	//wp_enqueue_style( 'kogito-ie', get_template_directory_uri() . '/css/ie.css', array( 'kogito-style' ), '20160816' );
	//wp_style_add_data( 'kogito-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	//wp_enqueue_style( 'kogito-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'kogito-style' ), '20160816' );
	//wp_style_add_data( 'kogito-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	//wp_enqueue_style( 'kogito-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'kogito-style' ), '20160816' );
	//wp_style_add_data( 'kogito-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	//wp_enqueue_script( 'kogito-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	//wp_script_add_data( 'kogito-html5', 'conditional', 'lt IE 9' );

	//wp_enqueue_script( 'kogito-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160816', true );

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	//if ( is_singular() && wp_attachment_is_image() ) {
	//		wp_enqueue_script( 'kogito-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160816' );
	//	}

	wp_enqueue_script('kogito-script', get_template_directory_uri() . '/js/kie.js', array('jquery'), '20200525', false);

	wp_localize_script('kogito-script', 'screenReaderText', array(
		'expand'   => __('expand child menu', 'kogito'),
		'collapse' => __('collapse child menu', 'kogito'),
	));
}
add_action('wp_enqueue_scripts', 'kogito_scripts');

function kogito_init_responsive_menu()
{
	echo '<script type="text/javascript">
	  (function() {
		KIE.initializeSeeMoreAuthorsButton();
		KIE.initializeResponsiveSidebar();
	  }());
	</script>';
}
add_action('wp_footer', 'kogito_init_responsive_menu');

/**
 * Adds custom classes to the array of body classes.
 *
 * @since  Kogito Theme 1.0.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function kogito_body_classes($classes)
{
	// Adds a class of custom-background-image to sites with a custom background image.
	if (get_background_image()) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if (is_multi_author()) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if (!is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter('body_class', 'kogito_body_classes');

/**
 * Converts a HEX value to RGB.
 *
 * @since  Kogito Theme 1.0.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function kogito_hex2rgb($color)
{
	$color = trim($color, '#');

	if (strlen($color) === 3) {
		$r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
		$g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
		$b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
	} else if (strlen($color) === 6) {
		$r = hexdec(substr($color, 0, 2));
		$g = hexdec(substr($color, 2, 2));
		$b = hexdec(substr($color, 4, 2));
	} else {
		return array();
	}

	return array('red' => $r, 'green' => $g, 'blue' => $b);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since  Kogito Theme 1.0.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function kogito_content_image_sizes_attr($sizes, $size)
{
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ('page' === get_post_type()) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter('wp_calculate_image_sizes', 'kogito_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since  Kogito Theme 1.0.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function kogito_post_thumbnail_sizes_attr($attr, $attachment, $size)
{
	if ('post-thumbnail' === $size) {
		is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		!is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'kogito_post_thumbnail_sizes_attr', 10, 3);

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since  Kogito Theme 1.0.0
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function kogito_widget_tag_cloud_args($args)
{
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter('widget_tag_cloud_args', 'kogito_widget_tag_cloud_args');


function filter_the_excerpt_in_the_main_loop($excerpt)
{

	// Check if we're inside the main loop in a single post page.
	if (in_the_loop() && is_main_query()) {
		$excerpt = preg_replace('/<\s*style.+?<\s*\/\s*style.*?>/si', ' ', $excerpt);
	}

	return $excerpt;
}
add_filter('the_excerpt', 'filter_the_excerpt_in_the_main_loop');

function filter_the_content_in_the_main_loop($content)
{

	// Check if we're inside the main loop in a single post page.
	if (in_the_loop() && is_main_query()) {
		$content = preg_replace('/<\s*style.+?<\s*\/\s*style.*?>/si', ' ', $content);
	}

	return $content;
}
add_filter('the_content', 'filter_the_content_in_the_main_loop');

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more($more)
{
	if (!is_single()) {
		$more = sprintf(
			'<a class="kie-read-more-anchor" onclick="KIE.readMore(\'%2$s\'); return false;" href="%1$s">Read more →</a>',
			get_permalink(get_the_ID()),
			get_the_ID()
		);
	}
	return $more;
}
add_filter('excerpt_more', 'wpdocs_excerpt_more');
