<?php
/**
 * The template for displaying all single posts.
 *
 * @package MagCrunch
 */

get_header(); ?>

<article class="article lc">
	<div class="l-two-col-expose">
		<div class="l-main-container no-overflow-x" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- .l-main-container -->

		<div class="l-sidebar demo-block">
			<div class="accordion recirc-accordion">
				<ul>
					<?php $posttags = get_the_tags(); $categories = get_the_category(); $i = 0; $j = 0;
		
					if ($categories) {
					  	foreach($categories as $cat) {
					  		$j++;
					  		if ( 3 >= $j ) {
						    	echo '<li><div class="loaded acc-handle"><a href="' . get_category_link($cat->term_id) . '">' . $cat->cat_name . '</a></div></li>'; 
						    }
					  	}
					}

					if ($posttags) {
					  	foreach($posttags as $tag) {
					  		$i++;
					  		if ( 3 >= $i ) {
						    	echo '<li><div class="loaded acc-handle"><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></div></li>'; 
						    }
					  	}
					}?>

					<?php ct_popular_posts('10');?>
				</ul>
			</div><!-- .accordion.recirc-accordion -->
		</div><!-- .l-sidebar.demo-block -->

	</div><!-- .l-two-col-expose -->
</article><!-- .article.lc -->

<div class="article-extra">
	<div class="lc l-three-col">
		<?php if ( comments_open() ) :?>
			<div class="l-main-container">
				<div class="l-main">
					<?php comments_template();?>
				</div>
			</div><!-- .l-main-container -->
		<?php endif;?>

		<div class="l-sidebar-2 recirc-up-next section">
			<?php $next_post = get_next_post();
			if (!empty( $next_post )): ?>
				<div class="toaster section">
					<div class="toaster-container">
						<div class="toaster-content">
							<div class="toaster-title"><?php _e('Up Next', 'magcrunch');?></div>
							<h3 class="h-alt">
								<a href="<?php echo get_permalink( $next_post->ID ); ?>">
									<?php echo $next_post->post_title; ?>
								</a>
							</h3>
							<div class="byline">
								<?php 
								printf( __('Posted <time datetime="%1$s" class="timestamp">%2$s ago</time>', 'magcrunch'),
								 	get_the_date($d, $next_post->ID),
								 	human_time_diff( get_the_time('U', $next_post->ID), current_time('timestamp') )
								);?>
							</div>
						</div>
					</div>
				</div>
			<?php endif;?>

			<div class="section">
				<?php dynamic_sidebar( 'sidebar-comment' ); ?>
			</div>

		</div><!-- .l-sidebar-2 -->
	</div><!-- .lc.l-three-col -->
</div><!-- .article-extra -->

<?php get_footer(); ?>