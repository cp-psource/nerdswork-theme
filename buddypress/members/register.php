<?php
/**
 * BuddyPress - Register page
 */
?>
<div id="buddypress">
	<?php if ( 'completed-confirmation' !== bp_get_current_signup_step() ) : ?>
		<?php
			//Show content if it is not the signup complete page
			$page = get_post(  buddypress()->pages->register->id );
			$content = apply_filters( 'the_content', $page->post_content );
		?>
		<div class="entry-content bp-entry-content clearfix">
			<?php echo $content; ?>
		</div>
	<?php endif; ?>
	<?php

	/**
	 * Fires at the top of the BuddyPress member registration page template.
	 *
	 */
	do_action( 'bp_before_register_page' ); ?>

	<div id="register-page">

		<form action="" name="signup_form" id="signup_form" class="standard-form" method="post" enctype="multipart/form-data">

		<?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>

			<?php

			/**
			 * Fires before the display of the registration disabled message.
			 *
			 */
			do_action( 'bp_before_registration_disabled' );
			?>

			<p><?php _e( 'Nutzer Registrierung ist im Moment nicht erlaubt.', 'social-portal' ); ?></p>

			<?php

			/**
			 * Fires after the display of the registration disabled message.
			 *
			 */
			do_action( 'bp_after_registration_disabled' );
			?>
		<?php endif; // registration-disabled signup step ?>

		<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

			<?php

			/**
			 * Fires before the display of member registration account details fields.
			 *
			 */
			do_action( 'bp_before_account_details_fields' );
			?>

			<div class="register-section" id="basic-details-section">

				<?php /***** Basic Account Details ******/ ?>

				<h4><?php _e( 'Kontodetails', 'social-portal' ); ?></h4>

				<div class="editfield">
					<label for="signup_username"><?php _e( 'Benutzername', 'social-portal' ); ?> <?php _e( '(benötigt)', 'social-portal' ); ?></label>
					<?php

					/**
					 * Fires and displays any member registration username errors.
					 *
					 */
					do_action( 'bp_signup_username_errors' );
					?>
					<input type="text" name="signup_username" id="signup_username" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes( 'username' ); ?>/>
				</div>
				<div class="editfield">
					<label for="signup_email"><?php _e( 'Email Addresse', 'social-portal' ); ?> <?php _e( '(benötigt)', 'social-portal' ); ?></label>
					<?php

					/**
					 * Fires and displays any member registration email errors.
					 *
					 */
					do_action( 'bp_signup_email_errors' );
					?>
					<input type="email" name="signup_email" id="signup_email" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes( 'email' ); ?>/>
				</div>

				<div class="editfield">

					<label for="signup_password"><?php _e( 'Wähle ein Passwort', 'social-portal' ); ?> <?php _e( '(benötigt)', 'social-portal' ); ?></label>
					<?php

					/**
					 * Fires and displays any member registration password errors.
					 *
					 */
					do_action( 'bp_signup_password_errors' );
					?>
					<input type="password" name="signup_password" id="signup_password" value="" class="password-entry" <?php bp_form_field_attributes( 'password' ); ?>/>
					<div id="pass-strength-result"></div>

				</div>

				<div class="editfield">
					<label for="signup_password_confirm"><?php _e( 'Kennwort bestätigen', 'social-portal' ); ?> <?php _e( '(benötigt)', 'social-portal' ); ?></label>
					<?php

					/**
					 * Fires and displays any member registration password confirmation errors.
					 *
					 */
					do_action( 'bp_signup_password_confirm_errors' );
					?>
					<input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" class="password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/>
				</div>

				<?php

				/**
				 * Fires and displays any extra member registration details fields.
				 *
				 */
				do_action( 'bp_account_details_fields' );
				?>

			</div><!-- #basic-details-section -->

			<?php

			/**
			 * Fires after the display of member registration account details fields.
			 *
			 */
			do_action( 'bp_after_account_details_fields' ); ?>

			<?php /***** Extra Profile Details ******/ ?>

			<?php if ( bp_is_active( 'xprofile' ) ) : ?>

				<?php

				/**
				 * Fires before the display of member registration xprofile fields.
				 *
				 */
				do_action( 'bp_before_signup_profile_fields' ); ?>

				<div class="register-section" id="profile-details-section">

					<h4><?php _e( 'Profildetails', 'social-portal' ); ?></h4>
					<?php $fids = array();?>
					<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
					<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => cb_get_registration_groups(), 'fetch_field_data' => false, 'hide_empty_groups'=> false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
					
					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<div <?php bp_field_css_class( 'editfield' ); ?>>

							<?php
							$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
							$field_type->edit_field_html();

							/**
							 * Fires before the display of the visibility options for xprofile fields.
							 *
							 */
							do_action( 'bp_custom_profile_edit_fields_pre_visibility' );

							if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
								<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
									<?php
									printf(
										__( 'Dieses Feld kann gesehen werden von: %s', 'social-portal' ),
										'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
									);
									?>
									<a href="#" class="visibility-toggle-link" title="<?php _e( 'Schließen', 'social-portal' ) ?>"><i class="fa fa-cog"></i> </a>
								</p>

								<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">

									<fieldset>

										<legend><?php _e( 'Wer kann dieses Feld sehen?', 'social-portal' ) ?><a class="field-visibility-settings-close" href="#" title="<?php _e( 'Schließen', 'social-portal' ) ?>"><i class="fa fa-times-circle"></i></a></legend>
										<?php bp_profile_visibility_radio_buttons() ?>

									</fieldset>

								</div>
							<?php else : ?>
								<p class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
									<?php
									printf(
										__( 'Dieses Feld kann gesehen werden von: %s', 'social-portal' ),
										'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
									);
									?>
								</p>
							<?php endif ?>

							<?php

							/**
							 * Fires after the display of the visibility options for xprofile fields.
							 *
							 */
							do_action( 'bp_custom_profile_edit_fields' );
							?>

						</div>

					<?php endwhile; ?>
					
					<?php $fids[] = bp_get_the_profile_field_ids();?>
					
					<?php endwhile; endif; endif; ?>
					
					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php echo join( ',', $fids ); ?>" />

					<?php

					/**
					 * Fires and displays any extra member registration xprofile fields.
					 *
					 */
					do_action( 'bp_signup_profile_fields' );
					?>

				</div><!-- #profile-details-section -->

				<?php

				/**
				 * Fires after the display of member registration xprofile fields.
				 *
				 */
				do_action( 'bp_after_signup_profile_fields' ); ?>

			<?php endif; ?>

			<?php if ( bp_get_blog_signup_allowed() ) : ?>

				<?php

				/**
				 * Fires before the display of member registration blog details fields.
				 *
				 */
				do_action( 'bp_before_blog_details_fields' ); ?>

				<?php /***** Blog Creation Details ******/ ?>

				<div class="register-section" id="blog-details-section">

					<h4><?php _e( 'Blog-Details', 'social-portal' ); ?></h4>

					<p><label for="signup_with_blog"><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Ja, ich möchte eine neue Seite erstellen', 'social-portal' ); ?></label></p>

					<div id="blog-details"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?>class="show"<?php endif; ?>>

						<label for="signup_blog_url"><?php _e( 'Blog URL', 'social-portal' ); ?> <?php _e( '(benötigt)', 'social-portal' ); ?></label>
						<?php

						/**
						 * Fires and displays any member registration blog URL errors.
						 *
						 * 
						 */
						do_action( 'bp_signup_blog_url_errors' );
						?>

						<?php if ( is_subdomain_install() ) : ?>
							http:// <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" /> .<?php bp_signup_subdomain_base(); ?>
						<?php else : ?>
							<?php echo home_url( '/' ); ?> <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" />
						<?php endif; ?>

						<label for="signup_blog_title"><?php _e( 'Seitentitel', 'social-portal' ); ?> <?php _e( '(benötigt)', 'social-portal' ); ?></label>
						<?php

						/**
						 * Fires and displays any member registration blog title errors.
						 *
						 *
						 */
						do_action( 'bp_signup_blog_title_errors' ); ?>
						<input type="text" name="signup_blog_title" id="signup_blog_title" value="<?php bp_signup_blog_title_value(); ?>" />

						<span class="label"><?php _e( 'Ich möchte, dass meine Webseite in Suchmaschinen und in öffentlichen Listen in diesem Netzwerk angezeigt wird.', 'social-portal' ); ?></span>
						<?php

						/**
						 * Fires and displays any member registration blog privacy errors.
						 *
						 * 
						 */
						do_action( 'bp_signup_blog_privacy_errors' ); ?>

						<label for="signup_blog_privacy_public"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_public" value="public"<?php if ( 'public' == bp_get_signup_blog_privacy_value() || !bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Ja', 'social-portal' ); ?></label>
						<label for="signup_blog_privacy_private"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_private" value="private"<?php if ( 'private' == bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Nein', 'social-portal' ); ?></label>

						<?php

						/**
						 * Fires and displays any extra member registration blog details fields.
						 *
						 */
						do_action( 'bp_blog_details_fields' );
						?>

					</div>

				</div><!-- #blog-details-section -->

				<?php

				/**
				 * Fires after the display of member registration blog details fields.
				 *
				 */
				do_action( 'bp_after_blog_details_fields' ); ?>

			<?php endif; ?>

			<?php

			/**
			 * Fires before the display of the registration submit buttons.
			 */
			do_action( 'bp_before_registration_submit_buttons' ); ?>



			<div class="submit">
				<?php if ( bp_signup_requires_privacy_policy_acceptance() ) : ?>
                    <div class="editfield privacy-policy-accept">

						<?php do_action( 'bp_signup_privacy_policy_errors' ); ?>
                        <label for="signup-privacy-policy-accept">
                            <input type="hidden" name="signup-privacy-policy-check" value="1" />

							<?php /* translators: link to Privacy Policy */ ?>
                            <input type="checkbox" name="signup-privacy-policy-accept" id="signup-privacy-policy-accept" required /> <?php printf( esc_html__( 'Ich habe die %s gelesen und bin damit einverstanden.', 'social-portal' ), sprintf( '<a href="%s">%s</a>', esc_url( get_privacy_policy_url() ), esc_html__( 'Datenschutz-Bestimmungen', 'social-portal' ) ) ); ?>
                        </label>
                    </div>
				<?php endif; ?>
				<input type="submit" name="signup_submit" id="signup_submit" value="<?php esc_attr_e( 'Anmeldung abschließen', 'social-portal' ); ?>" />
			</div>

			<?php

			/**
			 * Fires after the display of the registration submit buttons.
			 */
			do_action( 'bp_after_registration_submit_buttons' ); ?>

			<?php wp_nonce_field( 'bp_new_signup' ); ?>

		<?php endif; // request-details signup step ?>

		<?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

			<?php

			/**
			 * Fires before the display of the registration confirmed messages.
			 *
			 */
			do_action( 'bp_before_registration_confirmed' ); ?>

			<?php if ( bp_registration_needs_activation() ) : ?>
				<p><?php _e( 'Du hast Dein Konto erfolgreich erstellt! Um diese Webseite nutzen zu können, musst Du Dein Konto über die E-Mail aktivieren, die wir gerade an Deine Adresse gesendet haben.', 'social-portal' ); ?></p>
			<?php else : ?>
				<p><?php _e( 'Du hast Dein Konto erfolgreich erstellt! Bitte melde Dich mit dem soeben erstellten Benutzernamen und Passwort an.', 'social-portal' ); ?></p>
			<?php endif; ?>

			<?php

			/**
			 * Fires after the display of the registration confirmed messages.
			 *
			 */
			do_action( 'bp_after_registration_confirmed' );
			?>

		<?php endif; // completed-confirmation signup step ?>

		<?php

		/**
		 * Fires and displays any custom signup steps.
	
		 */
		do_action( 'bp_custom_signup_steps' );
		?>

		</form>

	</div>

	<?php

	/**
	 * Fires at the bottom of the BuddyPress member registration page template.
	 *

	 */
	do_action( 'bp_after_register_page' );
	?>

</div><!-- #buddypress -->
