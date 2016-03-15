<?php
/**
 * @package MagCrunch
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class('river-block'); ?>>

	<div class="block block-thumb">
		<div class="block-content">

			<span>
				<a href="<?php echo esc_url( get_permalink() );?>" class="thumb">
					<img alt="<?php the_title();?>" src="<?php echo ct_get_thumbnail_src('main-thumb');?>"></a>
			</span>

			<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<div class="byline">
				<time datetime="<?php the_time();?>" class="timestamp"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></time>
				<?php printf(__('by <a href="%2$s" title="Posts by %1$s" rel="author">%1$s</a>', 'magcrunch'), get_the_author(), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) );?>			
			</div>

			<?php the_excerpt();?>

			<div class="social-cluster"><div class="addthis_sharing_toolbox" data-url="<?php echo esc_url( get_permalink() );?>" data-title="<?php the_title();?>"></div></div>

			<div id="clear" style="clear:both;"></div>

		</div><!-- .block-content -->
	</div><!-- .block -->
</li><!-- #post-## -->

<?php if ($wp_query->current_post == 1 && is_active_sidebar('post-ad')) : ?>
	<?php dynamic_sidebar( 'post-ad' ); ?>
<?php endif; ?>