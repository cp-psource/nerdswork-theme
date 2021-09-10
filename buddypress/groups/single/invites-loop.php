<?php
/**
 * BuddyPress - Group Invites Loop
 */
if ( bp_is_group_create() ) {
    $group_id = bp_get_new_group_id() ? bp_get_new_group_id() : absint( $_COOKIE['bp_new_group_id']  );
} else {
    $group_id = bp_get_current_group_id();
}

?>
<div class="left-menu">

	<div id="invite-list">

		<ul>
			<?php bp_new_group_invite_friend_list( array('group_id' => $group_id ) ); ?>
		</ul>

		<?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>

	</div>

</div><!-- .left-menu -->

<div class="main-column">

	<?php

	/**
	 * Fires before the display of the group send invites list.
	 *
	 */
	do_action( 'bp_before_group_send_invites_list' ); ?>

	<?php if ( bp_group_has_invites( bp_ajax_querystring( 'invite' ) . '&per_page=10&group_id=' . $group_id ) ) : ?>

		<div id="pag-top" class="pagination">

			<div class="pag-count" id="group-invite-count-top">
				<?php bp_group_invite_pagination_count(); ?>
			</div>

			<div class="pagination-links" id="group-invite-pag-top">
				<?php bp_group_invite_pagination_links(); ?>
			</div>

		</div>

		<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
		<ul id="friend-list" class="item-list group-invites-list row <?php echo cb_bp_get_item_list_class(); ?>">

		<?php while ( bp_group_invites() ) : bp_group_the_invite(); ?>

			<li id="<?php bp_group_invite_item_id(); ?>" <?php bp_member_class( array( cb_bp_get_item_class( 'members' ) ) ); ?>>
							
				<div class='item-entry'>

                    <div class="item-entry-header">

                        <div class="item-avatar">
                            <a href="<?php echo cb_get_group_invite_user_domain(); ?>"><?php echo cb_get_group_invite_user_avatar_mid(); ?></a>
                        </div>

                        <!-- item actions -->
                        <div class="action">
                            <?php cb_group_invite_action_buttons() ;?>
                        </div><!-- end of action -->

                    </div><!-- /.item-entry-header -->

                    <div class="item ">

                        <div class="item-title">
                            <?php bp_group_invite_user_link()?>
                        </div> <!-- /.item-title -->
                        <div class="item-meta"><i class="fa fa-clock-o bn-icon-time"></i>
                            <span class="activity"><?php bp_group_invite_user_last_active(); ?></span>
                        </div>


                        <?php

                        /**
                         * Fires inside the display of a directory member item.
                         *
                         */
                        do_action( 'bp_group_send_invites_item' ); ?>

                        <?php
                         /***
                          * If you want to show specific profile fields here you can,
                          * but it'll add an extra query for each member in the loop
                          * (only one regardless of the number of fields you show):
                          *
                          * bp_member_profile_data( 'field=the field name' );
                          */
                        ?>
                    </div><!-- /.item -->

                </div><!-- /.item-entry -->

				<div class="clear"></div>
		</li>

		<?php endwhile; ?>

		</ul><!-- #friend-list -->

		<div id="pag-bottom" class="pagination">

			<div class="pag-count" id="group-invite-count-bottom">
				<?php bp_group_invite_pagination_count(); ?>
			</div>

			<div class="pagination-links" id="group-invite-pag-bottom">
				<?php bp_group_invite_pagination_links(); ?>
			</div>

		</div>

	<?php else : ?>

		<div id="message" class="info">
			<p><?php _e( 'Wähle Freunde aus, die Du einladen möchtest.', 'social-portal' ); ?></p>
		</div>

	<?php endif; ?>

<?php

/**
 * Fires after the display of the group send invites list.
 *
 */
do_action( 'bp_after_group_send_invites_list' ); ?>

</div><!-- .main-column -->
