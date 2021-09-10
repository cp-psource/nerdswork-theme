<?php

/**
 * Topics Loop - Single
 *
 */

?>

<ul id="psf-topic-<?php psf_topic_id(); ?>" <?php psf_topic_class(); ?>>

	<li class="psf-topic-title">

		<?php if ( psf_is_user_home() ) : ?>

			<?php if ( psf_is_favorites() ) : ?>

				<span class="psf-row-actions">

					<?php do_action( 'psf_theme_before_topic_favorites_action' ); ?>

					<?php psf_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'psf_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( psf_is_subscriptions() ) : ?>

				<span class="psf-row-actions">

					<?php do_action( 'psf_theme_before_topic_subscription_action' ); ?>

					<?php psf_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'psf_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'psf_theme_before_topic_title' ); ?>

		<a class="psf-topic-permalink" href="<?php psf_topic_permalink(); ?>"><?php psf_topic_title(); ?></a>

		<?php do_action( 'psf_theme_after_topic_title' ); ?>

		<?php psf_topic_pagination(); ?>

		<?php do_action( 'psf_theme_before_topic_meta' ); ?>

		<p class="psf-topic-meta">

			<?php do_action( 'psf_theme_before_topic_started_by' ); ?>

			<span class="psf-topic-started-by"><?php printf( __( '%1$s', 'social-portal' ), psf_get_topic_author_link( array( 'size' => '25' ) ) ); ?></span>

			<?php do_action( 'psf_theme_after_topic_started_by' ); ?>

			<?php if ( !psf_is_single_forum() || ( psf_get_topic_forum_id() !== psf_get_forum_id() ) ) : ?>

				<?php do_action( 'psf_theme_before_topic_started_in' ); ?>

				<span class="psf-topic-started-in"><?php printf( __( 'in: <a href="%1$s">%2$s</a>', 'social-portal' ), psf_get_forum_permalink( psf_get_topic_forum_id() ), psf_get_forum_title( psf_get_topic_forum_id() ) ); ?></span>

				<?php do_action( 'psf_theme_after_topic_started_in' ); ?>

			<?php endif; ?>

		</p>

		<?php do_action( 'psf_theme_after_topic_meta' ); ?>

		<?php psf_topic_row_actions(); ?>

	</li>

	<li class="psf-topic-voice-count"><?php cb_psf_topic_voice_count(); ?></li>

	<li class="psf-topic-reply-count"><?php psf_show_lead_topic() ? cb_psf_topic_reply_count() : cb_psf_topic_post_count(); ?></li>

	<li class="psf-topic-freshness">

		<?php do_action( 'psf_theme_before_topic_freshness_link' ); ?>

		<?php psf_topic_freshness_link(); ?>

		<?php do_action( 'psf_theme_after_topic_freshness_link' ); ?>

		<p class="psf-topic-meta">

			<?php do_action( 'psf_theme_before_topic_freshness_author' ); ?>

			<span class="psf-topic-freshness-author"><?php psf_author_link( array( 'post_id' => psf_get_topic_last_active_id(), 'size' => 14 ) ); ?></span>

			<?php do_action( 'psf_theme_after_topic_freshness_author' ); ?>

		</p>
	</li>

</ul><!-- #psf-topic-<?php psf_topic_id(); ?> -->
