<?php

/**
 * BuddyPress - Users Activity
 * User Profile->Activity
 */
?>
<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>

		<?php bp_get_options_nav(); ?>

		<li id="activity-filter-select" class="last">
			<label for="activity-filter-by"><?php _e( 'Zeige:', 'social-portal' ); ?></label>
			<select id="activity-filter-by">
				<option value="-1"><?php _e( '&mdash; Alles &mdash;', 'social-portal' ); ?></option>

				<?php bp_activity_show_filters(); ?>

				<?php

				/**
				 * Fires inside the select input for member activity filter options.
				 *
				 */
				do_action( 'bp_member_activity_filter_options' );
				?>

			</select>
		</li>

	</ul>
</div><!-- .item-list-tabs -->

<?php

/**
 * Fires before the display of the member activity post form.
 *
 */
do_action( 'bp_before_member_activity_post_form' );
?>

<?php
if ( is_user_logged_in() && bp_is_my_profile() && ( !bp_current_action() || bp_is_current_action( 'just-me' ) ) ) :
	bp_get_template_part( 'activity/post-form' );
endif;

/**
 * Fires after the display of the member activity post form.
 *
 */
do_action( 'bp_after_member_activity_post_form' );

/**
 * Fires before the display of the member activities list.
 *
 */
do_action( 'bp_before_member_activity_content' );
?>

<div class="activity">
	<?php bp_get_template_part( 'activity/activity-loop' ) ?>
</div><!-- .activity -->

<?php

/**
 * Fires after the display of the member activities list.
 *
 */
do_action( 'bp_after_member_activity_content' );