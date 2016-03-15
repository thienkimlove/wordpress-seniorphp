<?php
/**
 * @package MagCrunch
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('l-main'); ?>>
	<header class="article-header page-title">
		<div class="tags">
		<?php $posttags = get_the_tags(); $categories = get_the_category(); $i = 0; $j = 0;
		
		if ($categories) {
			foreach($categories as $cat) {
				$j++;
				if ( 3 >= $j ) {
					echo '<div class="tag-item"><a href="' . get_category_link($cat->term_id) . '" class="tag">' . $cat->cat_name . '</a></div>'; 
				}
			}
		}

		if ($posttags) {
		  	foreach($posttags as $tag) {
		  		$i++;
		  		if ( 3 >= $i ) {
			    	echo '<div class="tag-item"><a href="' . get_tag_link($tag->term_id) . '" class="tag">' . $tag->name . '</a></div>'; 
			    }
		  	}
		}?>
		</div>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="title-left">
			<div class="byline">
				<?php if ( of_get_option('postmeta') ) {
					printf(__('Posted <time datetime="%1$s" class="timestamp">%2$s ago</time> by <a href="%3$s" title="Posts by %4$s" rel="author">%4$s</a>', 'magcrunch'),
						esc_attr( get_the_date( 'c' ) ),
						human_time_diff( get_the_time('U'), current_time('timestamp') ), 
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);}
				?>

				<?php
					edit_post_link( __( 'Edit', 'magcrunch' ), '<span class="edit-link">', '</span>' );
				?>
			</div>
			<div class="social-share social-share-inline"><div class="addthis_sharing_toolbox" data-url="<?php echo esc_url( get_permalink() );?>" data-title="<?php the_title();?>"></div></div>
		</div>

		<?php $next_post = get_next_post();
		if (!empty( $next_post )): ?>
			<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="next-link" data-omni-sm="art_nextstory">
				<div class="next-story-link"><?php _e('Next Story', 'magcrunch');?></div>
				<div class="next-story-full">
					<h4 class="next-title"><?php echo $next_post->post_title; ?></h4>
				</div>
			</a>
		<?php endif; ?>

	</header><!-- .article-header -->

	<div class="l-two-col">
		<div class="l-main-container">
			<div class="l-main">
				<div class="article-entry text">
					<?php the_content(); ?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'magcrunch' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .article-entry.text -->

				<div id="social-after-wrapper" class="cf social-share social-share-inline social-share-with-bubbles"><div class="addthis_sharing_toolbox" data-url="<?php echo esc_url( get_permalink() );?>" data-title="<?php the_title();?>"></div></div>
				<?php ct_related_posts( get_the_ID() );?>
				<?php dynamic_sidebar( 'content-after-ad' ); ?>

			</div><!-- .l-main -->
		</div><!-- .l-main-container -->

		<?php get_sidebar('single');?>

	</div><!-- .l-two-col -->

</div><!-- #post-## -->
