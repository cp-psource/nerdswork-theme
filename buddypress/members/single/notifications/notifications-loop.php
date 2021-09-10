<form action="" method="post" id="notifications-bulk-management">
	<table class="notifications">

		<thead>
			<tr>
				<th class="bulk-select-all"><label class="bp-screen-reader-text" for="select-all-notifications"><?php _e( 'Alle', 'social-portal' ); ?></label><input id="select-all-notifications" type="checkbox"></th>
				<th class="title"><?php _e( 'Benachrichtigung', 'social-portal' ); ?></th>
				<th class="actions"><?php _e( 'Aktionen',    'social-portal' ); ?></th>
			</tr>
		</thead>

		<tbody>

			<?php while ( bp_the_notifications() ) : bp_the_notification(); ?>

				<tr>
					<td class="bulk-select-check"><input id="<?php bp_the_notification_id(); ?>" type="checkbox" name="notifications[]" value="<?php bp_the_notification_id(); ?>" class="notification-check"></td>
					<td class="notification-description"><?php bp_the_notification_description();  ?><span class="notification-since"><?php bp_the_notification_time_since();   ?></span></td>
					
					<td class="notification-actions"><?php bp_the_notification_action_links(); ?></td>
				</tr>

			<?php endwhile; ?>

		</tbody>

	</table>

	<div class="notifications-options-nav">
		<?php bp_notifications_bulk_management_dropdown(); ?>
	</div><!-- .notifications-options-nav -->

	<?php wp_nonce_field( 'notifications_bulk_nonce', 'notifications_bulk_nonce' ); ?>
</form>