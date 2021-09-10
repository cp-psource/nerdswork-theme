<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

	<?php

	/**
	 * Fires before the display of the group members content.
	 *
	 */
	do_action( 'bp_before_group_members_content' ); ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-count-top">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-pag-top">
			<?php bp_members_pagination_links(); ?>
		</div>

	</div>

	<?php

	/**
	 * Fires before the display of the group members list.
	 *
	 */
	do_action( 'bp_before_group_members_list' ); ?>

	<ul id="member-list" class="item-list row <?php echo cb_bp_get_item_list_class(); ?>">

		<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

			<li <?php bp_member_class( array( cb_bp_get_item_class( 'members' ) ) ); ?>>
							
				<div class='item-entry'>

                    <div class="item-entry-header">

                        <div class="item-avatar">
                            <a href="<?php bp_group_member_domain(); ?>">
                                <?php cb_group_member_avatar( cb_get_bp_list_avatar_args( 'group-members' ) ); ?>
                            </a>
                        </div>

                        <!-- item actions -->
                        <div class="action">
                            <?php cb_member_action_buttons(); ?>
                        </div>

                    </div> <!-- /.item-entry-header -->

                    <div class="item ">

                        <div class="item-title">
                            <?php bp_group_member_link(); ?>
                        </div> <!-- /.item-title -->
                        <div class="item-meta">
                            <i class="fa fa-clock-o bn-icon-time"></i>
                            <span class="activity"><?php bp_group_member_joined_since(); ?></span>
                        </div>

                        <?php

                        /**
                         * Fires inside the display of a directory member item.
                         *
                         */
                        do_action( 'bp_group_members_list_item' ); ?>

                        <?php
                         /***
                          * If you want to show specific profile fields here you can,
                          * but it'll add an extra query for each member in the loop
                          * (only one regardless of the number of fields you show):
                          *
                          * bp_member_profile_data( 'field=the field name' );
                          */
                        ?>
                    </div> <!-- /.item -->


                </div><!-- /.item-entry -->
				<div class="clear"></div>
				
			</li>

		<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the group members list.
	 *
	 */
	do_action( 'bp_after_group_members_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-count-bottom">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>

	</div>

	<?php

	/**
	 * Fires after the display of the group members content.
	 *
	 */
	do_action( 'bp_after_group_members_content' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Es wurden keine Mitglieder gefunden.', 'social-portal' ); ?></p>
	</div>

<?php endif; ?>
