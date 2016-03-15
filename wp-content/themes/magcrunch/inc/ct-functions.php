<?php
/**
 * Custom functions for this specific target theme
 *
 *
 * @package MagCrunch
 */

//////////////////////////////////////////////////////////////////////*/
// define paths / advanced settings. PLEASE DO NOT TOUCH
//////////////////////////////////////////////////////////////////////*/

define('THEME_NAME', 'MagCrunch');
define('THEME_VERSION', '1.0');
define('THEME_AUTHOR', 'Leo');
define('THEME_AUTHOR_URL', 'http://99theme.com/');
define('CSSDIR', get_bloginfo( 'template_directory' ).'/css/');
define('CSSPATH', TEMPLATEPATH.'/css/');
define('JSDIR', get_bloginfo( 'template_directory' ).'/js/');
define('LANGPATH', TEMPLATEPATH.'/languages/');


if ( ! function_exists( 'clonetemplates_numeric_paging_nav' ) ) :
/**
 * Display numeric navigation instead of next/previous set of posts.
 *
 */
function clonetemplates_numeric_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( 'Prev', 'magcrunch' ),
		'next_text' => __( 'Next', 'magcrunch' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'magcrunch' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

/* 
 * Add additional info, like favicon, custom CSS, to <head> section
 */
add_action('wp_head','ct_head_misc');
function ct_head_misc(){
	
	if ( of_get_option('favicon') ) {
		echo '<link href="'.of_get_option('favicon').'" rel="shortcut icon">' . "\n";
	}
	if ( of_get_option('apple_touch_icon') ) {
		echo '<link href="'.of_get_option('apple_touch_icon').'" rel="apple-touch-icon">' . "\n";
	}

	if ( !is_home() && !is_front_page() ) {
		echo '<link rel="prefetch" href="'.home_url().'">'."\n".   
				'<link rel="prerender" href="'.home_url().'">'."\n";
	}
}

/* 
 * Add additional info, like custom javascript, tracking codes, etc in the footer, before </body> closes
 */
add_action('wp_footer', 'ct_load_footer_scripts'); 

function ct_load_footer_scripts() {?>

<script type="text/javascript">
	jQuery(document).ready( function($) {	

		<?php if ( !is_singular() && !is_404() ) :?>
			$('#river1').infinitescroll({
			    navSelector  : "#river1 nav.paging-navigation",            
			    nextSelector : "#river1 nav a.next",    
			    itemSelector : "#river1 li.river-block"          
			});
		<?php endif;?>
		
	});
</script>

<?php if( 'dq' == of_get_option('comment_type') ) :?>
<script type="text/javascript">
        var disqus_shortname = '<?php echo of_get_option('disqus_shortname');?>'; // required

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<?php endif;?>

<?php if( 'fb' == of_get_option('comment_type') ) :?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><!--FB js SDK-->
<?php endif;?>

<?php if (of_get_option('addthis') && of_get_option('addthis_key')) :?>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo of_get_option('addthis_key');?>" async="async"></script>
<?php endif;?>

<?php echo of_get_option('tracking');?>

<?php 
	echo "\n".'<!--'.THEME_NAME.' theme by <a href="'.THEME_AUTHOR_URL.'">'.THEME_AUTHOR.'</a>. All rights reserved.@'.THEME_AUTHOR_URL.'-->'."\n";
}   

if ( ! function_exists( 'ct_get_thumbnail_src' ) ) :
/* 
 * get thumbnail url of a given post by post ID
 * http://clonetemplates.com/?p=574
 */ 
function ct_get_thumbnail_src($size="full", $id=''){
    global $post;
    if (empty($id)) { $id = $post->ID;}
    $t = get_post($id);

	$values = get_post_custom_values("ct_image", $id);
	if( !empty($values) ) { //check if custom field "ct_image" defined
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail($id) ){ //check if featured thumbnail is set
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($id),$size);
		$post_thumbnail_src = $thumbnail_src [0];
    } else { // check if there is any image in the post content
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $t->post_content, $matches);
		if (!empty($matches [1] [0])){$post_thumbnail_src = $matches [1] [0];}   //get image src
		if(empty($post_thumbnail_src)){	//display a default image if no image found
			$post_thumbnail_src = get_bloginfo('template_url') . '/images/default.png';
		}
	};
	return $post_thumbnail_src;
}
endif;

/**
 * Replaces the excerpt "more" text by a link
 **/
function ct_excerpt_more($more) {
    global $post;
	return "\n".'<a class="read-more" href="'. get_permalink($post->ID) . '">Read More...</a>';
}
add_filter('excerpt_more', 'ct_excerpt_more');

// facebook comment
function fb_comments_template($width = '640', $scheme = 'light') {
	global $post;
	echo '<div id="fbcomment" class="collapse"><div class="fb-comments" data-href="'. get_permalink($post->ID) .'" data-width="'. $width .'" data-numposts="5" data-colorscheme="' . $scheme . '"></div></div>';
}

if ( ! function_exists( 'ct_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 */
function ct_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'ct_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;
/**
 * Display a notice on the backend to tell users what plugins are required/recommended for our theme
 */
require_once (get_template_directory() . '/inc/class-tgm-plugin-activation.php');

/**
 * Register the required plugins for this theme.
 *
 */
add_action( 'tgmpa_register', 'ct_theme_register_required_plugins' );
function ct_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'WP PostViews',
            'slug'      => 'wp-postviews',
            'required'  => true,
        ),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     */
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'magcrunch' ),
            'menu_title'                      => __( 'Install Plugins', 'magcrunch' ),
            'installing'                      => __( 'Installing Plugin: %s', 'magcrunch' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'magcrunch' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'magcrunch' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'magcrunch' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'magcrunch' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'magcrunch' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'magcrunch' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'magcrunch' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'magcrunch' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'magcrunch' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'magcrunch' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'magcrunch' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'magcrunch' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'magcrunch' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'magcrunch' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}

/*****************************************************
 ***************************************************** 
 * 
 * Custom functions that act exclusively for our theme
 *
 *****************************************************
 *****************************************************/


/**
 * Display the classes for the wrapper div.
 *
 */
function ct_wrapper_class() {
	// Separates classes with a single space, collates classes for post DIV
    echo 'class="' . join( ' ', get_wrapper_class( $class ) ) . '"';
}

/**
 * Retrieve the classes for the wrapper div as an array.
 *
 */
 function get_wrapper_class( $class = '' ) {
 	$classes = array();
 	$classes[] = 'fluid';

 	if (is_home()) $classes[] = 'flush split homepage';

 	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	return array_unique( $classes );

 }

/**
 * Adds a box to check whether it's featured or not.
 */
function ct_featured_check_box() {

    $screens = array( 'post' );//we only need Featured filter in post

    foreach ( $screens as $screen ) {

        add_meta_box(
            'featured_check_box',
            __( 'Is this a featured post?', 'clonetemplates' ),
            'ct_inner_featured_check_box',
            $screen,
            'side',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'ct_featured_check_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function ct_inner_featured_check_box( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'ct_inner_featured_check_box', 'ct_inner_featured_check_box_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta( $post->ID, 'ct_featured', true );
  if(!$value) $value = 'no';?>

  <input type="checkbox" id="featured_check_box" name="featured_check_box" value="<?php echo $value;?>" <?php checked( $value, 'yes' ); ?>>
  <label for="featured_check_box">
       <?php _e( 'Yes, this post is featured!', 'clonetemplates' );?>
  </label>
  
<?php }

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function ct_featured_save_postdata( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['ct_inner_featured_check_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['ct_inner_featured_check_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'ct_inner_featured_check_box' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  // Check the user's permissions.
  if ( 'post' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // Checks for input and saves
  if( isset( $_POST[ 'featured_check_box' ] ) ) {
    update_post_meta( $post_id, 'ct_featured', 'yes' );
  } else {
    update_post_meta( $post_id, 'ct_featured', 'no' );
  }
}
add_action( 'save_post', 'ct_featured_save_postdata' );

/**
 * Featured Post box on homepage
 *
 */
 function ct_featured_box() {
 	global $page, $paged;

 	if ( !is_home() || $paged >= 2 || $page >= 2  ) {
 		return;
 	}
 	$featured = get_transient('ct_featured_args');
 	
 	if (false == $featured) {
 		$featured = new WP_Query( array(
		    'post_type' 			=> 'post', 
		    'meta_key' 				=> 'ct_featured', 
		    'meta_value' 			=> 'yes', 
		    'posts_per_page' 		=> '4', 
		    'ignore_sticky_posts' 	=> 1,
		    'no_found_rows' 		=> true
	    ) );
    }

    // save it for 6 hours
	set_transient('ct_featured_args', $featured, 60*60*6);?>
                    
    <?php if ($featured->have_posts()) : $count = 0; ?>
    <!-- Begin: Featured Island -->
    <div class="island plain-island">
        <?php while ( $featured->have_posts() ) : $featured->the_post(); $count++;
        	if ( '1' == $count) {?>
        		<div class="plain-feature block block-inset">
			        <div class="e-block_list m-colored_list">			    
			        	<a href="<?php the_permalink();?>" title="<?php the_title();?>">
			        		<img alt="<?php the_title();?>" class="thumb" width="500" height="369" src="<?php echo ct_get_thumbnail_src('featured-thumb');?>">
						    <div class="block-title">
								<?php the_title('<h2>', '</h2>');?>
								<div class="byline"><?php printf( __('by %1$s', 'magcrunch'), get_the_author() );?></div>
							</div>
						</a>
			    	</div>
			    </div>
			    <ul class="plain-item-list">
        	<?php } else { ?>
			    
				<li class="plain-item block block-small">
					<a href="<?php the_permalink();?>" title="<?php the_title();?>">
						<img alt="<?php the_title();?>" class="thumb" width="145" height="90" src="<?php echo ct_get_thumbnail_src('main-thumb');?>">
						    <div class="plain-title">
								<?php the_title('<h2 class="h-alt">', '</h2>');?>
								<p class="byline"><?php printf( __('by %1$s', 'magcrunch'), get_the_author() );?></p>
							</div>
					</a>  
				</li>
        	<?php }
        endwhile; ?>
    	</ul>
    </div>
    <?php endif;wp_reset_postdata();

 }

add_action('publish_post', 'ct_featured_args_delete', 0);
add_action('delete_post', 'ct_featured_args_delete', 0);
add_action('save_post', 'ct_featured_args_delete', 0);
function ct_featured_args_delete(){
    delete_transient('ct_featured_args');
}

/**
 * Popular posts on the left of single post
 *
 */
function ct_popular_posts( $num ) {
    if ( !$num ) $num = 10;

    if ( !is_single()  ) {
        return;
    }

    $popular = get_transient('ct_popular_args');
  
    if (false == $popular) {
        $args = array();

        $args = array(
            'post_type'             => 'post', 
            'posts_per_page'        => $num, 
            'ignore_sticky_posts'   => 1,
            'no_found_rows'         => true
        );

        if (function_exists('the_views')) {
            $args['meta_key'] = 'views';
            $args['orderby']  = 'meta_value_num';
        } else {
            $args['orderby']  = 'rand';
        }
        $popular = new WP_Query( $args );
    }

    // save it for 1 hours
    set_transient('ct_popular_args', $popular, 60*60*1);?>
                    
    <?php if ($popular->have_posts()) : $count = 0; ?>
        <li class="active">
            <div class="acc-handle loaded"><a><?php _e('Popular Posts', 'magcrunch');?></a></div>
            <div id="popular_posts" class="acc-panel">
                <ul class="grv_articles grv_has_summary grv_has_image">
                    <?php while ( $popular->have_posts() ) : $popular->the_post(); $count++; ?>
                        <li class="grv_article">
                            <a class="grv_img_link" href="<?php echo esc_url(get_permalink());?>">
                                <img class="grv_article_img" src="<?php echo ct_get_thumbnail_src('main-thumb');?>" width="88" height="60" title="<?php the_title();?>" />
                            </a>
                            <a class="grv_article_title" href="<?php echo esc_url(get_permalink());?>">
                                <?php the_title();?>
                            </a>
                            <span class="grv_date"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </li>
    <?php endif;wp_reset_postdata();

 }

add_action('delete_post', 'ct_popular_args_delete', 0);
function ct_popular_args_delete(){
    delete_transient('ct_popular_args');
}


/**
 * display related posts below post
 *
 */

function ct_related_posts($id = '') {
  
  // post ID and options
  global $post;
  if (!$id) $id = $post->ID;
  $number = of_get_option('related_posts_count');
  if (!$number) $number = 6;
  $queried_ids = array();

  if ( !of_get_option('related_posts') ) {
    return ;
  }
  
  // tags and categories
  $tags = wp_get_post_tags( $id );
  $categories = wp_get_post_categories( $id );
  $tag_ids = array();
  if ($tags) {
    foreach($tags as $tag) {
      $tag_ids[] = $tag->term_id;
    }
  }
  
  // check for related posts by "tags" in random order
  $tagquery = array('posts_per_page' => $number,'ignore_sticky_posts' => 1,'orderby' => 'rand','post__not_in' => array($id),'tax_query' => array(
      array(
        'taxonomy' => 'post_tag',
        'field' => 'id',
        'terms' => $tag_ids
      )
  ));
  $tagged = get_posts($tagquery);
  if ($tagged) {
    foreach($tagged as $t) {
      $queried_ids[] = $t->ID;
    }
  }
  
  // check for related posts by "category" in random order
  $catquery = array('posts_per_page' => $number,'ignore_sticky_posts' => 1,'orderby' => 'rand','post__not_in' => array($id),'tax_query' => array(
      array(
        'taxonomy' => 'category',
        'field' => 'id',
        'terms' => $categories
      ),
  ));
  $categorized = get_posts($catquery);
  if ($categorized) {
    foreach($categorized as $c) {
      if (!in_array($c->ID, $queried_ids)) {
        if (count($queried_ids) != $number) {
          $queried_ids[] = $c->ID;
        }
      }
    }
  }
  
  $args = array('post__in' => $queried_ids, 'orderby' => 'rand', 'no_found_rows' => true, 'ignore_sticky_posts' => 1);
  $related = new WP_Query();
  $related->query( $args );
  if( $related->have_posts() ) : $i = 0; ?>

  <div id="related_posts" class="grv_widget">
    <h3 class="grv_stories_header"><?php _e('Recommended For You','magcrunch');?></h3>
    <ul class="grv_articles grv_has_summary grv_has_image">

    <?php while ( $related->have_posts() ) : $related->the_post(); $i++; ?>
      <li class="grv_article grv_num_<?php echo $i;?> grv_has_summary grv_has_image">
        <a class="grv_img_link" href="<?php echo esc_url(get_permalink());?>">
          <img class="grv_article_img grv_positionable grv_full_height" src="<?php echo ct_get_thumbnail_src('main-thumb');?>" width="224" height="129" title="<?php the_title();?>">
        </a>
        <a class="grv_article_title " href="<?php echo esc_url(get_permalink());?>" title="<?php the_title();?>">
          <?php the_title();?>
        </a>
      </li>
    <?php endwhile; ?>
    </ul>
  </div>
  <?php endif;
  
  wp_reset_postdata();

}