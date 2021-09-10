<?php

/**
 * Move Reply
 *
 */

?>

<div id="psforum-forums">

	<?php if ( is_user_logged_in() && current_user_can( 'edit_topic', psf_get_topic_id() ) ) : ?>

		<div id="move-reply-<?php psf_topic_id(); ?>" class="psf-reply-move">

			<form id="move_reply" name="move_reply" method="post" action="<?php the_permalink(); ?>">

				<fieldset class="psf-form">

					<legend><?php printf( __( 'Move reply "%s"', 'social-portal' ), psf_get_reply_title() ); ?></legend>

					<div>

						<div class="psf-template-notice info">
							<p><?php _e( 'You can either make this reply a new topic with a new title, or merge it into an existing topic.', 'social-portal' ); ?></p>
						</div>

						<div class="psf-template-notice">
							<p><?php _e( 'If you choose an existing topic, replies will be ordered by the time and date they were created.', 'social-portal' ); ?></p>
						</div>

						<fieldset class="psf-form">
							<legend><?php _e( 'Move Method', 'social-portal' ); ?></legend>

							<div>
								<input name="psf_reply_move_option" id="psf_reply_move_option_reply" type="radio" checked="checked" value="topic" tabindex="<?php psf_tab_index(); ?>" />
								<label for="psf_reply_move_option_reply"><?php printf( __( 'New topic in <strong>%s</strong> titled:', 'social-portal' ), psf_get_forum_title( psf_get_reply_forum_id( psf_get_reply_id() ) ) ); ?></label>
								<input type="text" id="psf_reply_move_destination_title" value="<?php printf( __( 'Moved: %s', 'social-portal' ), psf_get_reply_title() ); ?>" tabindex="<?php psf_tab_index(); ?>" size="35" name="psf_reply_move_destination_title" />
							</div>

							<?php if ( psf_has_topics( array( 'show_stickies' => false, 'post_parent' => psf_get_reply_forum_id( psf_get_reply_id() ), 'post__not_in' => array( psf_get_reply_topic_id( psf_get_reply_id() ) ) ) ) ) : ?>

								<div>
									<input name="psf_reply_move_option" id="psf_reply_move_option_existing" type="radio" value="existing" tabindex="<?php psf_tab_index(); ?>" />
									<label for="psf_reply_move_option_existing"><?php _e( 'Use an existing topic in this forum:', 'social-portal' ); ?></label>

									<?php
										psf_dropdown( array(
											'post_type'   => psf_get_topic_post_type(),
											'post_parent' => psf_get_reply_forum_id( psf_get_reply_id() ),
											'selected'    => -1,
											'exclude'     => psf_get_reply_topic_id( psf_get_reply_id() ),
											'select_id'   => 'psf_destination_topic'
										) );
									?>

								</div>

							<?php endif; ?>

						</fieldset>

						<div class="psf-template-notice error">
							<p><?php _e( '<strong>WARNING:</strong> This process cannot be undone.', 'social-portal' ); ?></p>
						</div>

						<div class="psf-submit-wrapper">
							<button type="submit" tabindex="<?php psf_tab_index(); ?>" id="psf_move_reply_submit" name="psf_move_reply_submit" class="submit"><?php _e( 'Submit', 'social-portal' ); ?></button>
						</div>
					</div>

					<?php psf_move_reply_form_fields(); ?>

				</fieldset>
			</form>
		</div>

	<?php else : ?>

		<div id="no-reply-<?php psf_reply_id(); ?>" class="psf-no-reply">
			<div class="entry-content"><?php is_user_logged_in() ? _e( 'You do not have the permissions to edit this reply!', 'social-portal' ) : _e( 'You cannot edit this reply.', 'social-portal' ); ?></div>
		</div>

	<?php endif; ?>

</div>
