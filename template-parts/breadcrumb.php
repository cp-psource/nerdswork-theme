<?php
/**
 * Template for displaying breadcrumb
 */
?>
<?php if ( cb_is_breadcrumb_enabled() ) : ?>
	<div id="breadcrumb">
		<div class="inner clearfix">
			<?php cb_breadcrumb(); ?>
		</div>
	</div>
<?php endif;?>