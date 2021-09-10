<!-- Left panel menu -->

<aside id="panel-left" class="panel-sidebar">
	
	<h2 class="accessibly-hidden"><?php _e( 'Linkes Panel Navigation', 'social-portal' ); ?></h2>
	
	<div class="panel-sidebar-inner">
		
		<?php do_action( 'cb_before_left_panel_header' ); ?>
		
		<?php $panel_left_menu = 'panel-left-menu'; ?>

		<?php if ( has_nav_menu( $panel_left_menu ) ) :	?>
		
			<?php do_action( 'cb_before_left_panel_content' ); ?>

			<?php 

				wp_nav_menu( array(
					'container'			=> false, 
					'menu_class'		=> 'panel-menu', 
					'theme_location'	=> $panel_left_menu ,                          
					'depth'				=> 3,
					'fallback_cb'		=> 'wp_page_menu',
					//Process nav menu using our custom nav walker
					'walker'			=> new CB_TreeView_Navwalker
					)
				);

			?>
		
			<?php do_action( 'cb_after_panel_left_menu' ); ?>
		
		<?php endif; ?>
		
		<?php if ( is_active_sidebar( 'panel-left-sidebar' ) ): ?>
		
			<div class='panel-widgets'>
				<?php dynamic_sidebar( 'panel-left-sidebar' ); ?>
			</div>

		<?php endif;?>
		
		<?php do_action( 'cb_after_panel_left' ); ?>
	</div>
</aside>