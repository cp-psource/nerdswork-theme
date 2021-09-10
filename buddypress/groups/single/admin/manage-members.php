<?php
/**
 * BuddyPress - Groups Admin - Manage Members
 *
 * @package social-portal
 *
 */
?>
<h4 class="bp-screen-reader-text"><?php _e( 'Mitglieder verwalten', 'social-portal' ); ?></h4>

<?php

/**
 * Fires before the group manage members admin display.
 *
 */
do_action( 'bp_before_group_manage_members_admin' ); ?>

<div class="bp-widget group-members-list group-admins-list">
	<h4 class="bp-section-header"><?php _e( 'Administratoren', 'social-portal' ); ?></h4>

	<?php if ( bp_group_has_members( array( 'group_role' => array( 'admin' ), 'page_arg' => 'mlpage-admin' ) ) ) : ?>

		<ul id="admins-list" class="item-list row single-line <?php echo cb_bp_get_item_list_class(); ?>">

			<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
				<li <?php bp_member_class( array( cb_bp_get_item_class( 'members' ) ) ); ?>>

					<div class='item-entry'>

						<div class="item-entry-header">

							<div class="item-avatar">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( cb_get_bp_list_avatar_args( 'group-manage' ) ); ?></a>
							</div>

							<!-- item actions -->
							<div class="action group-admin-action-button">
								<?php cb_group_admin_action_buttons()?>
							</div><!-- end of action -->

						</div> <!-- /.item-entry-header -->

						<div class="item ">

							<div class="item-title">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                            </div>
                            <div class="item-meta">
                                <i class="fa fa-clock-o bn-icon-time"></i>
                                <span class="activity"><?php bp_group_member_joined_since(); ?></span>
                            </div>


							<?php

							/**
							 * Fires inside the item section of a member admin item in group management area.
							 *
							 *
							 * @param $section Which list contains this item.
							 */
							do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>
						</div>

					</div><!-- /.item-entry -->

					<div class="clear"></div>

				</li>

			<?php endwhile; ?>

		</ul>

		<?php if ( bp_group_member_needs_pagination() ) : ?>

			<div class="pagination no-ajax">

				<div id="member-count" class="pag-count">
					<?php bp_group_member_pagination_count(); ?>
				</div>

				<div id="member-admin-pagination" class="pagination-links">
					<?php bp_group_member_admin_pagination(); ?>
				</div>

			</div>

		<?php endif; ?>

	<?php else: ?>

		<div id="message" class="info">
			<p><?php _e( 'Es wurden keine Gruppenadministratoren gefunden.', 'social-portal' ); ?></p>
		</div>

	<?php endif; ?>

</div>

<?php if ( bp_group_has_members( array( 'group_role' => array( 'mod' ), 'page_arg' => 'mlpage-mod' ) ) ) : ?>
	<div class="bp-widget group-members-list group-mods-list">
		<h4 class="bp-section-header"><?php _e( 'Moderatoren', 'social-portal' ); ?></h4>

		<ul id="mods-list" class="item-list row single-line <?php echo cb_bp_get_item_list_class(); ?>">

			<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
				<li <?php bp_member_class( array( cb_bp_get_item_class( 'members' ) ) ); ?>>

					<div class='item-entry'>

						<div class="item-entry-header">

							<div class="item-avatar">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( cb_get_bp_list_avatar_args( 'group-manage' ) ); ?></a>
							</div>

							<!-- item actions -->
							<div class="action group-mod-action-button">
								<?php	cb_group_mod_action_buttons();?>
							</div><!-- end of action -->

						</div> <!-- /.item-entry-header -->

						<div class="item ">

							<div class="item-title">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                            </div>
                            <div class="item-meta">
                                <i class="fa fa-clock-o bn-icon-time"></i>
                                <span class="activity"><?php bp_group_member_joined_since(); ?></span>
                            </div>


							<?php

							/**
							 * Fires inside the item section of a member admin item in group management area.
							 *
							 * @param $section Which list contains this item.
							 */
							do_action( 'bp_group_manage_members_admin_item', 'mods-list' ); ?>
						</div>

					</div><!-- /.item-entry -->

					<div class="clear"></div>

				</li>

			<?php endwhile; ?>

		</ul>

		<?php if ( bp_group_member_needs_pagination() ) : ?>

			<div class="pagination no-ajax">

				<div id="member-count" class="pag-count">
					<?php bp_group_member_pagination_count(); ?>
				</div>

				<div id="member-admin-pagination" class="pagination-links">
					<?php bp_group_member_admin_pagination(); ?>
				</div>

			</div>

		<?php endif; ?>

	</div>
<?php endif ?>

<?php if ( bp_group_has_members( array( 'exclude_banned' => 0 ) ) ) : ?>
	<div class="bp-widget group-members-list group-mods-list">
		<h4 class="bp-section-header"><?php _e("Mitglieder", "social-portal"); ?></h4>

		<ul id="members-list" class="item-list row single-line <?php echo cb_bp_get_item_list_class(); ?>">

			<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

					<?php $is_banned = bp_get_group_member_is_banned();
					$class= '';
					if ( $is_banned ) {
						$class= ' banned-user';
					}
					?>

					<li <?php bp_member_class( array( cb_bp_get_item_class( 'members' ) . $class ) ); ?>>


					<div class='item-entry'>

						<div class="item-entry-header">

							<div class="item-avatar">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( cb_get_bp_list_avatar_args( 'group-manage' ) ); ?></a>
							</div>

							<!-- item actions -->
							<div class="action group-members-action-button">
								<?php	cb_group_member_action_buttons();?>
							</div><!-- end of action -->

						</div> <!-- /.item-entry-header -->

						<div class="item ">

							<div class="item-title">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                            </div>
                            <div class="item-meta">
                                <i class="fa fa-clock-o bn-icon-time"></i>
                                <span class="activity"><?php bp_group_member_joined_since(); ?></span>
                            </div>


							<?php

							/**
							 * Fires inside the item section of a member admin item in group management area.
							 *
							 * @param $section string which list contains this item.
							 */
							do_action( 'bp_group_manage_members_admin_item', 'members-list' ); ?>
							<?php if ( bp_get_group_member_is_banned() ):?>
								<span class="grup-member-banned-info"><?php _e( '(gesperrt)', 'social-portal' ); ?></span>
							<?php endif;?>
						</div>

					</div><!-- /.item-entry -->

					<div class="clear"></div>

				</li>

			<?php endwhile; ?>

		</ul>

		<?php if ( bp_group_member_needs_pagination() ) : ?>

			<div class="pagination no-ajax">

				<div id="member-count" class="pag-count">
					<?php bp_group_member_pagination_count(); ?>
				</div>

				<div id="member-admin-pagination" class="pagination-links">
					<?php bp_group_member_admin_pagination(); ?>
				</div>

			</div>

		<?php endif; ?>

	</div>
<?php endif ?>

<?php

/**
 * Fires after the group manage members admin display.
 *
 */
do_action( 'bp_after_group_manage_members_admin' ); ?>