<?php
/**
 * @package social-portal
 *
 */

/**
 * Fires at the top of the groups creation template file.
 *
 */
do_action( 'bp_before_create_group_page' ); ?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of group creation content.
	 */
	do_action( 'bp_before_create_group_content_template' ); ?>

	<form action="<?php bp_group_creation_form_action(); ?>" method="post" id="create-group-form" class="standard-form group-setup-form" enctype="multipart/form-data">

		<?php

		/**
		 * Fires before the display of group creation.
		 *
		 */
		do_action( 'bp_before_create_group' );
		?>

		<div class="item-list-tabs no-ajax " id="group-create-tabs">
			<ul class="btn-nav">
				<?php bp_group_creation_tabs(); ?>
			</ul>
		</div>

		<div class="item-body <?php echo bp_groups_current_create_step();?>" id="group-create-body">

			<?php /* Group creation step 1: Basic group details */ ?>
			<?php if ( bp_is_group_creation_step( 'group-details' ) ) : ?>

				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					_e( 'Group Details', 'social-portal' );
					?></h2>
				<?php

				/**
				 * Fires before the display of the group details creation step.
				 *
				 */
				do_action( 'bp_before_group_details_creation_step' );
				?>

				<div class="group-name-row">
					<label for="group-name"><?php _e( 'Gruppenname (erforderlich)', 'social-portal' ); ?></label>
					<input type="text" name="group-name" id="group-name" aria-required="true" value="<?php bp_new_group_name(); ?>" />
				</div>

				<div class="group-desc-row">
					<label for="group-desc"><?php _e( 'Gruppenbeschreibung (erforderlich)', 'social-portal' ); ?></label>
					<textarea name="group-desc" id="group-desc" aria-required="true"><?php bp_new_group_description(); ?></textarea>
				</div>

				<?php

				/**
				 * Fires after the display of the group details creation step.
				 *
				 */
				do_action( 'bp_after_group_details_creation_step' );

				wp_nonce_field( 'groups_create_save_group-details' );
				?>

			<?php endif; ?>

			<?php /* Group creation step 2: Group settings */ ?>
			<?php if ( bp_is_group_creation_step( 'group-settings' ) ) : ?>

				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					_e( 'Gruppeneinstellungen', 'social-portal' );
					?></h2>

				<?php

				/**
				 * Fires before the display of the group settings creation step.
				 *
				 */
				do_action( 'bp_before_group_settings_creation_step' ); ?>
				<fieldset class="group-settings-privacy group-create-privacy">
					<legend><?php _e( 'Privatsphäre-Einstellungen', 'social-portal' ); ?></legend>

					<div class="radio">
						<label for="group-status-public"><input type="radio" name="group-status" id="group-status-public" value="public"<?php if ( 'public' == bp_get_new_group_status() || !bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> /> <strong><?php _e( 'Dies ist eine öffentliche Gruppe', 'social-portal' ); ?></strong></label>
						<ul id="public-group-description">
							<li><?php _e( 'Jedes Seiten-Mitglied kann dieser Gruppe beitreten.', 'social-portal' ); ?></li>
							<li><?php _e( 'Diese Gruppe wird im Gruppenverzeichnis und in den Suchergebnissen aufgeführt.', 'social-portal' ); ?></li>
							<li><?php _e( 'Gruppeninhalt und -aktivität sind für jedes Seiten-Mitglied sichtbar.', 'social-portal' ); ?></li>
						</ul>


						<label for="group-status-private">
							<input type="radio" name="group-status" id="group-status-private" value="private"<?php if ( 'private' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> />
							<strong><?php _e( 'Dies ist eine private Gruppe', 'social-portal' ); ?></strong>
						</label>
						<ul id="private-group-description">
							<li><?php _e( 'Nur Benutzer, die eine Mitgliedschaft beantragen und akzeptiert werden, können der Gruppe beitreten.', 'social-portal' ); ?></li>
							<li><?php _e( 'Diese Gruppe wird im Gruppenverzeichnis und in den Suchergebnissen aufgeführt.', 'social-portal' ); ?></li>
							<li><?php _e( 'Gruppeninhalt und -aktivität sind nur für Mitglieder der Gruppe sichtbar.', 'social-portal' ); ?></li>
						</ul>


						<label for="group-status-hidden">
							<input type="radio" name="group-status" id="group-status-hidden" value="hidden"<?php if ( 'hidden' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> />
							<strong><?php _e('Dies ist eine versteckte Gruppe', 'social-portal' ); ?></strong>
						</label>
						<ul id="hidden-group-description">
							<li><?php _e( 'Nur eingeladene Benutzer können der Gruppe beitreten.', 'social-portal' ); ?></li>
							<li><?php _e( 'Diese Gruppe wird nicht im Gruppenverzeichnis oder in den Suchergebnissen aufgeführt.', 'social-portal' ); ?></li>
							<li><?php _e( 'Gruppeninhalt und -aktivität sind nur für Mitglieder der Gruppe sichtbar.', 'social-portal' ); ?></li>
						</ul>

					</div>
				</fieldset>

				<?php // Group type selection ?>
				<?php if (  function_exists( 'bp_groups_get_group_types' ) && $group_types = bp_groups_get_group_types( array( 'show_in_create_screen' => true ), 'objects' ) ): ?>

					<fieldset class="group-create-types">
						<legend><?php _e( 'Gruppentypen', 'social-portal' ); ?></legend>

						<p><?php _e( 'Wähle die Typen aus, zu denen diese Gruppe gehören soll.', 'social-portal' ); ?></p>

						<?php foreach ( $group_types as $type ) : ?>
							<div class="checkbox">
								<label for="<?php printf( 'group-type-%s', $type->name ); ?>"><input type="checkbox" name="group-types[]" id="<?php printf( 'group-type-%s', $type->name ); ?>" value="<?php echo esc_attr( $type->name ); ?>" <?php checked( true, ! empty( $type->create_screen_checked ) ); ?> /> <?php echo esc_html( $type->labels['name'] ); ?>
									<?php
									if ( ! empty( $type->description ) ) {
										/* translators: Group type description shown when creating a group. */
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
						<label>
							<input type="radio" name="group-invite-status" value="members"<?php bp_group_show_invite_status_setting( 'members' ); ?> />
							<strong><?php _e( 'Alle Gruppenmitglieder', 'social-portal' ); ?></strong>
						</label>

						<label>
							<input type="radio" name="group-invite-status" value="mods"<?php bp_group_show_invite_status_setting( 'mods' ); ?> />
							<strong><?php _e( 'Nur Gruppenadministratoren und Mods', 'social-portal' ); ?></strong>
						</label>

						<label>
							<input type="radio" name="group-invite-status" value="admins"<?php bp_group_show_invite_status_setting( 'admins' ); ?> />
							<strong><?php _e( 'Nur Gruppenadministratoren', 'social-portal' ); ?></strong>
						</label>
					</div>
				</fieldset>

				<?php if ( bp_is_active( 'forums' ) ) : ?>

					<h4><?php _e( 'Gruppenforum', 'social-portal' ); ?></h4>

					<?php if ( bp_forums_is_installed_correctly() ) : ?>

						<p><?php _e( 'Soll diese Gruppe ein Forum haben?', 'social-portal' ); ?></p>

						<div class="checkbox">
							<label><input type="checkbox" name="group-show-forum" id="group-show-forum" value="1"<?php checked( bp_get_new_group_enable_forum(), true, true ); ?> /> <?php _e( 'Diskussionsforum aktivieren', 'social-portal' ); ?></label>
						</div>
					<?php elseif ( is_super_admin() ) : ?>
						<p><?php printf( __( '<strong>Achtung Seiten Admin:</strong> Gruppenforen erfordern die <a href="%s">korrekte Einrichtung und Konfiguration</a> einer PSForum-Installation.', 'social-portal' ), bp_core_do_network_admin() ? network_admin_url( 'settings.php?page=bb-forums-setup' ) :  admin_url( 'admin.php?page=bb-forums-setup' ) ); ?></p>
					<?php endif; ?>

				<?php endif; ?>

				<?php

				/**
				 * Fires after the display of the group settings creation step.
				 *
				 */
				do_action( 'bp_after_group_settings_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-settings' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 3: Avatar Uploads */ ?>
			<?php if ( bp_is_group_creation_step( 'group-avatar' ) ) : ?>

				<?php

				/**
				 * Fires before the display of the group avatar creation step.
				 *
				 */
				do_action( 'bp_before_group_avatar_creation_step' ); ?>

				<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

					<div class="left-menu">

						<?php bp_new_group_avatar(); ?>

					</div><!-- .left-menu -->

					<div class="main-column">
						<p><?php _e( "Lade ein Bild hoch, das Du als Profilfoto für diese Gruppe verwenden möchtest. Das Bild wird auf der Hauptgruppenseite und in den Suchergebnissen angezeigt.", 'social-portal' ); ?></p>

						<p>
							<input type="file" name="file" id="file" />
							<input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Bild hochladen', 'social-portal' ); ?>" />
							<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
						</p>

						<p><?php _e( 'Klicke auf die Schaltfläche "Nächster Schritt", um das Hochladen von Gruppenprofilfotos zu überspringen.', 'social-portal' ); ?></p>
					</div><!-- .main-column -->

					<?php
					/**
					 * Load the Avatar UI templates
					 *
					 */
					bp_avatar_get_templates(); ?>

				<?php endif; ?>

				<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

					<h4><?php _e( 'Gruppenprofilbild zuschneiden', 'social-portal' ); ?></h4>

					<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Profilfoto zum Zuschneiden', 'social-portal' ); ?>" />

					<div id="avatar-crop-pane">
						<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Profilfotovorschau', 'social-portal' ); ?>" />
					</div>

					<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e( 'Bild zuschneiden', 'social-portal' ); ?>" />

					<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
					<input type="hidden" name="upload" id="upload" />
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />

				<?php endif; ?>

				<?php

				/**
				 * Fires after the display of the group avatar creation step.
				 *
				 */
				do_action( 'bp_after_group_avatar_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-avatar' ); ?>

			<?php endif; ?>
            <?php /* Group creation step 4: Cover image */ ?>
            <?php if ( bp_is_group_creation_step( 'group-cover-image' ) ) : ?>
	            <h2 class="bp-screen-reader-text"><?php
		            /* translators: accessibility text */
		            _e( 'Cover Image', 'social-portal' );
		            ?></h2>
                <?php

                /**
                 * Fires before the display of the group cover image creation step.
                 */
                do_action( 'bp_before_group_cover_image_creation_step' ); ?>

                <div id="header-cover-image"></div>

                <p><?php _e( 'Das Titelbild wird verwendet, um die Kopfzeile Deiner Gruppe anzupassen.', 'social-portal' ); ?></p>

                <?php bp_attachments_get_template_part( 'cover-images/index' ); ?>

                <?php

                /**
                 * Fires after the display of the group cover image creation step.
                 */
                do_action( 'bp_after_group_cover_image_creation_step' ); ?>

                <?php wp_nonce_field( 'groups_create_save_group-cover-image' ); ?>

            <?php endif; ?>

			<?php /* Group creation step 5: Invite friends to group */ ?>
			<?php if ( bp_is_group_creation_step( 'group-invites' ) ) : ?>

				<?php

				/**
				 * Fires before the display of the group invites creation step.
				 *
				 */
				do_action( 'bp_before_group_invites_creation_step' ); ?>

				<?php if ( bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

                    <div class="invite clearfix">
                        <?php bp_get_template_part( 'groups/single/invites-loop' ); ?>
                    </div>

				<?php else : ?>

					<div id="message" class="info">
						<p><?php _e( 'Sobald Du Freundschaftsverbindungen aufgebaut hast, kannst Du andere zu Deiner Gruppe einladen.', 'social-portal' ); ?></p>
					</div>

				<?php endif; ?>

				<?php wp_nonce_field( 'groups_create_save_group-invites' ); ?>

				<?php

				/**
				 * Fires after the display of the group invites creation step.
				 *
				 */
				do_action( 'bp_after_group_invites_creation_step' ); ?>

			<?php endif; ?>

			<?php

			/**
			 * Fires inside the group admin template.
			 *
			 * Allows plugins to add custom group creation steps.
			 *
			 */
			do_action( 'groups_custom_create_steps' ); ?>

			<?php

			/**
			 * Fires before the display of the group creation step buttons.
			 *
			 */
			do_action( 'bp_before_group_creation_step_buttons' ); ?>

			<?php if ( 'crop-image' != bp_get_avatar_admin_step() ) : ?>

				<div class="submit" id="previous-next">

					<?php /* Previous Button */ ?>
                    <?php if ( ! bp_is_first_group_creation_step() ) : ?>

                        <input class="btn" type="button" value="<?php esc_attr_e( 'Zurück zum vorherigen Schritt', 'social-portal' ); ?>" id="group-creation-previous" name="previous" onclick="location.href='<?php bp_group_creation_previous_link(); ?>'" />

                    <?php endif; ?>

					<?php /* Next Button */ ?>
                    <?php if ( ! bp_is_last_group_creation_step() && ! bp_is_first_group_creation_step() ) : ?>

                        <input type="submit" value="<?php esc_attr_e( 'Nächster Schritt', 'social-portal' ); ?>" id="group-creation-next" name="save" />

                    <?php endif;?>

					<?php /* Create Button */ ?>
                    <?php if ( bp_is_first_group_creation_step() ) : ?>

                        <input type="submit" value="<?php esc_attr_e( 'Gruppe erstellen und fortfahren', 'social-portal' ); ?>" id="group-creation-create" name="save" />

                    <?php endif; ?>

					<?php /* Finish Button */ ?>

                    <?php if ( bp_is_last_group_creation_step() ) : ?>
                        <input type="submit" value="<?php esc_attr_e( 'Fertig', 'social-portal' ); ?>" id="group-creation-finish" name="save" />
                    <?php endif; ?>

				</div>

			<?php endif;?>

			<?php

			/**
			 * Fires after the display of the group creation step buttons.
			 *
			 */
			do_action( 'bp_after_group_creation_step_buttons' );
			?>

			<?php /* Don't leave out this hidden field */ ?>
			<input type="hidden" name="group_id" id="group_id" value="<?php bp_new_group_id(); ?>" />

			<?php

			/**
			 * Fires and displays the groups directory content.
			 */
			do_action( 'bp_directory_groups_content' );
			?>

		</div><!-- .item-body -->

		<?php

		/**
		 * Fires after the display of group creation.
		 *
		 */
		do_action( 'bp_after_create_group' ); ?>

	</form>

	<?php

	/**
	 * Fires after the display of group creation content.
	 *
	 */
	do_action( 'bp_after_create_group_content_template' );
	?>

</div>

<?php

/**
 * Fires at the bottom of the groups creation template file.
 *
 */
do_action( 'bp_after_create_group_page' );
