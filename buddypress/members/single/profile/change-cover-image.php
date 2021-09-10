<?php
/**
 * BuddyPress - Members Profile Change Cover Image
 *
 */

?>

<h4><?php _e( 'Titelbild ändern', 'social-portal' ); ?></h4>

<?php

/**
 * Fires before the display of profile cover image upload content.
 *
 */
do_action( 'bp_before_profile_edit_cover_image' );
?>

<p><?php _e( 'Dein Titelbild wird verwendet, um die Kopfzeile Deines Profils anzupassen.', 'social-portal' ); ?></p>

<?php bp_attachments_get_template_part( 'cover-images/index' ); ?>

<?php

/**
 * Fires after the display of profile cover image upload content.
 *
 */
do_action( 'bp_after_profile_edit_cover_image' );
