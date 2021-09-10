<?php

/**
 * BuddyPress - Users Friends
 * User Profile-> Friends
 */
?>
<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>
		<?php if ( bp_is_my_profile() ) bp_get_options_nav(); ?>

		<?php if ( !bp_is_current_action( 'requests' ) ) : ?>

			<li id="members-order-select" class="last filter">

				<label for="members-friends"><?php _e( 'Sortieren nach:', 'social-portal' ); ?></label>
				<select id="members-friends">
					<option value="active"><?php _e( 'Zuletzt aktiv', 'social-portal' ); ?></option>
					<option value="newest"><?php _e( 'Newest Registered', 'social-portal' ); ?></option>
					<option value="alphabetical"><?php _e( 'Alphabetisch', 'social-portal' ); ?></option>

					<?php

					/**
					 * Fires inside the members friends order options select input.
					 *
					 */
					do_action( 'bp_member_friends_order_options' );
					?>

				</select>
			</li>

		<?php endif; ?>

	</ul>
</div>

<?php
switch ( bp_current_action() ) :

	// Home/My Friends
	case 'my-friends' :
	case 'pending' :
	case 'declined':
		/**
		 * Fires before the display of member friends content.
		 *
		 */
		do_action( 'bp_before_member_friends_content' );
		?>

		<div class="members friends">
			<?php bp_get_template_part( 'members/members-loop' ) ?>
		</div><!-- .members.friends -->

		<?php

		/**
		 * Fires after the display of member friends content.
		 *
		 */
		do_action( 'bp_after_member_friends_content' );
		break;

	case 'requests' :
		bp_get_template_part( 'members/single/friends/requests' );
		break;

	// Any other
	default :
		$temp_template = bp_locate_template( array( 'members/single/plugins.php' ), false );
		$temp_template = apply_filters( 'cb_friends_default_located_template', $temp_template );
		require( $temp_template );

		unset( $temp_template );//no traces left
		break;
endswitch;
