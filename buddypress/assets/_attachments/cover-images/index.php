<?php
/**
 * BuddyPress Cover Images main template.
 *
 * This template is used to inject the BuddyPress Backbone views
 * dealing with cover images.
 *
 * It's also used to create the common Backbone views.
 *
 */

?>

<div class="bp-cover-image"></div>
<div class="bp-cover-image-status"></div>
<div class="bp-cover-image-manage"></div>

<?php bp_attachments_get_template_part( 'uploader' ); ?>

<script id="tmpl-bp-cover-image-delete" type="text/html">
	<# if ( 'user' === data.object ) { #>
		<p class="cover-info"><?php _e( "Wenn Du Dein aktuelles Titelbild löschen möchtest, aber kein neues hochladen möchtest, klicke auf die Schaltfläche Titelbild löschen.", 'social-portal' ); ?></p>
		<p><a class="button btn-danger edit" id="bp-delete-cover-image" href="#" title="<?php esc_attr_e( 'Titelbild löschen', 'social-portal' ); ?>"><?php esc_html_e( 'Mein Titelbild löschen', 'social-portal' ); ?></a></p>
	<# } else if ( 'group' === data.object ) { #>
		<p class="cover-info"><?php _e( "Wenn Du das vorhandene Gruppen-Titelbild entfernen, aber kein neues hochladen möchtest, klicke auf die Schaltfläche Gruppen-Titelbild löschen.", 'social-portal' ); ?></p>
		<p><a class="button btn-danger edit " id="bp-delete-cover-image" href="#" title="<?php esc_attr_e( 'Titelbild löschen', 'social-portal' ); ?>"><?php esc_html_e( 'Delete Group Cover Image', 'social-portal' ); ?></a></p>
	<# } else { #>
		<?php do_action( 'bp_attachments_cover_image_delete_template' ); ?>
	<# } #>
</script>

<?php do_action( 'bp_attachments_cover_image_main_template' ); ?>
