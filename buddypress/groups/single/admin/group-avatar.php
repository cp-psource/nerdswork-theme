<?php
/**
 * BuddyPress - Groups Admin - Group Avatar
 *
 * @package social-portal
 */

?>

<h2 class="bp-screen-reader-text"><?php _e( 'Gruppen-Avatar', 'social-portal' ); ?></h2>

<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

	<p><?php _e("Lade ein Bild hoch, das Du als Profilfoto für diese Gruppe verwenden möchtest. Das Bild wird auf der Hauptgruppenseite und in den Suchergebnissen angezeigt.", 'social-portal' ); ?></p>

	<p>
		<label for="file" class="bp-screen-reader-text"><?php _e( 'Wähle ein Bild aus', 'social-portal' ); ?></label>
		<input type="file" name="file" id="file" />
		<input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Bild hochladen', 'social-portal' ); ?>" />
		<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
	</p>

	<?php if ( bp_get_group_has_avatar() ) : ?>
		<p><?php _e( "Wenn Du das vorhandene Gruppenprofilfoto entfernst, aber kein neues hochladen möchteat, klicke auf die Schaltfläche Gruppenprofilfoto löschen.", 'social-portal' ); ?></p>

		<?php bp_button( array( 'id' => 'delete_group_avatar', 'component' => 'groups', 'wrapper_id' => 'delete-group-avatar-button', 'link_class' => 'edit', 'link_href' => bp_get_group_avatar_delete_link(), 'link_title' => __( 'Gruppenprofilfoto löschen', 'social-portal' ), 'link_text' => __( 'Gruppenprofilfoto löschen', 'social-portal' ) ) ); ?>

	<?php endif; ?>

	<?php
	/**
	 * Load the Avatar UI templates
	 *
	 */
	bp_avatar_get_templates(); ?>

	<?php wp_nonce_field( 'bp_avatar_upload' ); ?>

<?php endif; ?>

<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

	<h4><?php _e( 'Profilprofil beschneiden', 'social-portal' ); ?></h4>

	<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Profilfoto zum Zuschneiden', 'social-portal' ); ?>" />

	<div id="avatar-crop-pane">
		<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Profilfotovorschau', 'social-portal' ); ?>" />
	</div>

	<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e( 'Bild zuschneiden', 'social-portal' ); ?>" />

	<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
	<input type="hidden" id="x" name="x" />
	<input type="hidden" id="y" name="y" />
	<input type="hidden" id="w" name="w" />
	<input type="hidden" id="h" name="h" />

	<?php wp_nonce_field( 'bp_avatar_cropstore' ); ?>

<?php endif; ?>
