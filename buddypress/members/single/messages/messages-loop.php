<?php
/**
 * BuddyPress - Members Messages Loop
 * We are keeping all the actions to make sure the 3rd party plugins needing them will work with this theme
 */
/**
 * Fires before the members messages loop.
 * 
 */
do_action( 'bp_before_member_messages_loop' );
?>

<?php if ( bp_has_message_threads( bp_ajax_querystring( 'messages' ) ) ) : ?>

	<div class="message-list-search-pagination clearfix">
		
		<div class="message-search"><?php bp_message_search_form(); ?></div>
		
		<div class="pagination no-ajax message-pagination" id="user-pag">

			<div class="pag-count" id="messages-dir-count">
				<?php cb_messages_pagination_count(); ?>
			</div>

			<div class="pagination-links" id="messages-dir-pag">
				<?php bp_messages_pagination(); ?>
			</div>

		</div><!-- .pagination -->
		
	</div>
	<?php
	/**
	 * Fires after the members messages pagination display.
	 *
	 */
	do_action( 'bp_after_member_messages_pagination' );
	?>

	<?php
	/**
	 * Fires before the members messages threads.
	 */
	do_action( 'bp_before_member_messages_threads' );
	?>

	<form action="<?php echo bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() ?>/bulk-manage/" method="post" id="messages-bulk-management">

		<ul class="message-list" id="message-list">

			<li id="message-toolbar" class="clearfix">

				<div class="bulk-select-all"><label><input id="select-all-messages" type="checkbox" /></label><label class="bp-screen-reader-text" for="select-all-messages"><?php _e( 'Wähle Alle', 'social-portal' ); ?></label></div>

				<div class="message-tool-bar-actions">
					<?php	do_action( 'cb_message_toolbar' );?>
				</div>

			</li>

			<?php while ( bp_message_threads() ) : bp_message_thread(); ?>

				<li id="m-<?php bp_message_thread_id(); ?>" class="clearfix <?php bp_message_css_class(); ?><?php if ( bp_message_thread_has_unread() ) : ?> unread<?php else: ?> read<?php endif; ?>">

                    <div class="thread-from">
                        <?php bp_message_thread_avatar( array( 'width' => 50, 'height' =>50 ) ); ?>
                    </div>

					<div class="thread-info">

                        <?php if ( 'sentbox' != bp_current_action() ) : ?>
                            <?php bp_message_thread_from(); ?>
                        <?php else: ?>
                            <?php bp_message_thread_to(); ?>
                        <?php endif;?>

						<p class="thread-excerpt">
							<a href="<?php bp_message_thread_view_link(); ?>" title="<?php esc_attr_e( "Nachricht ansehen", "social-portal" ); ?>">
								<?php bp_message_thread_total_and_unread_count(); ?>
								<span class="thread-message-subject"><?php bp_message_thread_subject(); ?></span>
								<span class="thread-excerpt-content"><?php bp_message_thread_excerpt(); ?></span>
							</a>
						</p>

					</div>

					<?php
					/**
					 * Fires inside the messages box table row to add a new column.
					 *
					 * This is to primarily add a <td> cell to the message box table. Use the
					 * related 'bp_messages_inbox_list_header' hook to add a <th> header cell.
					 */
					do_action( 'bp_messages_inbox_list_item' );
					?>
                    <div class="message-thread-meta">
						
                        <?php if ( bp_is_active( 'messages', 'star' ) ) : ?>
                            <span class="thread-star">
								<?php bp_the_message_star_action_link( array( 'thread_id' => bp_get_message_thread_id() ) ); ?>
							</span>
                        <?php endif; ?>
						
                          <span class="bulk-select-check">
                            <label for="bp-message-thread-<?php bp_message_thread_id(); ?>"><input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php bp_message_thread_id(); ?>" class="message-check" value="<?php bp_message_thread_id(); ?>" /><span class="bp-screen-reader-text"><?php _e( 'Wähle diese Nachricht aus', 'social-portal' ); ?></span></label>
                        </span>

                        <span class="thread-last-active-time">
                            <?php echo cb_get_time_or_date( strtotime( bp_get_message_thread_last_post_date_raw() ) );	?>
                        </span>
						
                    </div>

				</li>

			<?php endwhile; ?>

		</ul>

		<div class="messages-options-nav">
			<?php bp_messages_bulk_management_dropdown(); ?>
		</div><!-- .messages-options-nav -->

		<?php wp_nonce_field( 'messages_bulk_nonce', 'messages_bulk_nonce' ); ?>

	</form>

	<?php
	/**
	 * Fires after the members messages threads.
	 *
	 */
	do_action( 'bp_after_member_messages_threads' );
	?>

	<?php
	/**
	 * Fires and displays member messages options.
	 */
	do_action( 'bp_after_member_messages_options' );
	?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Es wurden leider keine Nachrichten gefunden.', 'social-portal' ); ?></p>
	</div>

<?php endif; ?>

<?php
/**
 * Fires after the members messages loop.
 */
do_action( 'bp_after_member_messages_loop' );
