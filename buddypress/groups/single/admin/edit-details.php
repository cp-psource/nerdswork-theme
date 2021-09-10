<?php
/**
 * BuddyPress - Groups Admin - Edit Details
 *
 * @package social-portal
 */

?>
<h2 class="bp-screen-reader-text"><?php _e( 'Gruppendetails verwalten', 'social-portal' ); ?></h2>
<?php

/**
 * Fires before the display of group admin details.
 *
 */
do_action( 'bp_before_group_details_admin' ); ?>

<label for="group-name"><?php _e( 'Gruppenname (erforderlich)', 'social-portal' ); ?></label>
<input type="text" name="group-name" id="group-name" value="<?php bp_group_name(); ?>" aria-required="true" />

<label for="group-desc"><?php _e( 'Gruppenbeschreibung (erforderlich)', 'social-portal' ); ?></label>
<textarea name="group-desc" id="group-desc" aria-required="true"><?php bp_group_description_editable(); ?></textarea>

<?php

/**
 * Fires after the group description admin details.
 *
 */
do_action( 'groups_custom_group_fields_editable' ); ?>

<p>
	<label for="group-notify-members">
		<input type="checkbox" name="group-notify-members" id="group-notify-members" value="1" /><?php _e( 'Benachrichtige Gruppenmitglieder per E-Mail über diese Änderungen', 'social-portal' ); ?>
	</label>
</p>

<?php

/**
 * Fires after the display of group admin details.
 *
 */
do_action( 'bp_after_group_details_admin' ); ?>

<p><input type="submit" value="<?php esc_attr_e( 'Änderungen speichern', 'social-portal' ); ?>" id="save" name="save" /></p>
<?php wp_nonce_field( 'groups_edit_group_details' ); ?>