<?php

/**
 * Fires at the top of the groups directory template file.
 *
 */
do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of the groups.
	 *
	 */
	do_action( 'bp_before_directory_groups' );
	?>

	<?php

	/**
	 * Fires before the display of the groups content.
	 *
	 */
	do_action( 'bp_before_directory_groups_content' );
	?>

	<div id="group-dir-search" class="dir-search" role="search">
		<?php bp_directory_groups_search_form(); ?>
	</div><!-- #group-dir-search -->
	<?php

	/**
	 * Fires before the display of the groups list tabs.
	 *
	 */
	do_action( 'bp_before_directory_groups_tabs' );
	?>
	<form action="" method="post" id="groups-directory-form" class="dir-form">

		<div class="item-list-tabs" role="navigation">
			<ul>
				<li class="selected" id="groups-all"><a href="<?php bp_groups_directory_permalink(); ?>"><?php printf( __( 'Alle Gruppen <span>%s</span>', 'social-portal' ), bp_get_total_group_count() ); ?></a></li>

				<?php if ( function_exists( 'bp_groups_get_group_types' ) ) :?>
					<?php $group_types = bp_groups_get_group_types( array(), 'objects' ); ?>
					<?php foreach ( $group_types as $group_type => $details ) : ?>
						<li id="groups-type<?php echo $group_type; ?>">
							<a href="<?php bp_group_type_directory_permalink( $group_type ); ?>"><?php echo $details->labels['name']; ?><span><?php echo $details->count; ?></span></a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php

				/**
				 * Fires inside the groups directory group types.
				 *
				 */
				do_action( 'bp_groups_directory_group_types' ); ?>

				<?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
					<li id="groups-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>"><?php printf( __( 'Meine Gruppen <span>%s</span>', 'social-portal' ), bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>
				<?php endif; ?>
				<?php

				/**
				 * Fires inside the groups directory group filter input.
				 *
				 */
				do_action( 'bp_groups_directory_group_filter' ); ?>
				<li id="groups-order-select" class="last filter">

					<label for="groups-order-by"><?php _e( 'Ordnen nach:', 'social-portal' ); ?></label>

					<select id="groups-order-by">
						<option value="active"><?php _e( 'Zuletzt aktiv', 'social-portal' ); ?></option>
						<option value="popular"><?php _e( 'Meisten Mitglieder', 'social-portal' ); ?></option>
						<option value="newest"><?php _e( 'Neu erstellt', 'social-portal' ); ?></option>
						<option value="alphabetical"><?php _e( 'Alphabetisch', 'social-portal' ); ?></option>

						<?php

						/**
						 * Fires inside the groups directory group order options.
						 *
						 */
						do_action( 'bp_groups_directory_order_options' ); ?>
					</select>
				</li>
			</ul>
		</div><!-- .item-list-tabs -->

		<div id="groups-dir-list" class="groups dir-list">
			<?php bp_get_template_part( 'groups/groups-loop' ); ?>
		</div><!-- #groups-dir-list -->

		<?php

		/**
 		 * Fires and displays the group content.
 		 *
 		 */
		do_action( 'bp_directory_groups_content' ); ?>

		<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>

		<?php

		/**
 		 * Fires after the display of the groups content.
 		 *
 		 */
		do_action( 'bp_after_directory_groups_content' ); ?>

	</form><!-- #groups-directory-form -->

	<?php

	/**
 	 * Fires after the display of the groups.
 	 *
 	 */
	do_action( 'bp_after_directory_groups' ); ?>

</div><!-- #buddypress -->

<?php

/**
 * Fires at the bottom of the groups directory template file.
 *
 */
do_action( 'bp_after_directory_groups_page' );
