<?php

/**
 * Split Topic
 *
 */

?>

<div id="psforum-forums">

	<?php if ( is_user_logged_in() && current_user_can( 'edit_topic', psf_get_topic_id() ) ) : ?>

		<div id="split-topic-<?php psf_topic_id(); ?>" class="psf-topic-split">

			<form id="split_topic" name="split_topic" method="post" action="<?php the_permalink(); ?>">

				<fieldset class="psf-form">

					<legend><?php printf( __( 'Split topic "%s"', 'social-portal' ), psf_get_topic_title() ); ?></legend>

					<div>

						<div class="psf-template-notice info">
							<p><?php _e( 'When you split a topic, you are slicing it in half starting with the reply you just selected. Choose to use that reply as a new topic with a new title, or merge those replies into an existing topic.', 'social-portal' ); ?></p>
						</div>

						<div class="psf-template-notice">
							<p><?php _e( 'If you use the existing topic option, replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted.', 'social-portal' ); ?></p>
						</div>

						<fieldset class="psf-form">
							<legend><?php _e( 'Split Method', 'social-portal' ); ?></legend>

							<div>
								<input name="psf_topic_split_option" id="psf_topic_split_option_reply" type="radio" checked="checked" value="reply" tabindex="<?php psf_tab_index(); ?>" />
								<label for="psf_topic_split_option_reply"><?php printf( __( 'New topic in <strong>%s</strong> titled:', 'social-portal' ), psf_get_forum_title( psf_get_topic_forum_id( psf_get_topic_id() ) ) ); ?></label>
								<input type="text" id="psf_topic_split_destination_title" value="<?php printf( __( 'Split: %s', 'social-portal' ), psf_get_topic_title() ); ?>" tabindex="<?php psf_tab_index(); ?>" size="35" name="psf_topic_split_destination_title" />
							</div>

							<?php if ( psf_has_topics( array( 'show_stickies' => false, 'post_parent' => psf_get_topic_forum_id( psf_get_topic_id() ), 'post__not_in' => array( psf_get_topic_id() ) ) ) ) : ?>

								<div>
									<input name="psf_topic_split_option" id="psf_topic_split_option_existing" type="radio" value="existing" tabindex="<?php psf_tab_index(); ?>" />
									<label for="psf_topic_split_option_existing"><?php _e( 'Use an existing topic in this forum:', 'social-portal' ); ?></label>

									<?php
										psf_dropdown( array(
											'post_type'   => psf_get_topic_post_type(),
											'post_parent' => psf_get_topic_forum_id( psf_get_topic_id() ),
											'selected'    => -1,
											'exclude'     => psf_get_topic_id(),
											'select_id'   => 'psf_destination_topic'
										) );
									?>

								</div>

							<?php endif; ?>

						</fieldset>

						<fieldset class="psf-form">
							<legend><?php _e( 'Topic Extras', 'social-portal' ); ?></legend>

							<div>

								<?php if ( psf_is_subscriptions_active() ) : ?>

									<input name="psf_topic_subscribers" id="psf_topic_subscribers" type="checkbox" value="1" checked="checked" tabindex="<?php psf_tab_index(); ?>" />
									<label for="psf_topic_subscribers"><?php _e( 'Copy subscribers to the new topic', 'social-portal' ); ?></label><br />

								<?php endif; ?>

								<input name="psf_topic_favoriters" id="psf_topic_favoriters" type="checkbox" value="1" checked="checked" tabindex="<?php psf_tab_index(); ?>" />
								<label for="psf_topic_favoriters"><?php _e( 'Copy favoriters to the new topic', 'social-portal' ); ?></label><br />

								<?php if ( psf_allow_topic_tags() ) : ?>

									<input name="psf_topic_tags" id="psf_topic_tags" type="checkbox" value="1" checked="checked" tabindex="<?php psf_tab_index(); ?>" />
									<label for="psf_topic_tags"><?php _e( 'Copy topic tags to the new topic', 'social-portal' ); ?></label><br />

								<?php endif; ?>

							</div>
						</fieldset>

						<div class="psf-template-notice error">
							<p><?php _e( '<strong>WARNING:</strong> This process cannot be undone.', 'social-portal' ); ?></p>
						</div>

						<div class="psf-submit-wrapper">
							<button type="submit" tabindex="<?php psf_tab_index(); ?>" id="psf_merge_topic_submit" name="psf_merge_topic_submit" class="submit"><?php _e( 'Submit', 'social-portal' ); ?></button>
						</div>
					</div>

					<?php psf_split_topic_form_fields(); ?>

				</fieldset>
			</form>
		</div>

	<?php else : ?>

		<div id="no-topic-<?php psf_topic_id(); ?>" class="psf-no-topic">
			<div class="entry-content"><?php is_user_logged_in() ? _e( 'You do not have the permissions to edit this topic!', 'social-portal' ) : _e( 'You cannot edit this topic.', 'social-portal' ); ?></div>
		</div>

	<?php endif; ?>

</div>
