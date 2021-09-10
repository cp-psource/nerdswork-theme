<article class="clearfix article-error-404" id="post-error-404">
	
	<?php do_action( 'cb_before_404_entry' ); ?>
	
	<?php if ( ! is_404() ): ?>

		<header class="entry-header entry-header-404">
			<i class="fa fa-user-secret"></i>
		</header>

	<?php endif;?>

	<div class="clearfix entry-content">
		
		<p><?php _e( 'Sei versichert, wir schauen es uns an und werden es bald wieder haben.', 'social-portal' ); ?></p>
		
		<?php get_search_form(); ?>
		
	</div><!-- .entry-content -->

	<?php do_action( 'cb_after_404_entry' ); ?>

</article>