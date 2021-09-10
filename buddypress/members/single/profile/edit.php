<?php
/**
 * User Edit Profie
 */
?>
<?php 
/**
 * Fires after the display of member profile edit content.
 */
do_action( 'bp_before_profile_edit_content' );
?>
<?php if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) : ?>

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

		<form action="<?php bp_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form" class="standard-form form-stacked <?php bp_the_profile_group_slug(); ?>">

			<?php
			/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
			do_action( 'bp_before_profile_field_content' );
			?>

			<?php if ( bp_profile_has_multiple_groups() ) : ?>

				<ul class="button-nav clearfix">
					<?php bp_profile_group_tabs(); ?>
				</ul>

			<?php endif; ?>

			<div class="clear"></div>
			
			<h4 class="profile-editing-title"><?php printf( __( "Bearbeite '%s'", "social-portal" ), bp_get_the_profile_group_name() ); ?></h4>
			
			<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

				<div<?php bp_field_css_class( 'editfield' ); ?>>

					<?php
					$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
					$field_type->edit_field_html();

					/**
					 * Fires before the display of visibility options for the field.
					 */
					do_action( 'bp_custom_profile_edit_fields_pre_visibility' );
					?>

					<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
					
						<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
							<?php printf( __( 'Dieses Feld kann gesehen werden von: <span class="current-visibility-level">%s</span>', 'social-portal' ), bp_get_the_profile_field_visibility_level_label() ) ?> <a href="#" class="visibility-toggle-link" title="<?php _e( 'Change', 'social-portal' ); ?>"><i class="fa fa-cog"></i> </a>
						</p>

						<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">

							<fieldset>
								<legend><?php _e( 'Wer kann dieses Feld sehen?', 'social-portal' ) ?><a class="field-visibility-settings-close" href="#" title="<?php _e( 'Schließen', 'social-portal' ) ?>"><i class="fa fa-times-circle"></i></a></legend>
								<?php bp_profile_visibility_radio_buttons() ?>
							</fieldset>

						</div>
						
					<?php else : ?>
						
						<div class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
							<?php printf( __( 'Dieses Feld kann gesehen werden von: <span class="current-visibility-level">%s</span>', 'social-portal' ), bp_get_the_profile_field_visibility_level_label() ) ?>
						</div>
						
					<?php endif ?>

					<?php
					/**
					 * Fires after the visibility options for a field.
					 */
					do_action( 'bp_custom_profile_edit_fields' );
					?>

				</div>

			<?php endwhile; ?>

			<?php
				/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
				do_action( 'bp_after_profile_field_content' );
			?>

			<div class="submit">
				<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php esc_attr_e( 'Änderungen speichern', 'social-portal' ); ?> " />
			</div>

			<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

			<?php wp_nonce_field( 'bp_xprofile_edit' ); ?>

		</form>

	<?php endwhile; ?>
<?php endif; ?>

<?php
/**
 * Fires after the display of member profile edit content.
 *
 */
do_action( 'bp_after_profile_edit_content' );
