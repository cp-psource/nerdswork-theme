<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * These are page element block
 * You can attach them to various Community+ template actions to build layouts
 * 
 * see lib/framework/builder.php to see how the default layout is generated
 * 
 */
/**
 * 1. Site Logo : cb_site_branding()
 * 2. Offcanvas toggle left : cb_offcanvas_toggle_left()
 * 3. Offcanvas toggle right : cb_offcanvas_toggle_right()
 * 4. Primary Menu : cb_primary_menu()
 * 5. Search Form : cb_search_form()
 * 6. Login/Account Links: cb_login_account_links()
 * 7. Social Links: cb_social_links()
 */

/**
 * Logo block
 *
 * Generate Logo/Logo text
 */
function cb_site_branding() { ?>
    <!-- site logo -->
    <div id="logo" data-site-name="<?php bloginfo( 'name' ); ?>">

    <?php cb_site_branding_content();?>
    </div><!-- end of site logo section -->
    <?php
}

function cb_site_branding_content() {

        if ( function_exists( 'the_custom_logo' ) ) {
	        $logo = get_custom_logo();
        } else {
	        $logo = cb_get_fallback_custom_logo();
        }

        ?>
        <?php // Logo markup ?>
        <?php echo $logo; ?>
        <?php cb_sitename_text();

    }

/**
 * Off canvas Toggle handle for left panel
 */
function cb_offcanvas_toggle_left() { ?>
    <!-- left panel toggler -->
    <a id="panel-left-toggle" href="#panel-left" class="" title="<?php _e( 'Öffne linkes Panel', 'social-portal' ); ?>"><i class="fa fa-bars"></i></a>
<?php
}

/**
 * Offcanvas toggle Handle for right panel
 */
function cb_offcanvas_toggle_right() { ?>
    <!-- right panel toggler -->
    <a id="panel-right-toggle" class="" href="#panel-right" title="<?php _e( 'Öffne rechtes Panel', 'social-portal' ); ?>"><i class="fa fa-bars"></i></a>
<?php
}

/**
 * Primary Menu block
 * 
 * Generate Primary Menu
 */
function cb_primary_menu() {
	//if a nav menu is not assigned to the primary menu, do not show anything
	if ( ! has_nav_menu( 'primary' ) ) {
		return ;
	}

	$menu_class= 'main-nav-' . cb_get_option( 'main-nav-alignment', 'left' );
	wp_nav_menu( array( 
		'container'			=> false, 
		'menu_id'			=> 'nav', 
		'menu_class'		=> 'main-menu '. $menu_class,
		'items_wrap'		=> '<div  id="%1$s" class="%2$s"> <ul>%3$s</ul></div>', 
		'theme_location'	=> 'primary', 
		'fallback_cb'		=> 'cb_main_nav'
	) );
}

/**
 * Search form block
 * 
 * Generate Search form
 * 
 */
function cb_search_form() { ?>
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" id="search-form" class="search-form">
		<label for="search-terms" class="accessibly-hidden"><?php _e( 'Suchen nach:', 'social-portal' ); ?></label>
		<input type="text" id="search-terms" name="s" value="<?php echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" placeholder="<?php _ex( 'Suchbegriff eingeben', 'Suche-Platzhaltertext', 'social-portal' ); ?>" />

		<button type="submit" name="search-submit" id="search-submit" > <i class="fa fa-search"></i></button>
	</form><!-- #search-form -->
	<?php 
}

/**
 * Display Search box in header
 */
function cb_header_search_form() {

	if ( cb_is_header_search_visible() ) {
		cb_search_form();
	}
}
/**
 * Account Links Block
 * 
 * Must be used inside a Ul element
 */
function cb_login_account_links() { ?>
	<?php if ( cb_is_bp_active() ): ?>

		<?php if ( is_user_logged_in() ) : ?>

            <?php if ( cb_get_option( 'header-show-notification-menu' ) ) : ?>
                <?php cb_notification_menu(); ?>
             <?php endif; ?>

            <?php if ( cb_get_option( 'header-show-account-menu' ) ) : ?>
			    <?php cb_account_menu(); ?>
             <?php endif; ?>

		<?php else: ?>

            <?php if ( cb_get_option( 'header-show-login-links' ) ) :?>

				<?php if ( bp_get_signup_allowed() ) : ?>
					<li><a href="<?php echo bp_get_signup_page(); ?>" class='btn header-button header-register-button bp-ajaxr'><?php _e( 'Registrieren', 'social-portal' ); ?></a></li>
				<?php endif; ?>
				<li><a href="<?php echo wp_login_url(); ?>" class='btn header-button header-login-button bp-ajaxl' title="<?php _e( 'Einloggen', 'social-portal' ); ?>"><?php _e( 'Einloggen', 'social-portal' ); ?></a></li>

			<?php endif; ?>

		<?php endif; ?>

	<?php endif;//buddypress active block end ?>
<?php 
}

/**
 * Generate social links menu
 * 
 */
function cb_social_links() {
	
	$links = array(
		'facebook'		=> '<i class="fa fa-facebook-official"></i>',
		'twitter'		=> '<i class="fa fa-twitter-square"></i>',
		'google-plus'	=> '<i class="fa fa-google-plus-square"></i>',
		'linkedin'		=> '<i class="fa fa-linkedin-square"></i>',
		'instagram'		=> '<i class="fa fa-instagram"></i>',
		'flickr'		=> '<i class="fa fa-flickr"></i>',
		'youtube'		=> '<i class="fa fa-youtube"></i>',
		'vimeo'			=> '<i class="fa fa-vimeo-square"></i>',
		'pinterest'		=> '<i class="fa fa-pinterest"></i>',

	);

	$html = "";
	foreach ( $links as $key => $icon ) {
		$url = cb_get_option( 'social-' . $key );
		if ( $url ) {
			$html .= "<li><a href='{$url}'>{$icon}</a></li>";
		}
	}
	
	//for email
	$email = cb_get_option( 'social-email' );
	
	if ( $email ) {
		$html .= "<li><a href='mailto:{$email}'><i class='fa fa-envelope-o'></i></a></li>";
	}

	//append rss link if enabled
	
	if ( ! cb_get_option( 'hide-rss' ) ) {
		$url = cb_get_option( 'social-custom-rss' );

		if ( ! $url ) {
			$url = get_feed_link();
		}

		$html .= "<li><a href='{$url}'><i class='fa fa-rss-square'></i></a></li>";
	}
	
	if ( ! empty( $html ) ) {
		$html = "<ul class='social-links'>" . $html . "</ul>";
	}
	
	echo $html;
}


/**
 * Fallback for get_custom_logo()
 *
 * Returns a custom logo, linked to home.
 */
function cb_get_fallback_custom_logo() {
	$html = '';

	$logo = get_theme_mod('logo' );
	// We have a logo. Logo is go.
	if ( $logo ) {
		$custom_logo_attr = array(
			'class'    => 'custom-logo',
			'itemprop' => 'logo',
		);

		$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );

		/*
		 * If the alt attribute is not empty, there's no need to explicitly pass
		 * it because wp_get_attachment_image() already adds the alt attribute.
		 */
		$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
			esc_url( home_url( '/' ) ),
			"<img src='{$logo}' alt='' class='custom-logo-1' />"
		);
	}

	// If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
    elseif ( is_customize_preview() ) {
		$html = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo-7"/></a>',
			esc_url( home_url( '/' ) )
		);
	}

	return $html;
}

/**
 * Print site name as text for use in place of logo.
 */
function cb_sitename_text() {

	$logo_text_class = '';

	if ( function_exists( 'the_custom_logo' ) ) {
		$has_logo = has_custom_logo();
	} else {
		$has_logo = cb_get_option( 'logo' );
	}

	if ( $has_logo ) {
		$logo_text_class = 'hidden-logo';
	}

	?>
    <?php if ( ! $has_logo || $has_logo && is_customize_preview() ): ?>
    <span class="logo-text <?php echo $logo_text_class;?>">
				<a href="<?php echo home_url(); ?>" title="<?php _ex( 'Startseite', 'Titel des Homepage-Logo-Links', 'social-portal' ); ?>">
                    <?php bloginfo( 'name' ); ?>
                </a>
			</span>
    <?php endif; ?>
<?php
}
