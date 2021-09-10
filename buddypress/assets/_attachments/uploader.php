<?php
/**
 * BuddyPress Uploader templates
 *
 * This template is used to create the BuddyPress Uploader Backbone views
 *
 */
?>
<script type="text/html" id="tmpl-upload-window">
	<?php if ( ! _device_can_upload() ) : ?>
		<h3 class="upload-instructions"><?php esc_html_e( 'Der Webbrowser auf Deinem Gerät kann nicht zum Hochladen von Dateien verwendet werden.', 'social-portal' ); ?></h3>
	<?php elseif ( is_multisite() && ! is_upload_space_available() ) : ?>
		<h3 class="upload-instructions"><?php esc_html_e( 'Upload-Limit überschritten', 'social-portal' ); ?></h3>
	<?php else : ?>
		<div id="{{data.container}}">
			<div id="{{data.drop_element}}">
				<div class="drag-drop-inside">
					<p class="drag-drop-info"><?php esc_html_e( 'Lege Deine Datei hier ab', 'social-portal' ); ?></p>
					<p><?php _ex( 'oder', 'Uploader: Lege Deine Datei hier ab - oder - Wähle eine Datei aus', 'social-portal' ); ?></p>
					<p class="drag-drop-buttons">
						<label for="{{data.browse_button}}" class="<?php echo is_admin() ? 'screen-reader-text' : 'bp-screen-reader-text' ;?>">
							<?php
							/* translators: accessibility text */
							esc_html_e( 'Wähle eine Datei aus', 'social-portal' );
							?>
						</label><input id="{{data.browse_button}}" type="button" value="<?php esc_attr_e( 'Wähle eine Datei aus', 'social-portal' ); ?>" class="button" /></p>
				</div>
			</div>
		</div>
	<?php endif; ?>
</script>

<script type="text/html" id="tmpl-progress-window">
	<div id="{{data.id}}">
		<div class="bp-progress">
			<div class="bp-bar"></div>
		</div>
		<div class="filename">{{data.filename}}</div>
	</div>
</script>
