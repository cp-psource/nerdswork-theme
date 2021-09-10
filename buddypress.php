<?php
/**
 * BuddyPress Directory layout wrapper
 *
 * This template acts as wrapper for all top level BuddyPress Pages( Like Activity directory,Members Directory,  Groups directory etc)
 *
 * @package social-portal
 * @author WMS N@W
 *
 */

?>
<?php get_header( 'buddypress' ); ?>

<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- section container -->

	<?php
	/**
	 * The hook 'cb_before_container_contents' is used to add anything below the site header
	 *  @see cb-page-builder.php for the details
	 */
	?>

	<?php do_action( 'cb_before_container_contents' ); ?>

	<div class="clearfix inner">
		
		<section id="content">

			<?php do_action( 'cb_before_bp_contents' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/entry-buddypress' ); ?>
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/entry-404' ); ?>

			<?php endif; ?>

			<?php do_action( 'cb_after_bp_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar( 'buddypress' ); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( 'buddypress' ); ?>
