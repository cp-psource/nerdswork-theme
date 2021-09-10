<?php

/**
 * BuddyPress - Users Groups
 * User Profile-> Groups
 */

?>
<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>
		<?php if ( bp_is_my_profile() ) bp_get_options_nav(); ?>

		<?php if ( !bp_is_current_action( 'invites' ) ) : ?>

			<li id="groups-order-select" class="last filter">

				<label for="groups-order-by"><?php _e( 'Sortieren nach:', 'social-portal' ); ?></label>
				<select id="groups-order-by">
					<option value="active"><?php _e( 'Letzte Aktivität', 'social-portal' ); ?></option>
					<option value="popular"><?php _e( 'Meisten Mitglieder', 'social-portal' ); ?></option>
					<option value="newest"><?php _e( 'Neu erstellt', 'social-portal' ); ?></option>
					<option value="alphabetical"><?php _e( 'Alphabetisch', 'social-portal' ); ?></option>

					<?php

					/**
					 * Fires inside the members group order options select input.
					 *
					 */
					do_action( 'bp_member_group_order_options' );
					?>

				</select>
			</li>

		<?php endif; ?>

	</ul>
</div><!-- .item-list-tabs -->

<?php

switch ( bp_current_action() ) :

	// Home/My Groups
	case 'my-groups' :

		/**
		 * Fires before the display of member groups content.
		 *
		 */
		do_action( 'bp_before_member_groups_content' ); ?>

		<div class="groups mygroups">

			<?php bp_get_template_part( 'groups/groups-loop' ); ?>

		</div>

		<?php

		/**
		 * Fires after the display of member groups content.
		 *
		 */
		do_action( 'bp_after_member_groups_content' );
		break;

	// Group Invitations
	case 'invites' :
		bp_get_template_part( 'members/single/groups/invites' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
