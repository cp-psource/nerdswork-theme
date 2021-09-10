<?php

/**
 * Edit Topic Tag
 *
 */

?>

<?php if ( current_user_can( 'edit_topic_tags' ) ) : ?>

	<div id="edit-topic-tag-<?php psf_topic_tag_id(); ?>" class="psf-topic-tag-form">

		<fieldset class="psf-form" id="psf-edit-topic-tag">

			<legend><?php printf( __( 'Manage Tag: "%s"', 'social-portal' ), psf_get_topic_tag_name() ); ?></legend>

			<fieldset class="psf-form" id="tag-rename">

				<legend><?php _e( 'Rename', 'social-portal' ); ?></legend>

				<div class="psf-template-notice info">
					<p><?php _e( 'Leave the slug empty to have one automatically generated.', 'social-portal' ); ?></p>
				</div>

				<div class="psf-template-notice">
					<p><?php _e( 'Changing the slug affects its permalink. Any links to the old slug will stop working.', 'social-portal' ); ?></p>
				</div>

				<form id="rename_tag" name="rename_tag" method="post" action="<?php the_permalink(); ?>">

					<div>
						<label for="tag-name"><?php _e( 'Name:', 'social-portal' ); ?></label>
						<input type="text" id="tag-name" name="tag-name" size="20" maxlength="40" tabindex="<?php psf_tab_index(); ?>" value="<?php echo esc_attr( psf_get_topic_tag_name() ); ?>" />
					</div>

					<div>
						<label for="tag-slug"><?php _e( 'Slug:', 'social-portal' ); ?></label>
						<input type="text" id="tag-slug" name="tag-slug" size="20" maxlength="40" tabindex="<?php psf_tab_index(); ?>" value="<?php echo esc_attr( apply_filters( 'editable_slug', psf_get_topic_tag_slug() ) ); ?>" />
					</div>

					<div class="psf-submit-wrapper">
						<button type="submit" tabindex="<?php psf_tab_index(); ?>" class="submit"><?php esc_attr_e( 'Update', 'social-portal' ); ?></button>

						<input type="hidden" name="tag-id" value="<?php psf_topic_tag_id(); ?>" />
						<input type="hidden" name="action" value="psf-update-topic-tag" />

						<?php wp_nonce_field( 'update-tag_' . psf_get_topic_tag_id() ); ?>

					</div>
				</form>

			</fieldset>

			<fieldset class="psf-form" id="tag-merge">

				<legend><?php _e( 'Merge', 'social-portal' ); ?></legend>

				<div class="psf-template-notice">
					<p><?php _e( 'Merging tags together cannot be undone.', 'social-portal' ); ?></p>
				</div>

				<form id="merge_tag" name="merge_tag" method="post" action="<?php the_permalink(); ?>">

					<div>
						<label for="tag-existing-name"><?php _e( 'Existing tag:', 'social-portal' ); ?></label>
						<input type="text" id="tag-existing-name" name="tag-existing-name" size="22" tabindex="<?php psf_tab_index(); ?>" maxlength="40" />
					</div>

					<div class="psf-submit-wrapper">
						<button type="submit" tabindex="<?php psf_tab_index(); ?>" class="submit" onclick="return confirm('<?php echo esc_js( sprintf( __( 'Are you sure you want to merge the "%s" tag into the tag you specified?', 'social-portal' ), psf_get_topic_tag_name() ) ); ?>');"><?php esc_attr_e( 'Merge', 'social-portal' ); ?></button>

						<input type="hidden" name="tag-id" value="<?php psf_topic_tag_id(); ?>" />
						<input type="hidden" name="action" value="psf-merge-topic-tag" />

						<?php wp_nonce_field( 'merge-tag_' . psf_get_topic_tag_id() ); ?>
					</div>
				</form>

			</fieldset>

			<?php if ( current_user_can( 'delete_topic_tags' ) ) : ?>

				<fieldset class="psf-form" id="delete-tag">

					<legend><?php _e( 'Delete', 'social-portal' ); ?></legend>

					<div class="psf-template-notice info">
						<p><?php _e( 'This does not delete your topics. Only the tag itself is deleted.', 'social-portal' ); ?></p>
					</div>
					<div class="psf-template-notice">
						<p><?php _e( 'Deleting a tag cannot be undone.', 'social-portal' ); ?></p>
						<p><?php _e( 'Any links to this tag will no longer function.', 'social-portal' ); ?></p>
					</div>

					<form id="delete_tag" name="delete_tag" method="post" action="<?php the_permalink(); ?>">

						<div class="psf-submit-wrapper">
							<button type="submit" tabindex="<?php psf_tab_index(); ?>" class="submit" onclick="return confirm('<?php echo esc_js( sprintf( __( 'Are you sure you want to delete the "%s" tag? This is permanent and cannot be undone.', 'social-portal' ), psf_get_topic_tag_name() ) ); ?>');"><?php esc_attr_e( 'Delete', 'social-portal' ); ?></button>

							<input type="hidden" name="tag-id" value="<?php psf_topic_tag_id(); ?>" />
							<input type="hidden" name="action" value="psf-delete-topic-tag" />

							<?php wp_nonce_field( 'delete-tag_' . psf_get_topic_tag_id() ); ?>
						</div>
					</form>

				</fieldset>

			<?php endif; ?>

		</fieldset>
	</div>

<?php endif; ?>
