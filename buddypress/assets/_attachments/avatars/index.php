<?php
/**
 * BuddyPress Avatars main template
 *
 * This template is used to inject the BuddyPress Backbone views
 * dealing with avatars.
 * It's also used to create the common Backbone views
 *
 */


/**
 * This action is for internal use, please do not use it
 */
do_action( 'bp_attachments_avatar_check_template' );
?>
<div class="bp-avatar-nav"></div>
<div class="bp-avatar"></div>
<div class="bp-avatar-status"></div>

<script type="text/html" id="tmpl-bp-avatar-nav">
	<a href="{{data.href}}" class="bp-avatar-nav-item" data-nav="{{data.id}}">{{data.name}}</a>
</script>

<?php bp_attachments_get_template_part( 'uploader' ); ?>

<?php bp_attachments_get_template_part( 'avatars/crop' ); ?>

<?php bp_attachments_get_template_part( 'avatars/camera' ); ?>

<script id="tmpl-bp-avatar-delete" type="text/html">
	<# if ( 'user' === data.object ) { #>
		<p><?php _e( "Wenn Du Dein aktuelles Profilfoto löschen möchtest, aber kein neues hochladen möchtest, klicke auf die Schaltfläche Profilfoto löschen.", 'social-portal' ); ?></p>
		<p><a class="button edit" id="bp-delete-avatar" href="#" title="<?php esc_attr_e( 'Profilfoto löschen', 'social-portal' ); ?>"><?php esc_html_e( 'Mein Profilfoto löschen', 'social-portal' ); ?></a></p>
	<# } else if ( 'group' === data.object ) { #>
		<p><?php _e( "Wenn Du das vorhandene Gruppenprofilfoto entfernen, aber kein neues hochladen möchtest, klicke auf die Schaltfläche Gruppenprofilfoto löschen.", 'social-portal' ); ?></p>
		<p><a class="button edit" id="bp-delete-avatar" href="#" title="<?php esc_attr_e( 'Gruppenprofilfoto löschen', 'social-portal' ); ?>"><?php esc_html_e( 'Gruppenprofilfoto löschen', 'social-portal' ); ?></a></p>
	<# } else { #>
		<?php do_action( 'bp_attachments_avatar_delete_template' ); ?>
	<# } #>
</script>

<?php do_action( 'bp_attachments_avatar_main_template' ); ?>
