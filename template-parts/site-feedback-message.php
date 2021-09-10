<?php
/**
 * Main template for Template Notices
 * It is included via action 'cb_before_container_contents'
 * The generated code is included inside the <div id='container'> </div> .. block as the first thing
 */
?>
<?php if ( cb_has_feedback_message() ) : ?>

	<div id="site-feedback-message" class="site-feedback-message <?php echo cb_get_feedback_message_type(); ?>">
		<div class="inner">
			<?php do_action( 'template_notices' ); ?>
		</div>
	</div>

<?php endif;?>