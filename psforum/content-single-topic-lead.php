<?php

/**
 * Single Topic Lead Content Part
 *
 */

?>

<?php do_action( 'psf_template_before_lead_topic' ); ?>

<ul id="psf-topic-<?php psf_topic_id(); ?>-lead" class="psf-lead-topic">

	<li class="psf-header">

		<div class="psf-topic-author"><?php  _e( 'Creator',  'social-portal' ); ?></div><!-- .psf-topic-author -->

		<div class="psf-topic-content">

			<?php _e( 'Topic', 'social-portal' ); ?>

			<?php psf_topic_subscription_link(); ?>

			<?php psf_topic_favorite_link(); ?>

		</div><!-- .psf-topic-content -->

	</li><!-- .psf-header -->

	<li class="psf-body">

		<div class="psf-topic-header">

			<div class="psf-meta">

				<span class="psf-topic-post-date"><?php psf_topic_post_date(); ?></span>

				<a href="<?php psf_topic_permalink(); ?>" class="psf-topic-permalink">#<?php psf_topic_id(); ?></a>

				<?php do_action( 'psf_theme_before_topic_admin_links' ); ?>

				<?php psf_topic_admin_links(); ?>

				<?php do_action( 'psf_theme_after_topic_admin_links' ); ?>

			</div><!-- .psf-meta -->

		</div><!-- .psf-topic-header -->

		<div id="post-<?php psf_topic_id(); ?>" <?php psf_topic_class(); ?>>

			<div class="psf-topic-author">

				<?php do_action( 'psf_theme_before_topic_author_details' ); ?>

				<?php psf_topic_author_link( array( 'sep' => '<br />', 'show_role' => true ) ); ?>

				<?php if ( psf_is_user_keymaster() ) : ?>
					<?php do_action( 'psf_theme_before_topic_author_admin_details' ); ?>

					<div class="psf-topic-ip"><?php psf_author_ip( psf_get_topic_id() ); ?></div>

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

	</li><!-- .psf-body -->

	<li class="psf-footer">

		<div class="psf-topic-author"><?php  _e( 'Creator',  'social-portal' ); ?></div>

		<div class="psf-topic-content">
			<?php _e( 'Topic', 'social-portal' ); ?>
		</div><!-- .psf-topic-content -->

	</li>

</ul><!-- #psf-topic-<?php psf_topic_id(); ?>-lead -->

<?php do_action( 'psf_template_after_lead_topic' ); ?>
