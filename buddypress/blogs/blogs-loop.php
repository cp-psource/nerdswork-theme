<?php
/**
 * BuddyPress - Blogs Loop
 *
 * Query string is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 */

/**
 * Fires before the start of the blogs loop.
 *
 */
do_action( 'bp_before_blogs_loop' ); ?>

<?php if ( bp_has_blogs( bp_ajax_querystring( 'blogs' ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="blog-dir-count-top">
			<?php bp_blogs_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="blog-dir-pag-top">
			<?php bp_blogs_pagination_links(); ?>
		</div>

	</div>

	<?php

	/**
	 * Fires before the blogs directory list.
	 *
	 */
	do_action( 'bp_before_directory_blogs_list' ); ?>

	<?php bp_get_template_part( 'blogs/blogs-list' );?>

	<?php

	/**
	 * Fires after the blogs directory list.
	 *
	 */
	do_action( 'bp_after_directory_blogs_list' ); ?>

	<?php bp_blog_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="blog-dir-count-bottom">
			<?php bp_blogs_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="blog-dir-pag-bottom">
			<?php bp_blogs_pagination_links(); ?>
		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Es wurden leider keine Webseiten gefunden.', 'social-portal' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the blogs loop.
 *
 */
do_action( 'bp_after_blogs_loop' ); ?>