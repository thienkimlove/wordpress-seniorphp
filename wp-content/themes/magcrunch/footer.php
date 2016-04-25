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
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1312502752098780');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1312502752098780&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script>
// ViewContent
// Track key page views (ex: product page, landing page or article)
fbq('track', 'ViewContent');
</script>
</body>
</html>
