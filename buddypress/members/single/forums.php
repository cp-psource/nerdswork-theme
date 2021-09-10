<?php

/**
 * BuddyPress - Users Forums
 * User Profile-> Forums
 */

?>
<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>
		<?php bp_get_options_nav(); ?>

		<li id="forums-order-select" class="last filter">

			<label for="forums-order-by"><?php _e( 'Sortieren nach:', 'social-portal' ); ?></label>
			<select id="forums-order-by">
				<option value="active"><?php _e( 'Zuletzt aktiv', 'social-portal' ); ?></option>
				<option value="popular"><?php _e( 'Meisten Beiträge', 'social-portal' ); ?></option>
				<option value="unreplied"><?php _e( 'Unbeantwortet', 'social-portal' ); ?></option>

				<?php

				/**
				 * Fires inside the members forums order options select input.
				 *
				 */
				do_action( 'bp_forums_directory_order_options' ); ?>

			</select>
		</li>
	</ul>
</div><!-- .item-list-tabs -->

<?php

if ( bp_is_current_action( 'favorites' ) ) :
	bp_get_template_part( 'members/single/forums/topics' );

else :

	/**
	 * Fires before the display of member forums content.
	 *
	 */
	do_action( 'bp_before_member_forums_content' );
	?>

	<div class="forums myforums">
		<?php bp_get_template_part( 'forums/forums-loop' ) ?>
	</div>

	<?php

	/**
	 * Fires after the display of member forums content.
	 *
	 */
	do_action( 'bp_after_member_forums_content' );
	?>

<?php endif; ?>
