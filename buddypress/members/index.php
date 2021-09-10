<?php
/**
 * BuddyPress - Members Directory
 *
 */
/**
 * Fires at the top of the members directory template file.
 *
 */
do_action( 'bp_before_directory_members_page' );
?>

	<div id="buddypress">
		<?php

		/**
		 * Fires before the display of the members.
		 *
		 */
		do_action( 'bp_before_directory_members' );
		?>

		<?php

		/**
		 * Fires before the display of the members content.
		 *
		 */
		do_action( 'bp_before_directory_members_content' );
		?>

		<div id="members-dir-search" class="dir-search" role="search">
			<?php bp_directory_members_search_form(); ?>
		</div><!-- #members-dir-search -->

		<?php

		/**
		 * Fires before the display of the members list tabs.
		 *
		 */
		do_action( 'bp_before_directory_members_tabs' );
		?>

		<form action="" method="post" id="members-directory-form" class="dir-form">

			<div class="item-list-tabs" role="navigation">
				<ul>
					<li class="selected" id="members-all">
						<a href="<?php bp_members_directory_permalink(); ?>"><?php printf( __( 'Alle Mitglieder <span>%s</span>', 'social-portal' ), bp_get_total_member_count() ); ?></a>
					</li>
					<?php if ( function_exists( 'bp_get_member_types' ) && ! function_exists( 'bpmtp_member_types_pro' ) ) :?>
						<?php $member_types = bp_get_member_types( array(), 'objects' ); ?>
						<?php foreach ( $member_types as $member_type => $details ) : ?>
							<li id="members-type<?php echo $member_type;?>">
								<a href="<?php bp_member_type_directory_permalink( $member_type ); ?>"><?php echo $details->labels['name']; ?><span><?php echo $details->count;?></span></a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
						<li id="members-personal">
							<a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/'; ?>"><?php printf( __( 'Meine Freunde <span>%s</span>', 'social-portal' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a>
						</li>
					<?php endif; ?>

					<?php

					/**
					 * Fires inside the members directory member types.
					 */
					do_action( 'bp_members_directory_member_types' );
					?>
					<?php

					/**
					 * Fires inside the members directory member sub-types.
					 */
					do_action( 'bp_members_directory_member_sub_types' );
					?>

					<li id="members-order-select" class="last filter">
						<label for="members-order-by"><?php _e( 'Sortieren nach:', 'social-portal' ); ?></label>
						<select id="members-order-by">
							<option value="active"><?php _e( 'Letzte Aktivität', 'social-portal' ); ?></option>
							<option value="newest"><?php _e( 'Neu registriert', 'social-portal' ); ?></option>

							<?php if ( bp_is_active( 'xprofile' ) ) : ?>
								<option	value="alphabetical"><?php _e( 'Alphabetisch', 'social-portal' ); ?></option>
							<?php endif; ?>

							<?php

							/**
							 * Fires inside the members directory member order options.
							 *
							 */
							do_action( 'bp_members_directory_order_options' );
							?>
						</select>
					</li>
				</ul>
			</div><!-- .item-list-tabs -->


			<div id="members-dir-list" class="members dir-list">
				<?php bp_get_template_part( 'members/members-loop' ); ?>
			</div><!-- #members-dir-list -->

			<?php

			/**
			 * Fires and displays the members content.
			 */
			do_action( 'bp_directory_members_content' );
			?>

			<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

			<?php

			/**
			 * Fires after the display of the members content.
			 *
			 */
			do_action( 'bp_after_directory_members_content' ); ?>

		</form><!-- #members-directory-form -->

		<?php

		/**
		 * Fires after the display of the members.
		 *
		 */
		do_action( 'bp_after_directory_members' );
		?>

	</div><!-- #buddypress -->

<?php

/**
 * Fires at the bottom of the members directory template file.
 *
 */
do_action( 'bp_after_directory_members_page' );
