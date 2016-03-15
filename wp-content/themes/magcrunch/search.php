<?php
/**
 * The template for displaying search results pages.
 *
 * @package MagCrunch
 */

get_header(); ?>

	<div class="lc flush lc-island">
		<div class="l-two-col no-overflow-x" role="main">
			<div class="l-main-container">
				<div class="l-main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'magcrunch' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- .page-header -->

					<div class="tuck lc-padding">
						<div class="tabs tabs-large">
							<ul class="tab-list tabs-no-select">
								<li class="latest"><a class="active tabs-no-preventdefault">Latest</a></li>
							</ul>
						</div>
					</div>

					<ul class="river lc-padding" id="river1">

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php clonetemplates_numeric_paging_nav(); ?>

					</ul><!-- #river1 -->

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>

				</div><!-- .l-main -->
			</div><!-- .l-main-container -->

			<?php get_sidebar(); ?>

		</div><!-- .l-two-col -->
	</div><!-- .lc.flush -->

<?php get_footer(); ?>
