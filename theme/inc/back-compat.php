<?php
/**
 * KIE Theme back compat functionality
 *
 * Prevents KIE Theme from running on WordPress versions prior to 4.4,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.4.
 *
 * @package KIE
 * @subpackage KIE_Theme
 * @since KIE Theme 1.0.0
 */

/**
 * Prevent switching to KIE on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since  KIE Theme 1.0.0
 */
function kie_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'kie_upgrade_notice' );
}
add_action( 'after_switch_theme', 'kie_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 *  KIE Theme on WordPress versions prior to 4.4.
 *
 * @since  KIE Theme 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function kie_upgrade_notice() {
	$message = sprintf( __( ' KIE Theme requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'kie' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 *
 * @since  KIE Theme 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function kie_customize() {
	wp_die( sprintf( __( ' KIE Theme requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'kie' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'kie_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 *
 * @since  KIE Theme 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function kie_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( ' KIE Theme requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'kie' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'kie_preview' );
