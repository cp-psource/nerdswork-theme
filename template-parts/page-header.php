<?php
/**
 * Global Page Header
 *
 */
?>
<div class ="page-header <?php echo ( cb_get_header_image() ? 'page-header-mask-enabled' : '' ); ?>" id="page-header">
	
	<div class="page-header-mask"></div><!-- bg mask -->
	
		<?php do_action( 'cb_before_page_header' ); ?>

		<div class="inner">

			<?php do_action( 'cb_before_page_header_contents' ); ?>
			
			<div class="page-header-contents">
			<?php echo cb_get_page_header_contents(); ?>
			</div>

			<?php do_action( 'cb_after_page_header_contents' ); ?>

		</div>

		<?php do_action( 'cb_after_page_header' ); ?>
	
</div><!-- end of page-header -->