<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package MagCrunch
 */
?>

	</div><!-- .fluid -->

	<footer id="colophon" class="footer" role="contentinfo">

		<div class="footer-content">
			<div class="nav-footer">
				<div class="g g-3up g-nogutter">
					<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				</div>
			</div>
			<div class="footer-meta-nav g g-1up">
				<div class="copyright gi">
					<span class="footer-section">
						<?php 
						if ( of_get_option('copyright') ) {
							echo of_get_option('copyright');
						} else {
							printf( __( 'Made with &hearts; from <a href="%s" rel="designer" target="_blank">99theme</a>', 'magcrunch'), 'http://99theme.com/' ); 
						}?>
					</span>
					<span class="footer-section">
						<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_id' => 'f_nav', 'menu_class'=> 'f_nav' ) ); ?>
					</span>
				</div>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
