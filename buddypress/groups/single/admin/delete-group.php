<?php
/**
 * BuddyPress - Groups Admin - Delete Group
 *
 * @package social-portal
 */

?>
<h2 class="bp-screen-reader-text"><?php _e( 'Gruppe löschen', 'social-portal' ); ?></h2>
<?php

/**
 * Fires before the display of group delete admin.
 *
 */
do_action( 'bp_before_group_delete_admin' ); ?>

<div id="message" class="info">
	<p><?php _e( 'WARNUNG: Durch Löschen dieser Gruppe werden ALLE damit verbundenen Inhalte vollständig entfernt. Es gibt keinen Weg zurück, bitte sei vorsichtig mit dieser Option.', 'social-portal' ); ?></p>
</div>

<label for="delete-group-understand"><input type="checkbox" name="delete-group-understand" id="delete-group-understand" value="1" onclick="if(this.checked) { document.getElementById('delete-group-button').disabled = ''; } else { document.getElementById('delete-group-button').disabled = 'disabled'; }" /> <?php _e( 'Ich verstehe die Konsequenzen des Löschens dieser Gruppe.', 'social-portal' ); ?></label>

<?php

/**
 * Fires after the display of group delete admin.
 *
 */
do_action( 'bp_after_group_delete_admin' ); ?>

<div class="submit">
	<input type="submit" disabled="disabled" value="<?php esc_attr_e( 'Gruppe löschen', 'social-portal' ); ?>" id="delete-group-button" name="delete-group-button" />
</div>

<?php wp_nonce_field( 'groups_delete_group' ); ?>