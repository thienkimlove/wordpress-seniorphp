<?php
/*
Plugin Name: Jetpack Markdown Support
Version: 1.0.0
Plugin URI: http://github.com/kopepasah/jetpack-markdown-support
Description: A simple plugin which adds Jetpack's Markdown Module support to Custom Post Types.
Author: Justin Kopepasah
Author URI: http://kopepasah.com

Copyright 2014  (email: justin@kopepasah.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class Jetpack_Markdown_Support {
	/**
	 * @var Jetpack_Markdown_Support
	 * @since 1.0.0
	*/
	private static $instance;

	/**
	 * Main Jetpack Markdown Support Instance
	 *
	 * @since 1.0.0
	 * @static
	*/
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Jetpack Markdown Support Constructor
	 *
	 * @since 1.0.0
	*/
	public function __construct() {

		/**
		 * Do a check to see if Jetpack and Jetpack Markdown
		 * Module are active.
		 *
		 * @since 1.0.0
		*/
		if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'markdown' ) ) {
			add_action( 'admin_notices', array( $this, 'notice' ) );
			return;
		}

		// Load localization domain
		load_plugin_textdomain( 'jetpack-markdown-support', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Add post type support.
		add_action( 'init', array( $this, 'add_post_type_support' ) );
	}

	/**
	 * Notice when Jetpack and Jetpack Markdown Module
	 * are not active.
	 *
	 * @since 1.0.0
	*/
	public function notice() {
		if ( ! class_exists( 'Jetpack' ) ) {
			$notice = __( 'Jetpack Markdown Support requires Jetpack.', 'jetpack-markdown-support' );
		} else if ( ! Jetpack::is_module_active( 'markdown' ) ) {
			$notice = __( 'Jetpack Markdown Support requires Jetpack\'s Markdown Module.', 'jetpack-markdown-support' );
		}

		echo '<div class="error"><p>' . $notice . '</p></div>';
	}

	/**
	 * Get public post types.
	 *
	 * @since 1.0.0
	 * @uses get_post_types()
	 * @return array Contains the public post types.
	*/
	function get_public_post_types() {
		$post_types = get_post_types( array(
			'public' => true
		) );

		return $post_types;
	}

	/**
	 * Add post type support for Markdown if a post
	 * type is public and has editor support.
	 *
	 * @since 1.0.0
	 * @uses post_type_supports()
	 * @uses add_post_type_support()
	*/
	function add_post_type_support() {
		foreach ( $this->get_public_post_types() as $post_type ) {
			if ( post_type_supports( $post_type, 'editor' ) ) {
				add_post_type_support( $post_type, 'wpcom-markdown' );
			}
		}
	}
}

/**
 * Instantiate this plugin on plugins_loaded.
 *
 * @since 1.0.0
*/
function pb_jetpack_markdown_support() {
	return Jetpack_Markdown_Support::instance();
}
add_action( 'plugins_loaded', 'pb_jetpack_markdown_support' );