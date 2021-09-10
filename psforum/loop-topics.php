<?php

/**
 * Topics Loop
 *
 */

?>

<?php do_action( 'psf_template_before_topics_loop' ); ?>

<ul id="psf-forum-<?php psf_forum_id(); ?>" class="psf-topics">

	<li class="psf-header">

		<ul class="forum-titles">
			<li class="psf-topic-title"><?php _e( 'Thema', 'social-portal' ); ?></li>
			<li class="psf-topic-voice-count"><?php _e( 'Stimmen', 'social-portal' ); ?></li>
			<li class="psf-topic-reply-count"><?php psf_show_lead_topic() ? _e( 'Replies', 'social-portal' ) : _e( 'Beiträge', 'social-portal' ); ?></li>
			<li class="psf-topic-freshness"><?php _e( 'Neueste', 'social-portal' ); ?></li>
		</ul>

	</li>

	<li class="psf-body">

		<?php while ( psf_topics() ) : psf_the_topic(); ?>

			<?php psf_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</li>

	<li class="psf-footer">

		<div class="tr">
			<p>
				
			</p>
		</div><!-- .tr -->

	</li>

</ul><!-- #psf-forum-<?php psf_forum_id(); ?> -->

<?php do_action( 'psf_template_after_topics_loop' ); ?>
