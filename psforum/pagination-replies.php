<?php

/**
 * Pagination for pages of replies (when viewing a topic)
 *
 */

?>

<?php do_action( 'psf_template_before_pagination_loop' ); ?>

<div class="pagination">
	<div class="pag-count">

		<?php psf_topic_pagination_count(); ?>

	</div>

	<div class="pagination-links">

		<?php psf_topic_pagination_links(); ?>

	</div>
</div>

<?php do_action( 'psf_template_after_pagination_loop' ); ?>
