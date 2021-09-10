
<li <?php bp_group_class( array( cb_bp_get_item_class( 'groups' ) ) ); ?>>

	<div class="item-entry">

		<div class="item-entry-header">

			<?php cb_group_status_icon();?>

			<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>

				<div class="item-avatar">
					<a href="<?php bp_group_permalink(); ?>" class="item-permalink">
						<?php bp_group_avatar( cb_get_bp_list_avatar_args( 'groups-loop' ) ); ?>
					</a>
					<?php cb_group_member_count(); ?>
				</div>
			<?php endif; ?>

			<div class="action">
				<?php cb_group_action_buttons();?>
			</div><!-- /.action -->

		</div> <!-- /.item-entry-header -->

		<div class="item">
			<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>

			<div class="item-meta"><i class="fa fa-clock-o bn-icon-time"></i><span class="activity"><?php printf( __( 'aktive %s', 'social-portal' ), bp_get_group_last_active() ); ?></span></div>

			<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

			<?php

			/**
			 * Fires inside the listing of an individual group listing item.
			 *
			 */
			do_action( 'bp_directory_groups_item' );
			?>

		</div>

	</div> <!-- /.item-entry -->

	<div class="clear"></div>

</li>