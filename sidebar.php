<?php
/**
 * Global Sidebar template file
 *
 * @package social-portal
 * @author WMS N@W
 */
?>
<?php

//Do not load sidebar if current page layout or theme layout doesn't allow it

 if ( ! cb_has_sidebar_enabled() ) {
	 return ;
 }
?>

<?php do_action( 'cb_before_sidebar' ); ?>

<aside id="sidebar">
	<div class="padder">

		<h1 class="accessibly-hidden"><?php _e( 'Seitenleistennavigation', 'social-portal' ); ?></h1>

		<?php do_action( 'cb_inside_before_sidebar' ); ?>

		<?php if ( ! is_user_logged_in() && ! is_active_sidebar( 'sidebar' ) && apply_filters( 'cb_show_sidebar_login_form', true ) ) : ?>

			<?php do_action( 'bp_before_sidebar_login_form' ); ?>

			<?php if ( cb_is_bp_active() && bp_get_signup_allowed() ) : ?>

				<p id="login-text">
					<?php printf( __( 'Bitte <a href="%s" title="erstelle einen Account">erstelle einen Account</a> um teilnehmen zu können.', 'social-portal' ), bp_get_signup_page() ); ?>
				</p>

			<?php endif; ?>

			<form name="login-form" id="sidebar-login-form" class="standard-form" action="<?php echo wp_login_url(); ?>" method="post">

				<label for="log"><?php _e( 'Benutzername', 'social-portal' ); ?><br />
				<input type="text" name="log" id="sidebar-user-login" class="input" value="<?php if ( isset( $user_login ) ) echo esc_attr( stripslashes( $user_login ) ); ?>" tabindex="97" /></label>

				<label for="pwd"><?php _e( 'Passwort', 'social-portal' ); ?><br />
				<input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>

				<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> <?php _e( 'Behalte mich in Erinnerung', 'social-portal' ); ?></label></p>

				<input type="submit" name="wp-submit" id="sidebar-wp-submit" value="<?php _e( 'Einloggen', 'social-portal' ); ?>" tabindex="100" />

				<?php do_action( 'bp_sidebar_login_form' ); ?>

			</form>

			<?php do_action( 'bp_after_sidebar_login_form' ); ?>

		<?php endif; ?>

		<?php dynamic_sidebar( 'sidebar' ); ?>

		<?php do_action( 'cb_inside_after_sidebar' ); ?>
	</div>

</aside><!-- #sidebar -->

<?php do_action( 'cb_after_sidebar' ); ?>