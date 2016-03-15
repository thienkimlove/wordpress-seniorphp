<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package MagCrunch
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="initial-scale=1.0,width=device-width,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0">
<meta http-equiv="cleartype" content="on">
<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?>">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri();?>/js/html5.js"></script><![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'magcrunch' ); ?></a>

	<header class="header cf" role="banner">
		<div class="nav-bar">
			<div class="lc">
				<div class="header-logo-bar">
					<?php dynamic_sidebar( 'header-ad' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link" title="<?php bloginfo( 'name' ); ?>" rel="home">
						<img src="<?php if (of_get_option('logo')) {echo of_get_option('logo');} else {echo get_template_directory_uri().'/images/logo.png';}?>" width="180px" height="90px" alt="<?php bloginfo( 'name' ); ?>" class="logo">
					</a>
					<div class="header-tip">
						<a><?php bloginfo( 'description' ); ?></a>
					</div><!-- .header-tip -->
				</div><!-- .header-logo-bar -->

				<a href="#" class="toggle-link nav-toggle icon-hamburger"><span class="is-vishidden"><?php _e( 'Menu', 'magcrunch' ); ?></span></a>
				<a href="#nav-search" id="search-form-toggle" class="toggle-link search-form-toggle icon-mag"><span class="is-vishidden"><?php _e( 'Search', 'magcrunch' ); ?></span></a>

				<nav class="nav-primary" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_id' => 'nav', 'menu_class'=> 'nav' ) ); ?>
				</nav><!-- #site-navigation -->

				<form action="<?php echo home_url( '/' ); ?>" method="get" id="nav-search" class="search-form" role="search">
					<fieldset>
						<legend><?php _e( 'Search', 'magcrunch' ); ?></legend>
						<label for="s"><?php _e( 'Search', 'magcrunch' ); ?></label>
						<input type="search" placeholder="<?php echo esc_attr_x( 'Search', 'magcrunch' ) ?>" class="search-field" name="s" value="" title="<?php echo esc_attr_x( 'Search for:', 'magcrunch' ) ?>" >
						<button class="search-submit">
							<span class="icon-mag"></span>
							<span class="is-vishidden"><?php _e( 'Search', 'magcrunch' ); ?></span>
						</button>
					</fieldset>
				</form>

			</div><!-- .lc -->
		</div><!-- .nav-bar -->
	</header><!-- .header -->

	<?php if ( of_get_option('announcement') ) :?>
		<div class="announcement announcement-grey-background">
			<div class="lc">
				<div class="announcement-bg">
					<div class="announcement_left">
						<a href="<?php echo esc_url(of_get_option('announcement_link'));?>">
							<span class="announcement-text">
								<strong class="announcement-headline"><?php echo of_get_option('announcement_title');?></strong>&nbsp;<?php echo of_get_option('announcement_subtitle');?>								
								<span class="announcement-link-text"></span>
							</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endif;?>

	<div role="main" <?php ct_wrapper_class();?>>
