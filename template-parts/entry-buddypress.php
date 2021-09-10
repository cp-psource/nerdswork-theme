<!-- used for BuddyPress directory pages only -->
<div class="bp-content-wrapper">

	<?php do_action( 'cb_before_bp_content' ); ?>

	<?php $class_hidden = cb_is_post_title_visible() ? '' : 'hidden-post-title'; ?>

	<header class="entry-header <?php echo $class_hidden; ?>">
		<?php
			the_title( "<h1 class='entry-title {$class_hidden}'>", "</h1>" );
		?>
	</header>
	<?php
	/**
	 * The the_content() call is replaced by the actual BuddyPress generated content
	 */
	?>
	<?php the_content( __( 'Weiterlesen <span class="meta-nav">&rarr;</span>', 'social-portal' ) ); ?>

    <?php do_action( 'cb_after_bp_content' ); ?>

</div> <!-- /.bp-content-wrapper -->
