<?php
/**
 * BuddyPress - Groups Admin - Group Cover Image Settings
 *
 * @package social-portal
 */

?>
<h4><?php _e( 'Titelbild', 'social-portal' ); ?></h4>
<?php

/**
 * Fires before the display of profile cover image upload content.
 *
 */
do_action( 'bp_before_group_settings_cover_image' ); ?>

<p><?php _e( 'Das Titelbild wird verwendet, um die Kopfzeile Deiner Gruppe anzupassen.', 'social-portal' ); ?></p>

<?php bp_attachments_get_template_part( 'cover-images/index' ); ?>

<?php

/**
 * Fires after the display of group cover image upload content.
 *
 */
do_action( 'bp_after_group_settings_cover_image' ); ?>