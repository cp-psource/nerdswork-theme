<?php
/**
 * BuddyPress - Blogs Create
 *
 */
?>
<div id="buddypress">

    <?php
/**
 * Fires at the top of the blog creation template file.
 *
 */
do_action( 'bp_before_create_blog_content_template' );

/**
 * Fires before the display of the blog creation form.
 *
 *
 */
do_action( 'bp_before_create_blog_content' ); ?>

<?php if ( bp_blog_signup_enabled() ) : ?>

	<?php bp_show_blog_signup_form(); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Die Seiten-Registrierung ist derzeit deaktiviert', 'social-portal' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the blog creation form.
 *
 *
 */
do_action( 'bp_after_create_blog_content' ); ?>

<?php
/**
 * Fires at the bottom of the blog creation template file.
 *
 *
 */
do_action( 'bp_after_create_blog_content_template' ); ?>
</div>