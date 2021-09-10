<?php

/**
 * Search Loop - Single Forum
 *
 */

?>

<div class="psf-forum-header">

	<div class="psf-meta">

		<span class="psf-forum-post-date"><?php printf( __( 'Last updated %s', 'social-portal' ), psf_get_forum_last_active_time() ); ?></span>

		<a href="<?php psf_forum_permalink(); ?>" class="psf-forum-permalink">#<?php psf_forum_id(); ?></a>

	</div><!-- .psf-meta -->

	<div class="psf-forum-title">

		<?php do_action( 'psf_theme_before_forum_title' ); ?>

		<h3><?php _e( 'Forum: ', 'social-portal' ); ?><a href="<?php psf_forum_permalink(); ?>"><?php psf_forum_title(); ?></a></h3>

		<?php do_action( 'psf_theme_after_forum_title' ); ?>

	</div><!-- .psf-forum-title -->

</div><!-- .psf-forum-header -->

<div id="post-<?php psf_forum_id(); ?>" <?php psf_forum_class(); ?>>

	<div class="psf-forum-content clearfix">

		<?php do_action( 'psf_theme_before_forum_content' ); ?>

		<?php psf_forum_content(); ?>

		<?php do_action( 'psf_theme_after_forum_content' ); ?>

	</div><!-- .psf-forum-content -->

</div><!-- #post-<?php psf_forum_id(); ?> -->
