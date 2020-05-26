<?php

/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package KIE
 * @subpackage KIE_Theme
 * @since KIE Theme 1.0.0
 */

require get_template_directory() . '/inc/custom-menu.php';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if (is_singular() && pings_open(get_queried_object())) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>
	<link rel="icon" href="<?php echo get_bloginfo('template_directory'); ?>/assets/favicon.ico">
	<?php
	$description = get_bloginfo('description', 'display');
	if ($description || is_customize_preview()) : ?>
		<title><?php echo $description; ?></title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div class="blog-masthead">
	<div id="overlay"></div>
		<?php if (has_nav_menu('primary')) : ?>
			<nav id="kie_header">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'container_class' => 'wrapper',
					'container' => 'div',
					'depth' => 1,
					'items_wrap' => '%3$s',
					'walker' => new KIE_Walker_Nav_Menu()
				));
				?>
			</nav>
		<?php endif; ?>
	</div>

	<div id="content" class="container wrapper">
		<div style="display : none" class="blog-header">
			<h1 class="blog-title"><?php bloginfo() ?></h1>
			<p class="lead blog-description"><?php echo $description ?></p>
		</div>