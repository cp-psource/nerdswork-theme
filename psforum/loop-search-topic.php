<?php

/**
 * Search Loop - Single Topic
 *
 */

?>

<div class="psf-topic-header">

	<div class="psf-meta">

		<span class="psf-topic-post-date"><?php psf_topic_post_date( psf_get_topic_id() ); ?></span>

		<a href="<?php psf_topic_permalink(); ?>" class="psf-topic-permalink">#<?php psf_topic_id(); ?></a>

	</div><!-- .psf-meta -->

	<div class="psf-topic-title">

		<?php do_action( 'psf_theme_before_topic_title' ); ?>

		<h3><?php _e( 'Topic: ', 'social-portal' ); ?>
		<a href="<?php psf_topic_permalink(); ?>"><?php psf_topic_title(); ?></a></h3>

		<div class="psf-topic-title-meta">

			<?php if ( function_exists( 'psf_is_forum_group_forum' ) && psf_is_forum_group_forum( psf_get_topic_forum_id() ) ) : ?>

				<?php _e( 'in group forum ', 'social-portal' ); ?>

			<?php else : ?>

				<?php _e( 'in forum ', 'social-portal' ); ?>

			<?php endif; ?>

			<a href="<?php psf_forum_permalink( psf_get_topic_forum_id() ); ?>"><?php psf_forum_title( psf_get_topic_forum_id() ); ?></a>

		</div><!-- .psf-topic-title-meta -->

		<?php do_action( 'psf_theme_after_topic_title' ); ?>

	</div><!-- .psf-topic-title -->

</div><!-- .psf-topic-header -->

<div id="post-<?php psf_topic_id(); ?>" <?php psf_topic_class(); ?>>

	<div class="psf-topic-author">

		<?php do_action( 'psf_theme_before_topic_author_details' ); ?>

		<?php psf_topic_author_link( array( 'sep' => '<br />', 'show_role' => true ) ); ?>

		<?php if ( psf_is_user_keymaster() ) : ?>

			<?php do_action( 'psf_theme_before_topic_author_admin_details' ); ?>

			<div class="psf-reply-ip"><?php psf_author_ip( psf_get_topic_id() ); ?></div>

			<?php do_action( 'psf_theme_after_topic_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'psf_theme_after_topic_author_details' ); ?>

	</div><!-- .psf-topic-author -->

	<div class="psf-topic-content">

		<?php do_action( 'psf_theme_before_topic_content' ); ?>

		<?php psf_topic_content(); ?>

		<?php do_action( 'psf_theme_after_topic_content' ); ?>

	</div><!-- .psf-topic-content -->

</div><!-- #post-<?php psf_topic_id(); ?> -->
