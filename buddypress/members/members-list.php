<?php
/**
 * Used inside bp_has_members() to generate all kind of list
 * Used in members-loop.php and shortcodes
 */
?>
<ul id="members-list" class="item-list row <?php echo cb_bp_get_item_list_class(); ?>">

	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li <?php bp_member_class( array( cb_bp_get_item_class( 'members' ) ) ); ?>>

			<div class='item-entry'>

				<div class="item-entry-header">

					<div class="item-avatar">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( cb_get_bp_list_avatar_args( 'members-loop' ) ); ?></a>
					</div>

					<!-- item actions -->
					<div class="action">
						<?php cb_member_action_buttons(); ?>
					</div><!-- end of action -->

				</div> <!-- /.item-entry-header -->

				<div class="item ">

					<div class="item-title">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
						<div class="item-meta">
							<i class="fa fa-clock-o bn-icon-time"></i>
							<span class="activity"><?php bp_member_last_active(); ?></span>
						</div>

						<?php if ( bp_get_member_latest_update() ) : ?>
							<div class="item-desc user-last-activity-update"> <?php bp_member_latest_update( array( 'length' => 64 ) ); ?></div>
						<?php endif; ?>

					</div>

					<?php

					/**
					 * Fires inside the display of a directory member item.
					 *
					 */
					do_action( 'bp_directory_members_item' );
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

			<div class="clear"></div>

		</li>

	<?php endwhile; ?>
</ul>