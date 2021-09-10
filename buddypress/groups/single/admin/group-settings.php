<?php
/**
 * BuddyPress - Groups Admin - Group Settings
 *
 * @package social-portal
 */

?>
<h4 class="bp-screen-reader-text"><?php _e( 'Gruppeneinstellungen verwalten', 'social-portal' ); ?></h4>

<?php

/**
 * Fires before the group settings admin display.
 *
 */
do_action( 'bp_before_group_settings_admin' ); ?>

<fieldset class="group-settings-privacy group-create-privacy">
	<legend><?php _e( 'Privatsphäre-Einstellungen', 'social-portal' ); ?></legend>

	<div class="radio">

		<label for="group-status-public"><input type="radio" name="group-status" id="group-status-public" value="public"<?php if ( 'public' == bp_get_new_group_status() || !bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> aria-describedby="public-group-description" /> <?php _e( 'Dies ist eine öffentliche Gruppe', 'social-portal' ); ?></label>

		<ul id="public-group-description">
			<li><?php _e( 'Jeder Seiten-Benutzer kann dieser Gruppe beitreten.', 'social-portal' ); ?></li>
			<li><?php _e( 'Diese Gruppe wird im Gruppenverzeichnis und in den Suchergebnissen aufgeführt.', 'social-portal' ); ?></li>
			<li><?php _e( 'Gruppeninhalt und -aktivität sind für jeden Seiten-Benutzer sichtbar.', 'social-portal' ); ?></li>
		</ul>

		<label for="group-status-private"><input type="radio" name="group-status" id="group-status-private" value="private"<?php if ( 'private' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> aria-describedby="private-group-description" /> <?php _e( 'Dies ist eine private Gruppe', 'social-portal' ); ?></label>

		<ul id="private-group-description">
			<li><?php _e( 'Nur Benutzer, die eine Mitgliedschaft beantragen und akzeptiert werden, können der Gruppe beitreten.', 'social-portal' ); ?></li>
			<li><?php _e( 'Diese Gruppe wird im Gruppenverzeichnis und in den Suchergebnissen aufgeführt.', 'social-portal' ); ?></li>
			<li><?php _e( 'Gruppeninhalt und -aktivität sind nur für Mitglieder der Gruppe sichtbar.', 'social-portal' ); ?></li>
		</ul>

		<label for="group-status-hidden"><input type="radio" name="group-status" id="group-status-hidden" value="hidden"<?php if ( 'hidden' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> aria-describedby="hidden-group-description" /> <?php _e('Dies ist eine versteckte Gruppe', 'social-portal' ); ?></label>

		<ul id="hidden-group-description">
			<li><?php _e( 'Nur eingeladene Benutzer können der Gruppe beitreten.', 'social-portal' ); ?></li>
			<li><?php _e( 'Diese Gruppe wird nicht im Gruppenverzeichnis oder in den Suchergebnissen aufgeführt.', 'social-portal' ); ?></li>
			<li><?php _e( 'Gruppeninhalt und -aktivität sind nur für Mitglieder der Gruppe sichtbar.', 'social-portal' ); ?></li>
		</ul>

	</div>

</fieldset>

<?php // Group type selection ?>
<?php if ( function_exists( 'bp_groups_get_group_types' ) && $group_types = bp_groups_get_group_types( array( 'show_in_create_screen' => true ), 'objects' ) ): ?>

	<fieldset class="group-create-types">
		<legend><?php _e( 'Gruppentypen', 'social-portal' ); ?></legend>

		<p><?php _e( 'Wähle die Typen aus, zu denen diese Gruppe gehören soll.', 'social-portal' ); ?></p>

		<?php foreach ( $group_types as $type ) : ?>
			<div class="checkbox">
				<label for="<?php printf( 'group-type-%s', $type->name ); ?>">
					<input type="checkbox" name="group-types[]" id="<?php printf( 'group-type-%s', $type->name ); ?>" value="<?php echo esc_attr( $type->name ); ?>" <?php checked( bp_groups_has_group_type( bp_get_current_group_id(), $type->name ) ); ?>/> <?php echo esc_html( $type->labels['name'] ); ?>
					<?php
					if ( ! empty( $type->description ) ) {
						printf( __( '&ndash; %s', 'social-portal' ), '<span class="bp-group-type-desc">' . esc_html( $type->description ) . '</span>' );
					}
					?>
				</label>
			</div>
		<?php endforeach; ?>

	</fieldset>

<?php endif; ?>

<fieldset class="group-settings-invitations group-create-invitations">
	<legend><?php _e( 'Gruppeneinladung', 'social-portal' ); ?></legend>

	<p><?php _e( 'Welche Mitglieder dieser Gruppe dürfen andere einladen?', 'social-portal' ); ?></p>

	<div class="radio">
		<label for="group-invite-status-members"><input type="radio" name="group-invite-status" id="group-invite-status-members" value="members"<?php bp_group_show_invite_status_setting( 'members' ); ?> /> <?php _e( 'Alle Gruppenmitglieder', 'social-portal' ); ?></label>
		<label for="group-invite-status-mods"><input type="radio" name="group-invite-status" id="group-invite-status-mods" value="mods"<?php bp_group_show_invite_status_setting( 'mods' ); ?> /> <?php _e( 'Nur Gruppenadministratoren und Mods', 'social-portal' ); ?></label>
		<label for="group-invite-status-admins"><input type="radio" name="group-invite-status" id="group-invite-status-admins" value="admins"<?php bp_group_show_invite_status_setting( 'admins' ); ?> /> <?php _e( 'Nur Gruppenadministratoren', 'social-portal' ); ?></label>
	</div>

</fieldset>

<?php

/**
 * Fires after the group settings admin display.
 *
 */
do_action( 'bp_after_group_settings_admin' ); ?>

<p><input type="submit" value="<?php esc_attr_e( 'Änderungen speichern', 'social-portal' ); ?>" id="save" name="save" /></p>
<?php wp_nonce_field( 'groups_edit_group_settings' ); ?>
