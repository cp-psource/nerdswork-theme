<?php

/**
 * Fires before the display of member friend requests content.
 *
 */
do_action( 'bp_before_member_friend_requests_content' );
?>

<?php if ( bp_has_members( 'type=alphabetical&include=' . bp_get_friendship_requests() ) ) : ?>

	<div id="pag-top" class="pagination no-ajax">

		<div class="pag-count" id="member-dir-count-top">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-dir-pag-top">
			<?php bp_members_pagination_links(); ?>
		</div>

	</div>

	<ul id="friend-list" class="item-list row <?php echo cb_bp_get_item_list_class(); ?>">
		<?php while ( bp_members() ) : bp_the_member(); ?>

			<li id="friendship-<?php bp_friend_friendship_id(); ?>" <?php bp_member_class( array( cb_bp_get_item_class( 'members' ) ) ); ?>>

				<div class='item-entry'>

					<div class="item-entry-header">

						<div class="item-avatar">
							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( cb_get_bp_list_avatar_args( 'requests' ) ); ?></a>
						</div>

						<!-- item actions -->
						<div class="action">
						<?php cb_friendship_action_buttons();?>
						</div><!-- end of action -->

					</div><!-- /.item-entry-header -->

					<div class="item ">

						<div class="item-title">

							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                        </div>
                        <div class="item-meta"><i class="fa fa-clock-o bn-icon-time"></i>
                            <span class="activity"><?php bp_member_last_active(); ?></span>
                        </div>


						<?php

						/**
						 * Fires inside the display of a directory member item.
						 *
						 */
						do_action( 'bp_friend_requests_item' );
						?>

						<?php
						/***
						 * If you want to show specific profile fields here you can,
						 * but it'll add an extra query for each member in the loop
						 * (only one regardless of the number of fields you show):
						 *
						 * bp_member_profile_data( 'field=the field name' );
						 */
						?>
					</div>


				</div><!-- /.item-entry -->


			</li>

		<?php endwhile; ?>
	</ul>

	<?php

	/**
	 * Fires and displays the member friend requests content.
	 *
	 */
	do_action( 'bp_friend_requests_content' ); ?>

	<div id="pag-bottom" class="pagination no-ajax">

		<div class="pag-count" id="member-dir-count-bottom">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'You have no pending friendship requests.', 'social-portal' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of member friend requests content.
 *
 */
do_action( 'bp_after_member_friend_requests_content' );
