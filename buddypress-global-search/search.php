<?php
/**
 * BuddyPress Gloabal search, Search page
 *
 *
 * @package social-portal
 * @author WMS N@W
 *
 */
?>
<?php get_header( 'search' ); ?>

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
			<?php
				buddyboss_global_search()->search->prepare_search_page();
			?>
			<?php buddyboss_global_search_load_template( 'results-page-content' ); ?>

			<?php do_action( 'cb_after_bp_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar( 'buddypress' ); ?>

	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( 'search' ); ?>