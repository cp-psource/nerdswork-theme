<?php

/**
 * Replies Loop - Single Reply
 *
 */
?>
<div class="psf-reply-item">
	<div id="post-<?php psf_reply_id(); ?>" class="psf-reply-header clearfix">
		<div class="psf-meta">

			<?php if ( psf_is_single_user_replies() ) : ?>
				<span class="psf-header">
					<?php _e( 'in reply to: ', 'social-portal' ); ?>
					<a class="psf-topic-permalink" href="<?php psf_topic_permalink( psf_get_reply_topic_id() ); ?>"><?php psf_topic_title( psf_get_reply_topic_id() ); ?></a>
				</span>
			<?php endif; ?>
			<a href="<?php psf_reply_url(); ?>" class="psf-reply-permalink">#<?php psf_reply_id(); ?></a>
		</div><!-- .psf-meta -->

	</div><!-- #post-<?php psf_reply_id(); ?> -->

	<div <?php psf_reply_class(); ?>>

		<div class="psf-reply-author">

			<?php do_action( 'psf_theme_before_reply_author_details' ); ?>

			<?php psf_reply_author_link( array( 'sep' => '<br />', 'show_role' => true ) ); ?>

			<?php if ( psf_is_user_keymaster() ) : ?>
				<?php do_action( 'psf_theme_before_reply_author_admin_details' ); ?>

				<div class="psf-reply-ip"><?php psf_author_ip( psf_get_reply_id() ); ?></div>

				<?php do_action( 'psf_theme_after_reply_author_admin_details' ); ?>
			<?php endif; ?>

			<?php do_action( 'psf_theme_after_reply_author_details' ); ?>

		</div><!-- .psf-reply-author -->

		<div class="psf-reply-content">

			<?php do_action( 'psf_theme_before_reply_content' ); ?>

			<?php psf_reply_content(); ?>

			<?php do_action( 'psf_theme_after_reply_content' ); ?>

		</div><!-- .psf-reply-content -->

	</div><!-- .reply -->
	<div class="psf-reply-footer clearfix">
		<span class="psf-reply-post-date"><?php psf_reply_post_date(); ?></span>
		<?php do_action( 'psf_theme_before_reply_admin_links' ); ?>

		<?php psf_reply_admin_links(); ?>

		<?php do_action( 'psf_theme_after_reply_admin_links' ); ?>
	</div><!-- end of psf reply footer -->
</div> <!-- ./psf-reply-item -->