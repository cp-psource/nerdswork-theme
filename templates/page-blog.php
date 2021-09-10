<?php
/**
 * Template Name: Blog Posts List
 */
?>
<?php get_header( 'blog' ); ?>

<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- main container -->

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
			
			<?php
			//we need to manipulate query here right 
			global $wp_query;
                       
			$limit = get_option( 'posts_per_page' );
			$paged = get_query_var( 'paged' )  ? get_query_var( 'paged' ) : 1;
			
			//yes we are modifying the main query I know
			query_posts( array(
				'posts_per_page'    => $limit,
				'paged'             => $paged,
			) );

			//since it should act like archive page
			$wp_query->is_archive = true;
			$wp_query->is_home = false;
			?>
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
			
			<?php wp_reset_query();?>

			<?php do_action( 'cb_after_blog_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar( 'blog' ); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( 'blog' ); ?>