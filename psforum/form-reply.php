<?php

/**
 * New/Edit Reply
 *
 */

?>

<?php if ( psf_is_reply_edit() ) : ?>

<div id="psforum-forums">
<?php endif; ?>

<?php if ( psf_current_user_can_access_create_reply_form() ) : ?>

	<div id="new-reply-<?php psf_topic_id(); ?>" class="psf-reply-form">

		<form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>">

			<?php do_action( 'psf_theme_before_reply_form' ); ?>

			<fieldset class="psf-form">
				<legend><?php printf( __( 'Antwort an: %s', 'social-portal' ), psf_get_topic_title() ); ?></legend>

				<?php do_action( 'psf_theme_before_reply_form_notices' ); ?>

				<?php if ( !psf_is_topic_open() && !psf_is_reply_edit() ) : ?>

					<div class="psf-template-notice">
						<p><?php _e( 'Dieses Thema ist für neue Antworten als geschlossen markiert. Deine Posting-Funktionen ermöglichen dies jedoch weiterhin.', 'social-portal' ); ?></p>
					</div>

				<?php endif; ?>

				<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>

					<div class="psf-template-notice">
						<p><?php _e( 'Dein Konto kann uneingeschränkten HTML-Inhalt veröffentlichen.', 'social-portal' ); ?></p>
					</div>

				<?php endif; ?>

				<?php do_action( 'psf_template_notices' ); ?>

				<div>

					<?php psf_get_template_part( 'form', 'anonymous' ); ?>

					<?php do_action( 'psf_theme_before_reply_form_content' ); ?>

					<?php psf_the_content( array( 'context' => 'reply' , 'textarea_rows'=> 5 ) ); ?>

					<?php do_action( 'psf_theme_after_reply_form_content' ); ?>

					<?php if ( ! ( psf_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>

						<p class="form-allowed-tags">
							<label><?php _e( 'Du kannst diese <abbr title="HyperText Markup Language">HTML</abbr> -Tags und -Attribute verwenden:','social-portal' ); ?></label><br />
							<code><?php psf_allowed_tags(); ?></code>
						</p>

					<?php endif; ?>
					
					<?php if ( psf_allow_topic_tags() && current_user_can( 'assign_topic_tags' ) ) : ?>

						<?php do_action( 'psf_theme_before_reply_form_tags' ); ?>

						<p>
							<label for="psf_topic_tags"><?php _e( 'Tags:', 'social-portal' ); ?></label><br />
							<input type="text" value="<?php psf_form_topic_tags(); ?>" tabindex="<?php psf_tab_index(); ?>" size="40" name="psf_topic_tags" id="psf_topic_tags" <?php disabled( psf_is_topic_spam() ); ?> />
						</p>

						<?php do_action( 'psf_theme_after_reply_form_tags' ); ?>

					<?php endif; ?>

					<?php if ( psf_is_subscriptions_active() && !psf_is_anonymous() && ( !psf_is_reply_edit() || ( psf_is_reply_edit() && !psf_is_reply_anonymous() ) ) ) : ?>

						<?php do_action( 'psf_theme_before_reply_form_subscription' ); ?>

						<p>

							<input name="psf_topic_subscription" id="psf_topic_subscription" type="checkbox" value="psf_subscribe"<?php psf_form_topic_subscribed(); ?> tabindex="<?php psf_tab_index(); ?>" />

							<?php if ( psf_is_reply_edit() && ( psf_get_reply_author_id() !== psf_get_current_user_id() ) ) : ?>

								<label for="psf_topic_subscription"><?php _e( 'Benachrichtige den Autor über Folgeantworten per E-Mail', 'social-portal' ); ?></label>

							<?php else : ?>

								<label for="psf_topic_subscription"><?php _e( 'Benachrichtige mich über weitere Antworten per E-Mail', 'social-portal' ); ?></label>

							<?php endif; ?>

						</p>

						<?php do_action( 'psf_theme_after_reply_form_subscription' ); ?>

					<?php endif; ?>

					<?php if ( psf_allow_revisions() && psf_is_reply_edit() ) : ?>

						<?php do_action( 'psf_theme_before_reply_form_revisions' ); ?>

						<fieldset class="psf-form">
							<legend>
								<input name="psf_log_reply_edit" id="psf_log_reply_edit" type="checkbox" value="1" <?php psf_form_reply_log_edit(); ?> tabindex="<?php psf_tab_index(); ?>" />
								<label for="psf_log_reply_edit"><?php _e( 'Führe ein Protokoll dieser Bearbeitung:', 'social-portal' ); ?></label><br />
							</legend>

							<div>
								<label for="psf_reply_edit_reason"><?php printf( __( 'Optionaler Grund für die Bearbeitung:', 'social-portal' ), psf_get_current_user_name() ); ?></label><br />
								<input type="text" value="<?php psf_form_reply_edit_reason(); ?>" tabindex="<?php psf_tab_index(); ?>" size="40" name="psf_reply_edit_reason" id="psf_reply_edit_reason" />
							</div>
						</fieldset>

						<?php do_action( 'psf_theme_after_reply_form_revisions' ); ?>

					<?php endif; ?>

					<?php do_action( 'psf_theme_before_reply_form_submit_wrapper' ); ?>

					<div class="psf-submit-wrapper">

						<?php do_action( 'psf_theme_before_reply_form_submit_button' ); ?>

						<?php psf_cancel_reply_to_link(); ?>

						<button type="submit" tabindex="<?php psf_tab_index(); ?>" id="psf_reply_submit" name="psf_reply_submit" class="submit"><?php _e( 'Einreichen', 'social-portal' ); ?></button>

						<?php do_action( 'psf_theme_after_reply_form_submit_button' ); ?>

					</div>

					<?php do_action( 'psf_theme_after_reply_form_submit_wrapper' ); ?>

				</div>

				<?php psf_reply_form_fields(); ?>

			</fieldset>

			<?php do_action( 'psf_theme_after_reply_form' ); ?>

		</form>
	</div>

<?php elseif ( psf_is_topic_closed() ) : ?>

	<div id="no-reply-<?php psf_topic_id(); ?>" class="psf-no-reply">
		<div class="psf-template-notice">
			<p><?php printf( __( 'Das Thema &#8216;%s&#8217; ist für neue Antworten geschlossen.', 'social-portal' ), psf_get_topic_title() ); ?></p>
		</div>
	</div>

<?php elseif ( psf_is_forum_closed( psf_get_topic_forum_id() ) ) : ?>

	<div id="no-reply-<?php psf_topic_id(); ?>" class="psf-no-reply">
		<div class="psf-template-notice">
			<p><?php printf( __( 'Das Forum &#8216;%s&#8217; ist für neue Themen und Antworten geschlossen.', 'social-portal' ), psf_get_forum_title( psf_get_topic_forum_id() ) ); ?></p>
		</div>
	</div>

<?php else : ?>

	<div id="no-reply-<?php psf_topic_id(); ?>" class="psf-no-reply">
		<div class="psf-template-notice">
			<p><?php is_user_logged_in() ? _e( 'Du kannst auf dieses Thema nicht antworten.', 'social-portal' ) : _e( 'Du musst angemeldet sein, um auf dieses Thema antworten zu können.', 'social-portal' ); ?></p>
		</div>
	</div>

<?php endif; ?>

<?php if ( psf_is_reply_edit() ) : ?>
</div>
<?php endif; ?>
