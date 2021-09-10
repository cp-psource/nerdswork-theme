<?php
/**
 * Default fallback template
 *
 * @package social-portal
 * @author WMS N@W
 */
?>
<?php get_header(); ?>

<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- section container -->
	<?php
	/**
	 * The hook 'cb_before_container_contents' is used to add anything below the site header
	 *  @see cb-page-builder.php for the details
	 */
	?>
	<?php do_action( 'cb_before_container_contents' ); ?>

	<div class="inner clearfix">
		
		<section id="content">

			<h1 class="page-title hidden-title"><?php _e( 'Blog', 'social-portal' );?></h1>

			<?php do_action( 'cb_before_blog_contents' ); ?>

			<?php if ( have_posts() ) : ?>

				<div id='posts-list' class="<?php echo cb_get_posts_list_class(); ?>">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'template-parts/entry-' . cb_get_posts_display_type(), get_post_type() ); ?>

					<?php endwhile; ?>
				</div>

				<div class="clearfix pagination">
					<?php cb_pagination(); ?>
				</div>

			<?php else : ?>

				<?php get_template_part( 'template-parts/entry-404' ); ?>

			<?php endif; ?>

			<?php do_action( 'cb_after_blog_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar(); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer(); ?>