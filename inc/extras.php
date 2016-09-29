<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function twentyseventeen_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'twentyseventeen-customizer';
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'twentyseventeen-front-page';
	}

	// Add class if no custom header or featured images.
	if ( ! has_header_image() && ( ! has_post_thumbnail() || is_home() ) ) {
		$classes[] = 'no-header-image';
	}

	// Add class if footer image has been added.
	$footer_image = get_theme_mod( 'twentyseventeen_footer_image' );
	if ( isset( $footer_image ) ) {
		$classes[] = 'twentyseventeen-footer-image';
	}

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' ) && ! twentyseventeen_is_frontpage() ) {
		$classes[] = 'has-sidebar';
	}

	// Add class if top header content is added.
	$twentyseventeen_header_top_text_1 = get_theme_mod( 'twentyseventeen_header_top_text_1' );
	$twentyseventeen_header_top_text_2 = get_theme_mod( 'twentyseventeen_header_top_text_2' );
	if ( '' !== $twentyseventeen_header_top_text_1 || '' !== $twentyseventeen_header_top_text_2 ) {
		$classes[] = 'has-top-content';
	}

	return $classes;
}
add_filter( 'body_class', 'twentyseventeen_body_classes' );

/**
 * Count our number of active panels.
 *
 * Primarily used to see if we have any panels active, duh.
 */
function twentyseventeen_panel_count() {
	$panels = array( '1', '2', '3', '4' );
	$panel_count = 0;

	foreach ( $panels as $panel ) {
		if ( get_theme_mod( 'twentyseventeen_panel' . $panel ) ) {
			$panel_count++;
		}
	}

	return $panel_count;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function twentyseventeen_is_frontpage() {
	if ( is_front_page() && ! is_home() ) {
		return true;
	}

	return false;
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );
