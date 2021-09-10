<?php
/**
 * Page Not Found template( 404 )
 *
 * @package social-portal
 * @author WMS N@W
 */
?>
<?php get_header( '404' ); ?>

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

			<h1 class="page-title hidden-title"><?php _e( 'Inhalt nicht gefunden!', 'social-portal' ); ?></h1>
			
			<?php do_action( 'cb_before_404_contents' ); ?>

			<?php get_template_part( 'template-parts/entry-404' ); ?>

			<?php do_action( 'cb_after_404_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar( '404' ); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( '404' ); ?>