<?php
/**
 * PSForum content wrapper
 *
 * Main template file acts as a wrapper for all PSForum Content
 *
 * @package social-portal
 * @author WMS N@W
 *
 */
?>
<?php get_header( 'psforum' ); ?>

<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- section container -->

	<?php
	/**
	 * The hook 'cb_before_container_contents' is used to add anything below the site header
	 *  @see cb-page-builder.php for the details
	 */
	?>

	<?php do_action( 'cb_before_container_contents' ); ?>

	<div class="clearfix inner">
		
		<section id="content" class="psf-content-section">

			<?php do_action( 'cb_before_psforum_contents' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/entry-psforum' ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/entry-404' ); ?>

			<?php endif; ?>

			<?php do_action( 'cb_after_psforum_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar( 'psforum' ); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( 'psforum' ); ?>