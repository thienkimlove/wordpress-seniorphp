<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
						<h1 class="page-title">
							<?php
								if ( is_category() ) :
									single_cat_title();

								elseif ( is_tag() ) :
									single_tag_title();

								elseif ( is_author() ) :
									printf( __( 'Author: %s', 'magcrunch' ), '<span class="vcard">' . get_the_author() . '</span>' );

								elseif ( is_day() ) :
									printf( __( 'Day: %s', 'magcrunch' ), '<span>' . get_the_date() . '</span>' );

								elseif ( is_month() ) :
									printf( __( 'Month: %s', 'magcrunch' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'magcrunch' ) ) . '</span>' );

								elseif ( is_year() ) :
									printf( __( 'Year: %s', 'magcrunch' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'magcrunch' ) ) . '</span>' );

								elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
									_e( 'Asides', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
									_e( 'Galleries', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
									_e( 'Images', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
									_e( 'Videos', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
									_e( 'Quotes', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
									_e( 'Links', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
									_e( 'Statuses', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
									_e( 'Audios', 'magcrunch' );

								elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
									_e( 'Chats', 'magcrunch' );

								else :
									_e( 'Archives', 'magcrunch' );

								endif;
							?>
						</h1>
						<?php
							// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) :
								printf( '<div class="taxonomy-description">%s</div>', $term_description );
							endif;
						?>
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
