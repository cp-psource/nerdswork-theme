<?php
/**
 * BuddyBlog Posts List file
 * This file is used for listing the posts on profile
 */
?>

<?php if ( buddyblog_user_has_posted() ): ?>
<?php
    //let us build the post query
    if ( bp_is_my_profile() || is_super_admin() ) {
 		$status = 'any';
	} else {
		$status = 'publish';
	}
	
    $paged = bp_action_variable( 0 );
    $paged = $paged ? $paged : 1;
    
	$query_args = array(
		'author'        => bp_displayed_user_id(),
		'post_type'     => buddyblog_get_posttype(),
		'post_status'   => $status,
		'paged'         => intval( $paged )
    );
	//do the query
    query_posts( $query_args );
	?>
    
	<?php if ( have_posts() ): ?>

		<div id='posts-list' class="<?php echo cb_get_posts_list_class(); ?>">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/entry-' . cb_get_posts_display_type(), get_post_type() ); ?>

			<?php endwhile; ?>
		</div>

		<div class="clearfix pagination">
			<?php cb_pagination(); ?>
		</div>

    <?php else: ?>
            <p><?php _e( 'There are no posts by this user at the moment. Please check back later!', 'social-portal' );?></p>
    <?php endif; ?>

    <?php 
       wp_reset_postdata();
       wp_reset_query();
    ?>

<?php elseif ( bp_is_my_profile() && buddyblog_user_can_post( get_current_user_id() ) ): ?>
    <p> <?php _e( "You haven't posted anything yet.", 'social-portal' );?> <a href="<?php echo buddyblog_get_new_url();?>"> <?php _e( 'New Post', 'social-portal' );?></a></p>
<?php endif; ?>