<?php
/**
 * BuddyPress Blogs List
 *
 * Used inside has_blogs() to list the blogs
 */
?>
<ul id="blogs-list" class="item-list row <?php echo cb_bp_get_item_list_class(); ?>">

	<?php while ( bp_blogs() ) : bp_the_blog(); ?>

		<li <?php bp_blog_class( array( cb_bp_get_item_class( 'blogs' ) ) ) ?>>

			<div class='item-entry'>
				<div class="item-entry-header">
					<div class="item-avatar">
						<a href="<?php bp_blog_permalink(); ?>"><?php bp_blog_avatar( cb_get_bp_list_avatar_args( 'blogs-loop' ) ); ?></a>
					</div>

					<div class="action">

						<?php cb_blog_action_buttons();	?>

						<div class="meta">
						</div>

					</div>
				</div> <!-- /.item-entry-header -->

				<div class="item">
					<div class="item-title"><a href="<?php bp_blog_permalink(); ?>"><?php bp_blog_name(); ?></a></div>
					<div class="item-meta"><i class="fa fa-clock-o bn-icon-time"></i><span class="activity"><?php bp_blog_last_active(); ?></span></div>
					<div class="item-desc"><?php bp_blog_latest_post(); ?></div>
					<?php

					/**
					 * Fires after the listing of a blog item in the blogs loop.
					 *
					 */
					do_action( 'bp_directory_blogs_item' ); ?>
				</div>

			</div><!-- /.item-entry -->
			<div class="clear"></div>
		</li>

	<?php endwhile; ?>

</ul>