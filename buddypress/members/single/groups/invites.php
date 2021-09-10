<?php

/**
 * Fires before the display of member group invites content.
 *
 */
do_action( 'bp_before_group_invites_content' );
?>

<?php if ( bp_has_groups( 'type=invites&user_id=' . bp_loggedin_user_id() ) ) : ?>

	<ul id="group-list" class="invites item-list row <?php echo cb_bp_get_item_list_class(); ?>">

		<?php while ( bp_groups() ) : bp_the_group(); ?>

		<li <?php bp_group_class( array( cb_bp_get_item_class( 'groups' ) ) ); ?>>
			
			<div class="item-entry">
				<div class="item-entry-header">

                    <div class="item-avatar">
                        <?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
                            <a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( cb_get_bp_list_avatar_args( 'groups' ) ); ?></a>
                        <?php endif; ?>
                    </div>

					<div class="action">
						<?php cb_group_invitations_action_buttons();?>
					</div><!-- /.action -->

				</div> <!-- /.item-avatar -->			

				<div class="item">
					<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
					<div class="item-meta"><i class="fa fa-clock-o bn-icon-time"></i><span class="activity"><?php printf( __( 'active %s', 'social-portal' ), bp_get_group_last_active() ); ?></span></div>

					<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

					<?php

					/**
					 * Fires inside the listing of an individual group listing item.
					 *
					 */
					do_action( 'bp_group_invites_item' );
					?>

				</div>

			</div> <!-- /.item-entry -->	

			<div class="clear"></div>

		</li>

		<?php endwhile; ?>

	</ul>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'You have no outstanding group invites.', 'social-portal' ); ?></p>
	</div>

<?php endif;?>

<?php

/**
 * Fires after the display of member group invites content.
 */
do_action( 'bp_after_group_invites_content' );
