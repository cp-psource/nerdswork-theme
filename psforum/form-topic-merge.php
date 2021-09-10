<?php

/**
 * Merge Topic
 *
 */

?>

<div id="psforum-forums">
	<?php if ( is_user_logged_in() && current_user_can( 'edit_topic', psf_get_topic_id() ) ) : ?>

		<div id="merge-topic-<?php psf_topic_id(); ?>" class="psf-topic-merge">

			<form id="merge_topic" name="merge_topic" method="post" action="<?php the_permalink(); ?>">

				<fieldset class="psf-form">

					<legend><?php printf( __( 'Merge topic "%s"', 'social-portal' ), psf_get_topic_title() ); ?></legend>

					<div>

						<div class="psf-template-notice info">
							<p><?php _e( 'Select the topic to merge this one into. The destination topic will remain the lead topic, and this one will change into a reply.', 'social-portal' ); ?></p>
							<p><?php _e( 'To keep this topic as the lead, go to the other topic and use the merge tool from there instead.', 'social-portal' ); ?></p>
						</div>

						<div class="psf-template-notice">
							<p><?php _e( 'All replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted. If the destination topic was created after this one, it\'s post date will be updated to second earlier than this one.', 'social-portal' ); ?></p>
						</div>

						<fieldset class="psf-form">
							<legend><?php _e( 'Destination', 'social-portal' ); ?></legend>
							<div>
								<?php if ( psf_has_topics( array( 'show_stickies' => false, 'post_parent' => psf_get_topic_forum_id( psf_get_topic_id() ), 'post__not_in' => array( psf_get_topic_id() ) ) ) ) : ?>

									<label for="psf_destination_topic"><?php _e( 'Merge with this topic:', 'social-portal' ); ?></label>

									<?php
										psf_dropdown( array(
											'post_type'   => psf_get_topic_post_type(),
											'post_parent' => psf_get_topic_forum_id( psf_get_topic_id() ),
											'selected'    => -1,
											'exclude'     => psf_get_topic_id(),
											'select_id'   => 'psf_destination_topic'
										) );
									?>

								<?php else : ?>

									<label><?php _e( 'There are no other topics in this forum to merge with.', 'social-portal' ); ?></label>

								<?php endif; ?>

							</div>
						</fieldset>

						<fieldset class="psf-form">
							<legend><?php _e( 'Topic Extras', 'social-portal' ); ?></legend>

							<div>

								<?php if ( psf_is_subscriptions_active() ) : ?>

									<input name="psf_topic_subscribers" id="psf_topic_subscribers" type="checkbox" value="1" checked="checked" tabindex="<?php psf_tab_index(); ?>" />
									<label for="psf_topic_subscribers"><?php _e( 'Merge topic subscribers', 'social-portal' ); ?></label><br />

								<?php endif; ?>

								<input name="psf_topic_favoriters" id="psf_topic_favoriters" type="checkbox" value="1" checked="checked" tabindex="<?php psf_tab_index(); ?>" />
								<label for="psf_topic_favoriters"><?php _e( 'Merge topic favoriters', 'social-portal' ); ?></label><br />

								<?php if ( psf_allow_topic_tags() ) : ?>

									<input name="psf_topic_tags" id="psf_topic_tags" type="checkbox" value="1" checked="checked" tabindex="<?php psf_tab_index(); ?>" />
									<label for="psf_topic_tags"><?php _e( 'Merge topic tags', 'social-portal' ); ?></label><br />

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

					<?php psf_merge_topic_form_fields(); ?>

				</fieldset>
			</form>
		</div>

	<?php else : ?>

		<div id="no-topic-<?php psf_topic_id(); ?>" class="psf-no-topic">
			<div class="entry-content"><?php is_user_logged_in() ? _e( 'You do not have the permissions to edit this topic!', 'social-portal' ) : _e( 'You cannot edit this topic.', 'social-portal' ); ?></div>
		</div>

	<?php endif; ?>

</div>
