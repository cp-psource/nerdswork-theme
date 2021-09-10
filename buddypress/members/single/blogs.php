<?php

/**
 * BuddyPress - Users Blogs
 * User Profile-> Sites
 */
?>

<div class="item-list-tabs" id="subnav" role="navigation">
	<ul>

		<?php bp_get_options_nav(); ?>

		<li id="blogs-order-select" class="last filter">

			<label for="blogs-order-by"><?php _e( 'Sortieren nach:', 'social-portal' ); ?></label>
			<select id="blogs-order-by">
				<option value="active"><?php _e( 'Letzte Aktivität', 'social-portal' ); ?></option>
				<option value="newest"><?php _e( 'Neueste', 'social-portal' ); ?></option>
				<option value="alphabetical"><?php _e( 'Alphabetisch', 'social-portal' ); ?></option>

				<?php

				/**
				 * Fires inside the members blogs order options select input.
				 *
				 */
				do_action( 'bp_member_blog_order_options' ); ?>

			</select>
		</li>
	</ul>
</div><!-- .item-list-tabs -->

<?php
switch ( bp_current_action() ) :

	// Home/My Blogs
	case 'my-sites' :

		/**
		 * Fires before the display of member blogs content.
		 *
		 */
		do_action( 'bp_before_member_blogs_content' );
		?>

		<div class="blogs myblogs">

			<?php bp_get_template_part( 'blogs/blogs-loop' ) ?>

		</div><!-- .blogs.myblogs -->

		<?php

		/**
		 * Fires after the display of member blogs content.
		 *
		 */
		do_action( 'bp_after_member_blogs_content' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
