<?php
/**
 * @package social-portal
 * Single activity permalink page content
 */
?>
<div id="buddypress" class="bp-content-wrapper">
	<div class="activity no-ajax">
		<?php if ( bp_has_activities( 'display_comments=threaded&show_hidden=true&include=' . bp_current_action() ) ) : ?>

			<ul id="activity-stream" class="activity-list item-list">
				<?php while ( bp_activities() ) : bp_the_activity(); ?>
					<?php bp_get_template_part( 'activity/entry' ); ?>
				<?php endwhile; ?>
			</ul>

		<?php endif; ?>
	</div>
</div>
