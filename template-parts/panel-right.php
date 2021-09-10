<?php
/**
 * Right panel displayed on clicking toggle
 */
?>
<!-- Panel right -->
<aside id="panel-right" class="panel-sidebar">
	<h2 class="accessibly-hidden"><?php _e( 'Rechtes Panel Navigation', 'social-portal' ); ?></h2>

	<div class="panel-sidebar-inner">
		<?php if ( is_user_logged_in() && cb_is_bp_active() ) : ?>

			<?php do_action( 'bp_before_sidebar_me' ); ?>

			<div class="panel-header panel-right-header">
				<div class="sidebar-me">
					
					<a href="<?php echo bp_loggedin_user_domain(); ?>">
						<?php bp_loggedin_user_avatar( 'type=thumb&width=40&height=40' ); ?>
					</a>

					<span class="panel-user-display-name"><?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></span>
					<a class="logout" href="<?php echo wp_logout_url( wp_guess_url() ); ?>" title="<?php _e( 'Ausloggen', 'social-portal' ); ?>"><i class="fa fa-power-off"></i></a>

					<?php do_action( 'cb_panel_right_header' ); ?>
					
				</div>
				
			</div><!--end of header -->
			
			<!-- user menu -->
			<div id="loggedin-user-nav" class="panel-account-menu">
				<?php combuilder()->adminbar()->account('li-nav');?>
            </div>  
			<!--end of user profile menu -->

			<?php if ( bp_is_active( 'messages' ) ) : ?>
				<?php bp_message_get_notices(); /* Site wide notices to all users */ ?>
			<?php endif; ?>

		<?php elseif ( cb_is_bp_active() && apply_filters( 'cb_show_right_panel_login_form', true ) ) : ?>
			<?php // for non logged in users ?>

			<span class="panel-header panel-login-header">
				<?php $text = cb_get_option( 'panel-right-login-title', __( 'Account Login', 'social-portal' ) ); ?>
				<?php echo $text; ?> 
			</span>

			<?php if ( bp_get_signup_allowed() ) : ?>
				<p class="login-text">
					<?php printf( __( 'Bitte <a href="%s" title="erstelle einen Account" class="signup-button panel-signup-link bp-ajaxr">erstelle einen Account</a> um teilzunehmen.', 'social-portal' ), bp_get_signup_page() ); ?>
				</p>
			<?php endif; ?>

			<form name="login-form" id="panel-login-form" class="standard-form panel-form panel-login-form" action="<?php echo wp_login_url(); ?>" method="post">
				<label><?php _e( 'Benutzername', 'social-portal' ); ?><br />
					<input type="text" name="log" id="sidebar-user-login" class="input" value="<?php if ( isset( $user_login ) ) echo esc_attr( stripslashes( $user_login ) ); ?>" />
				</label>

				<label><?php _e( 'Passwort', 'social-portal' ); ?><br />
					<input type="password" name="pwd" id="sidebar-user-pass" class="input" value=""  />
				</label>

				<p class="forgetmenot">
					<label>
						<input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever"  /> <?php _e( 'Behalte mich in Erinnerung', 'social-portal' ); ?>
					</label>
				</p>

				<input type="submit" name="wp-submit" id="panel-wp-submit" value="<?php _e( 'Einloggen', 'social-portal' ); ?>"  />

				<?php do_action( 'bp_sidebar_login_form' ); ?>

			</form>

			<?php do_action( 'bp_after_sidebar_login_form' ); ?>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'panel-right-menu' ) ):?>
			<?php
				wp_nav_menu( array(
					'container'			=> false,
					'menu_class'		=> 'panel-menu',
					'theme_location'	=> 'panel-right-menu',//menu id
					'depth'				=> 3,
					'fallback_cb'		=> 'wp_page_menu',
					//Process nav menu using our custom nav walker
					'walker'			=> new CB_TreeView_Navwalker
				) );
			?>
		<?php endif;?>

		<?php do_action( 'cb_after_panel_right_menu' ); ?>

		<?php if ( is_active_sidebar( 'panel-right-sidebar' ) ): ?>
			<div class='panel-widgets'>
				<?php dynamic_sidebar( 'panel-right-sidebar' ); ?>
			</div>
		<?php endif; ?>

		<?php do_action( 'cb_after_panel_right' ); ?>
				
	</div><!-- /.panel-sidebar-inner -->
</aside><!-- /.panel-sidebar -->
<!-- end of mobile menu panel right -->