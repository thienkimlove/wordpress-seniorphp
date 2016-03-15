<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

    // This gets the theme name from the stylesheet
    $themename = wp_get_theme();
    $themename = preg_replace("/\W/", "_", strtolower($themename) );

    $optionsframework_settings = get_option( 'optionsframework' );
    $optionsframework_settings['id'] = $themename;
    update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'magcrunch'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

    // Number data
    $num_array = array(
        '3' => __('3', 'magcrunch'),
        '6' => __('6', 'magcrunch'),
        '9' => __('9', 'magcrunch'),
        '12' => __('12', 'magcrunch'),
        '15' => __('15', 'magcrunch')
    );

    // color scheme Array
    $color_scheme = array(
        'green'         => __('Default: Green', 'magcrunch'),
        'light-green'    => __('Light Green', 'magcrunch'),
        'blue'          => __('Blue', 'magcrunch'),   
        'red'           => __('Red', 'magcrunch'),      
        'purple'        => __('Purple', 'magcrunch'),
    );

    // comment type Array
    $comment_type = array(
        'wp' => __('Wordpress Comment', 'magcrunch'),
        'fb' => __('Facebook Comment', 'magcrunch'),
        'dq' => __('Disqus Comment', 'magcrunch'),
    );

    // Multicheck Defaults
    $multicheck_defaults = array(
        'one' => '1',
        'five' => '1'
    );

    // Background Defaults
    $background_defaults = array(
        'color' => '',
        'image' => '',
        'repeat' => 'repeat',
        'position' => 'top center',
        'attachment'=>'scroll' );

    // Typography Defaults
    $typography_defaults = array(
        'size' => '15px',
        'face' => 'georgia',
        'style' => 'bold',
        'color' => '#bada55' );

    // Typography Options
    $typography_options = array(
        'sizes' => array( '6','12','14','16','20' ),
        'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
        'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
        'color' => false
    );

    // Pull all the categories into an array
    $options_categories = array();
    $options_categories_obj = get_categories();
    foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
    }

    // Pull all tags into an array
    $options_tags = array();
    $options_tags_obj = get_tags();
    foreach ( $options_tags_obj as $tag ) {
        $options_tags[$tag->term_id] = $tag->name;
    }


    // Pull all the pages into an array
    $options_pages = array();
    $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
    $options_pages[''] = 'Select a page:';
    foreach ($options_pages_obj as $page) {
        $options_pages[$page->ID] = $page->post_title;
    }

    // If using image radio buttons, define a directory path
    $imagepath =  get_template_directory_uri() . '/images/';

    $options = array();

    $options[] = array(
        'name' => __('General Settings', 'magcrunch'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Choose Color Scheme', 'magcrunch'),
        'desc' => __('Select the color scheme for your website. Default: Green', 'magcrunch'),
        'id'   => 'color_scheme',
        'type' => 'select',
        'class'=> 'mini',
        'std'  => 'green',
        'options' => $color_scheme);

    $options[] = array(
        'name' => __('Logo', 'magcrunch'),
        'desc' => __('Upload a main logo, or specify an image URL directly. <b>Size: 180x90</b>', 'magcrunch'),
        'id' => 'logo',
        'type' => 'upload'); 

    $options[] = array(
        'name' => __('Favicon', 'magcrunch'),
        'desc' => __('Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.', 'magcrunch'),
        'id' => 'favicon',
        'type' => 'upload');

    $options[] = array(
        'name' => __('Apple Touch Icon', 'magcrunch'),
        'desc' => __('Upload an image, or specify an image URL directly. This image is the favicon of mobile devices and tablets. <b>Size: 152x152</b>', 'magcrunch'),
        'id' => 'apple_touch_icon',
        'type' => 'upload');

    $options[] = array(
        'name' => __('Enable Infinite Scroll', 'magcrunch'),
        'desc' => __('Check this to enable infinite scroll feature, or it will use default wordpress pagination instead.', 'magcrunch'),
        'id' => 'infcr',
        'std' => '1',
        'type' => 'checkbox');

    $options[] = array(
        'name' => __('Google Analytics', 'magcrunch'),
        'desc' => __('Please enter in your google analytics tracking code <b>(other tracking codes are also supported)</b> here. Remember to include the entire script from google, if you just enter your tracking ID it won\'t work.', 'magcrunch'),
        'id' => 'tracking',
        'std' => '',
        'type' => 'textarea'); 

    /**
     * For $settings options see:
     * http://codex.wordpress.org/Function_Reference/wp_editor
     *
     * 'media_buttons' are not supported as there is no post to attach items to
     * 'textarea_name' is set by the 'id' you choose
     */

    $wp_editor_settings = array(
        'wpautop' => true, // Default
        'textarea_rows' => 5,
        'tinymce' => array( 'plugins' => 'wordpress' )
    );

    $options[] = array(
        'name' => __('Footer Copyright Texts', 'magcrunch'),
        'desc' => sprintf( __( 'Default: Made with &hearts; from <a href="%s" rel="designer" target="_blank">99theme</a>', 'magcrunch' ), 'http://99theme.com/' ),
        'id'   => 'copyright',
        'std' => sprintf( __( 'Made with &hearts; from <a href="%s" rel="designer" target="_blank">99theme</a>'), 'http://99theme.com/' ),
        'type' => 'editor',
        'settings' => $wp_editor_settings
    );

    $options[] = array(
        'name' => __('Blog Settings', 'magcrunch'),
        'type' => 'heading');

    $options[] = array(
        'name' => __( 'Enable AddThis Sharing', 'magcrunch' ),
        'desc' => __( 'Check this to enable AddThis Sharing tools and sharing buttons will display in your website once you configure it correctly. If you want to use other sharing tools or plugins, you can uncheck this. Please also note that AddThis Buttons will not display in Infinite Scroll mode.', 'magcrunch' ),
        'id'   => 'addthis',
        'std'  => '',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __( 'AddThis Pub Key', 'magcrunch' ),
        'desc' => sprintf(__( 'Required if you have checked above option. You can find your Pub Key in <a href="%1$s">AddThis dashboard</a>.', 'magcrunch' ),'http://www.addthis.com/dashboard'),
        'id' => 'addthis_key',
        'class' => 'hidden',
        'type' => 'text'
    );

    $options[] = array(
        'name' => __('Show Post Meta (Author, Date)', 'magcrunch'),
        'desc' => __('Check this to show post meta at the beginning of post content.', 'magcrunch'),
        'id' => 'postmeta',
        'std' => '1',
        'type' => 'checkbox');

    $options[] = array(
        'name' => __( 'Related Posts', 'magcrunch' ),
        'desc' => __( 'Check this to display a Related Posts section at the end of post content.', 'magcrunch' ),
        'id'   => 'related_posts',
        'std'  => '',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __( 'Number of Related Posts', 'magcrunch' ),
        'desc' => __( 'Select how many related posts to display.', 'magcrunch' ),
        'id'   => 'related_posts_count',
        'std'  => '6',
        'type' => 'select',
        'options' => $num_array
    );

    $options[] = array(
        'name' => __('Choose Comment Form', 'magcrunch'),
        'desc' => __('Default: Wordpress Comment. If you want to use Disqus Comment, you have to enter your Disqus Shortname in below field.', 'magcrunch'),
        'id'   => 'comment_type',
        'std'  => 'wp',
        'type' => 'select',
        'class'=> 'small',
        'options' => $comment_type
    );    

    $options[] = array(
        'name' => __('Disqus Shortname', 'magcrunch'),
        'desc' => sprintf(__(' Required if you have checked to use Disqus Comment. Disqus Shortname is the unique identifier for your website as registered on Disqus. If undefined, the Disqus embed will not load. For more information, visit <a href="%1$s" target=_blank>https://disqus.com/</a>', 'magcrunch'), 'https://disqus.com/'),
        'id' => 'disqus_shortname',
        'std' => '',
        'type' => 'text');

    $options[] = array(
        'name' => __('Announcement Settings', 'magcrunch'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Display Announcement', 'magcrunch'),
        'desc' => __('Check this to show an announcement at the top of main content area.', 'magcrunch'),
        'id' => 'announcement',
        'std' => '',
        'type' => 'checkbox'); 

    $options[] = array(
        'name' => __('Announcement Title', 'magcrunch'),
        'desc' => __('Enter in the Announcement Title here', 'magcrunch'),
        'id' => 'announcement_title',
        'std' => '',
        'type' => 'text');

    $options[] = array(
        'name' => __('Announcement Sub-Title', 'magcrunch'),
        'desc' => __('Enter in the Announcement Sub-Title here', 'magcrunch'),
        'id' => 'announcement_subtitle',
        'std' => '',
        'type' => 'text');

    $options[] = array(
        'name' => __('Announcement link', 'magcrunch'),
        'desc' => __('This is where the users would be redirected to once click this announcement.', 'magcrunch'),
        'id' => 'announcement_link',
        'type' => 'text');

    $options[] = array(
        'name' => __('Ad Settings', 'magcrunch'),
        'type' => 'heading' );

    $options[] = array(
        'name' => __('Settings Guide', 'magcrunch'),
        'desc' => __('All ad places are defined in the <i><b>Appearance > Widgets</b></i> Panel. Enter your ad codes in the revalent widget area by adding a <i><b>Text</i></b> Widget.', 'magcrunch'),
        'type' => 'info');

    return $options;
}