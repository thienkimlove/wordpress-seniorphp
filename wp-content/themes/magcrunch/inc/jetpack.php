<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package MagCrunch
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function clonetemplates_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'clonetemplates_jetpack_setup' );
