<?php
// Exit if the file is accessed directly over web
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * MediaPress - Activity Stream (Single Item like media, gallery or inside the lightbox)
 *
 */

?>

<?php do_action( 'psmt_before_activity_entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">

	<div class="psmt-activity-avatar">
		<a href="<?php bp_activity_user_link(); ?>">
			<?php bp_activity_avatar(); ?>
		</a>
	</div>

	<div class="psmt-activity-content">

		<div class="psmt-activity-header">
			<?php bp_activity_action(); ?>
		</div>

		<?php if ( bp_activity_has_content() ) : ?>
			<div class="psmt-activity-inner">
				<?php bp_activity_content_body(); ?>
			</div>
		<?php endif; ?>

		<?php

		/**
		 * Fires after the display of an activity entry content.
		 *
		 *
		 */
		do_action( 'psmt_activity_entry_content' ); ?>

		<div class="psmt-activity-meta">

			<?php if ( bp_get_activity_type() == 'activity_comment' ) : ?>
				<a href="<?php bp_activity_thread_permalink(); ?>" class="button view psmt-bp-secondary-action"
				   title="<?php esc_attr_e( 'Zeige das Gespräch', 'social-portal' ); ?>"><?php _e( 'Zeige das Gespräch', 'social-portal' ); ?></a>
			<?php endif; ?>

			<?php if ( is_user_logged_in() ) : ?>

				<?php if ( bp_activity_can_comment() ) : ?>
					<a href="<?php bp_activity_comment_link(); ?>" class="button psmt-acomment-reply psmt-bp-primary-action" id="psmt-acomment-comment-<?php bp_activity_id(); ?>">
						<?php printf( __( 'Kommentar <span>%s</span>', 'social-portal' ), bp_activity_get_comment_count() ); ?>
					</a>
				<?php endif; ?>

				<?php if ( bp_activity_can_favorite() ) : ?>
					<?php if ( ! bp_get_activity_is_favorite() ) : ?>
						<a href="<?php bp_activity_favorite_link(); ?>" class="button fav psmt-bp-secondary-action" title="<?php esc_attr_e( 'Als Favorit markieren', 'social-portal' ); ?>"><?php _e( 'Favorit', 'social-portal' ); ?></a>
					<?php else : ?>
						<a href="<?php bp_activity_unfavorite_link(); ?>" class="button unfav psmt-bp-secondary-action" title="<?php esc_attr_e( 'Favorit entfernen', 'social-portal' ); ?>"><?php _e( 'Favorit entfernen', 'social-portal' ); ?></a>
					<?php endif; ?>

				<?php endif; ?>

				<?php
					if ( bp_activity_user_can_delete() ) {
						bp_activity_delete_link();
					}
				?>

				<?php do_action( 'psmt_activity_entry_meta' ); ?>
			<?php endif; ?>

		</div>

	</div>

	<?php

	do_action( 'psmt_before_activity_entry_comments' ); ?>

	<?php if ( ( bp_activity_get_comment_count() || bp_activity_can_comment() ) || bp_is_single_activity() ) : ?>

		<div class="psmt-activity-comments">

			<?php psmt_activity_comments(); ?>

			<?php if ( is_user_logged_in() && bp_activity_can_comment() ) : ?>

				<form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="psmt-ac-form-<?php bp_activity_id(); ?>" class="psmt-ac-form"<?php bp_activity_comment_form_nojs_display(); ?>>
					<div class="psmt-ac-reply-avatar"><?php bp_loggedin_user_avatar( 'width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT ); ?></div>
					<div class="psmt-ac-reply-content">
						<div class="psmt-ac-textarea">
							<label for="psmt-ac-input-<?php bp_activity_id(); ?>" class="screen-reader-text"><?php _e( 'Kommentar', 'social-portal' ); ?></label>
							<textarea id="psmt-ac-input-<?php bp_activity_id(); ?>" class="psmt-ac-input bp-suggestions" name="psmt_ac_input_<?php bp_activity_id(); ?>"></textarea>
						</div>
						<input type="submit" class="btn-secondary" name="psmt_ac_form_submit" value="<?php esc_attr_e( 'Beitrag', 'social-portal' ); ?>"/> &nbsp; <a href="#" class=" btn-secondary psmt-ac-reply-cancel"><?php _e( 'Abbrechen', 'social-portal' ); ?></a>
						<input type="hidden" name="psmt_comment_form_id" value="<?php bp_activity_id(); ?>"/>
					</div>

					<?php

					/**
					 * Fires after the activity entry comment form.
					 *
					 *
					 */
					do_action( 'psmt_activity_entry_comments' ); ?>

					<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ); ?>

				</form>

			<?php endif; ?>
		</div>

	<?php endif; ?>

	<?php

	/**
	 * Fires after the display of the activity entry comments.
	 *
	 *
	 */
	do_action( 'psmt_after_activity_entry_comments' ); ?>
</li>

<?php

/**
 * Fires after the display of an activity entry.
 *
 *
 */
do_action( 'psmt_after_activity_entry' ); ?>
