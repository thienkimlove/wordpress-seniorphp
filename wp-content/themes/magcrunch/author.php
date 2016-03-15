<?php
/**
 * The template for displaying Author archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package MagCrunch
 */

get_header(); ?>

	<div class="lc flush lc-island">
		<div class="page-title">
			<h1><?php the_author();?></h1>
		</div>
		<div class="l-two-col no-overflow-x">
			<div class="l-main-container">
				<div class="l-main">
					<div class="profile cf">
						<div class="inset-left">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 216 );?>
							<ul class="inline-list social-list sprite-social">
								<li><a href="<?php echo get_author_feed_link(get_the_author_meta( 'ID' ), ''); ?>" class="fa fa-rss">
									<span class="is-vishidden">RSS</span></a>
								</li>
								
							</ul>
						</div>
						<div class="profile-text text">
							<?php if ( get_the_author_meta( 'description' ) ) : ?>
								<p><?php the_author_meta( 'description' ); ?></p>
							<?php endif; ?>
						</div>
					</div>

				<?php if ( have_posts() ) : ?>
					<h2 class="section-title"><?php printf(__('Latest from %1$s','magcrunch'), get_the_author());?></h2>

					<div class="tuck lc-padding">
						<div class="tabs tabs-large">
							<ul class="tab-list tabs-no-select">
								<li class="latest"><a class="active tabs-no-preventdefault">Latest</a></li>
							</ul>
						</div>
					</div>

					<ul class="river lc-padding" id="river1">

					<?php /* Start the Loop */ ?>
					<?php 
						rewind_posts();
						while ( have_posts() ) : the_post(); ?>

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
