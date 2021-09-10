
	<div id="item-body">

		<?php

		/**
		 * Fires before the display of the group home body.
		 *
		 */
		do_action( 'bp_before_group_body' );

			// Looking at home location
			if ( bp_is_group_home() ) :?>
		
				<?php if ( bp_group_is_visible() ): ?>
					<?php bp_groups_front_template_part(); // Load appropriate front template ?>
				<?php else : ?>
					<?php
						/**
						 * Fires before the display of the group status message.
						 *
						 */
						do_action( 'bp_before_group_status_message' ); ?>

						<div id="message" class="info">
							<p><?php bp_group_status_message(); ?></p>
						</div>

					<?php
						/**
						 * Fires after the display of the group status message.
						 *
						 */
						do_action( 'bp_after_group_status_message' );

					endif; ?>

				<?php // Not looking at home	?>

			<?php else : ?>
				
				<?php 
					// Group Admin
					if     ( bp_is_group_admin_page() ) : bp_get_template_part( 'groups/single/admin'        );

					// Group Activity
					elseif ( bp_is_group_activity()   ) : bp_get_template_part( 'groups/single/activity'     );

					// Group Members
					elseif ( bp_is_group_members()    ) : bp_groups_members_template_part();

					// Group Invitations
					elseif ( bp_is_group_invites()    ) : bp_get_template_part( 'groups/single/send-invites' );

					// Membership request
					elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

					// Anything else (plugins mostly)
					else                                : bp_get_template_part( 'groups/single/plugins'      );

					endif; 
				?>

		<?php endif; ?>

		<?php 
		/**
		 * Fires after the display of the group home body.
		 *
		 */
		do_action( 'bp_after_group_body' ); ?>

	</div><!-- #item-body -->

	<?php

	/**
	 * Fires after the display of the group home content.
	 *
	 */
	do_action( 'bp_after_group_home_content' ); ?>



