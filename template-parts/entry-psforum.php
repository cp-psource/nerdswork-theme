<!-- used for psforum pages only -->
<div class="psf-content-wrapper">

	<?php do_action( 'cb_before_psforum_entry' ); ?>

	<?php $class_hidden = cb_is_post_title_visible() ? '' : 'hidden-post-title'; ?>
	<header class="entry-header <?php echo $class_hidden; ?>">

		<?php
			the_title( "<h1 class='entry-title {$class_hidden}'>", "</h1>" );
		?>
	
	</header>
	
	<?php the_content( __( 'Weiterlesen <span class="meta-nav">&rarr;</span>', 'social-portal' ) ); ?>

	<?php do_action( 'cb_after_psforum_entry' ); ?>

</div> <!-- /.psf-content-wrapper -->