<?php
/**
 * MagCrunch functions and definitions
 *
 * @package MagCrunch
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'clonetemplates_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function clonetemplates_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on MagCrunch, use a find and replace
	 * to change 'magcrunch' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'magcrunch', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add post thumbnail support
	add_theme_support( 'post-thumbnails' ); 
	set_post_thumbnail_size( 210, 158, true );
	add_image_size( 'main-thumb', 210, 158, true );
	add_image_size( 'side-thumb', 300, 170, true );
	add_image_size( 'featured-thumb', 500, 369, true );

	/*
	 * Loads the Options Panel
	 *
	 * If you're loading from a child theme use stylesheet_directory
	 * instead of template_directory
	 */

	if ( ! function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/options-framework/' );
		require_once dirname( __FILE__ ) . '/inc/options-framework/options-framework.php';
		require_once get_template_directory() . '/options.php';
	}

	/*
	 * This is an example of how to add custom scripts to the options panel.
	 * This one shows/hides the an option when a checkbox is clicked.
	 *
	 * You can delete it if you not using that option
	 */

	add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );

	function optionsframework_custom_scripts() { ?>

	<script type="text/javascript">
	jQuery(document).ready(function() {

		jQuery('#addthis').click(function() {
	  		jQuery('#section-addthis_key').fadeToggle(400);
		});

		if (jQuery('#addthis:checked').val() !== undefined) {
			jQuery('#section-addthis_key').show();
		}

		jQuery('#related_posts').click(function() {
	  		jQuery('#section-related_posts_count').fadeToggle(400);
		});

		if (jQuery('#related_posts:checked').val() !== undefined) {
			jQuery('#section-related_posts_count').show();
		}

	});
	</script>

	<?php
	}
	/* 
	 * This is an example of how to override a default filter
	 * for 'textarea' sanitization and $allowedposttags + embed and script.
	 */
	add_action('admin_init','optionscheck_change_santiziation', 100);
	 
	function optionscheck_change_santiziation() {
	    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	    add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
	}
	 
	function custom_sanitize_textarea($input) {
	    global $allowedposttags;
	    $custom_allowedtags["embed"] = array(
	      "src" => array(),
	      "type" => array(),
	      "allowfullscreen" => array(),
	      "allowscriptaccess" => array(),
	      "height" => array(),
	      "width" => array()
	      );
	      $custom_allowedtags["script"] = array(
		  "src" => array(),
	      "type" => array()
		  );
		  $custom_allowedtags["ins"] = array(
		  "style" => array(),
	      "data-ad-client" => array(),
	      "data-ad-slot" => array()
		  );
		  $custom_allowedtags["iframe"] = array(
		  "src" => array(),
	      "scrolling" => array(),
	      "frameborder" => array(),
	      "height" => array(),
	      "width" => array()
		  );
		  $custom_allowedtags["meta"] = array(
		  	"name" => array(),
	        "content" => array(),
	        "property"=>array()
		  );
	 
	      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	      $output = wp_kses( $input, $custom_allowedtags);
	    return $output;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menus() in multi locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'magcrunch' ),
		'footer' => __( 'Footer Menu', 'magcrunch' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'clonetemplates_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // clonetemplates_setup
add_action( 'after_setup_theme', 'clonetemplates_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function clonetemplates_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'magcrunch' ),
		'id'            => 'sidebar-right',
		'description'   => __( 'Appears at the right on Homepage and Archive pages.', 'magcrunch' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'magcrunch' ),
		'id'            => 'sidebar-blog',
		'description'   => __( 'Appears on the right sidebar in single post/page.', 'magcrunch' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s article-container">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Comment Sidebar', 'magcrunch' ),
		'id'            => 'sidebar-comment',
		'description'   => __( 'Appears on the right of comment section', 'magcrunch' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar', 'magcrunch' ),
		'id'            => 'sidebar-footer',
		'description'   => __( 'Appears in the Footer section. You can add up to 3 widgets here.', 'magcrunch' ),
		'before_widget' => '<div id="%1$s" class="widget gi %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Header Ad', 'magcrunch' ),
		'id'            => 'header-ad',
		'description'   => __( 'Appears on the header. Recommended Size: 728x90.', 'magcrunch' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s header-ad ad_container">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Post List Ad', 'magcrunch' ),
		'id'            => 'post-ad',
		'description'   => __( 'Appears in the post list. Recommended Width: 300px.', 'magcrunch' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s river-block ad_container"><div class="block block-thumb"><div class="block-content">',
		'after_widget'  => '</div></div></li>',
		'before_title'  => '<div class="byline">',
		'after_title'   => '</div>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Content End Ad', 'magcrunch' ),
		'id'            => 'content-after-ad',
		'description'   => __( 'Appears at the end of post content in single post/page.', 'magcrunch' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s ad-cluster-containe ad_container">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar Ad', 'magcrunch' ),
		'id'            => 'blog-sidebar-ad',
		'description'   => __( 'Appears at the top of right sidebar in single post/page.', 'magcrunch' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s ad_container">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'clonetemplates_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function clonetemplates_scripts() {
	wp_enqueue_style( 'magcrunch-style', get_stylesheet_uri() );

	wp_enqueue_style( 'fontawesome', get_template_directory_uri() .'/css/fa/css/font-awesome.min.css', array(), '4.2.0' );
	wp_enqueue_style( 'googlefonts', '//fonts.googleapis.com/css?family=Open+Sans|Lusitana|Montserrat|Merriweather:700');
    
    // main styles
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/main.css', array(), '20140701', 'all' );
       
    //extra styles
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/css/custom.css', array(), '20140701', 'all' );

	//color scheme
    if ( of_get_option( 'color_scheme' ) && ('green' != of_get_option( 'color_scheme' )) ) {
		wp_enqueue_style( 'color-scheme', get_template_directory_uri() . '/css/' . of_get_option( 'color_scheme' ) . '.css', array(), '20141204', 'screen' );
	}

	if ( of_get_option('infcr') ) {
		wp_enqueue_script( 'infsc', get_template_directory_uri() . '/js/infsc.min.js', array('jquery'), '2.0.2', true );
	}

	wp_enqueue_script( 'magcrunch-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20141214', true );	
}
add_action( 'wp_enqueue_scripts', 'clonetemplates_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions you can edit on.
 */
require get_template_directory() . '/inc/ct-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
