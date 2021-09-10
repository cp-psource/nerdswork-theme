<?php
/**
 * BuddyPress - Blogs Directory
 *
 */

/**
 * Fires at the top of the blogs directory template file.
 */
do_action( 'bp_before_directory_blogs_page' ); ?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of the blogs.
	 *
	 */
	do_action( 'bp_before_directory_blogs' ); ?>

	<?php

	/**
	 * Fires before the display of the blogs listing content.
	 *
	 */
	do_action( 'bp_before_directory_blogs_content' ); ?>

	<div id="blog-dir-search" class="dir-search" role="search">
		<?php bp_directory_blogs_search_form(); ?>
	</div><!-- #blog-dir-search -->

	<?php

	/**
	 * Fires before the display of the blogs list tabs.
	 */
	do_action( 'bp_before_directory_blogs_tabs' ); ?>

	<form action="" method="post" id="blogs-directory-form" class="dir-form">

		<div class="item-list-tabs" role="navigation">
			<ul>
				<li class="selected" id="blogs-all"><a href="<?php bp_root_domain(); ?>/<?php bp_blogs_root_slug(); ?>"><?php printf( __( 'Alle Seiten %s', 'social-portal' ), '<span>' . bp_get_total_blog_count() . '</span>' ); ?></a></li>

				<?php if ( is_user_logged_in() && bp_get_total_blog_count_for_user( bp_loggedin_user_id() ) ) : ?>
					<li id="blogs-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_blogs_slug(); ?>"><?php printf( __( 'Meine Seiten %s', 'social-portal' ), '<span>' . bp_get_total_blog_count_for_user( bp_loggedin_user_id() ) . '</span>' ); ?></a></li>
				<?php endif; ?>

				<?php

				/**
				 * Fires inside the unordered list displaying blog types.
				 *
				 */
				do_action( 'bp_blogs_directory_blog_types' ); ?>
				<?php

				/**
				 * Fires inside the unordered list displaying blog sub-types.
				 *
				 */
				do_action( 'bp_blogs_directory_blog_sub_types' ); ?>

				<li id="blogs-order-select" class="last filter">

					<label for="blogs-order-by"><?php _e( 'Sortieren nach:', 'social-portal' ); ?></label>
					<select id="blogs-order-by">
						<option value="active"><?php _e( 'Zuletzt aktualisiert', 'social-portal' ); ?></option>
						<option value="newest"><?php _e( 'Neueste', 'social-portal' ); ?></option>
						<option value="alphabetical"><?php _e( 'Alphabetisch', 'social-portal' ); ?></option>

						<?php

						/**
						 * Fires inside the select input listing blogs orderby options.
						 *
						 */
						do_action( 'bp_blogs_directory_order_options' ); ?>

					</select>
				</li>
			</ul>
		</div><!-- .item-list-tabs -->


		<div id="blogs-dir-list" class="blogs dir-list">

			<?php bp_get_template_part( 'blogs/blogs-loop' ); ?>

		</div><!-- #blogs-dir-list -->

		<?php

		/**
		 * Fires inside and displays the blogs content.
		 *
		 */
		do_action( 'bp_directory_blogs_content' ); ?>

		<?php wp_nonce_field( 'directory_blogs', '_wpnonce-blogs-filter' ); ?>

		<?php

		/**
		 * Fires after the display of the blogs listing content.
		 *
		 */
		do_action( 'bp_after_directory_blogs_content' ); ?>

	</form><!-- #blogs-directory-form -->

	<?php

	/**
	 * Fires at the bottom of the blogs directory template file.
	 *
	 */
	do_action( 'bp_after_directory_blogs' ); ?>

</div>

<?php

/**
 * Fires at the bottom of the blogs directory template file.
 *
 */
do_action( 'bp_after_directory_blogs_page' );
