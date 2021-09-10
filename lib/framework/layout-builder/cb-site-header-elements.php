<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * The top horizontal bar(optional)
 */
function cb_header_top_row() {
?>	<!-- top horizontal logo/search bar -->
	<div id="header-top-row" role="banner" class="site-header-row">
		<div class="inner clearfix">
			<?php do_action( 'cb_header_top_row' ); ?>
		</div> <!-- end of .inner -->
	</div>
	<!-- end of #header-top-row -->
	<?php
}

/**
 * Main Header Row
 */
function cb_header_main_row() {
	?>
	<!-- main horizontal logo/search bar -->
	<div id="header-main-row" class="site-header-row">
		<div class="inner clearfix">
			<?php do_action( 'cb_header_main_row' ); ?>
		</div> <!-- end of .inner -->
	</div><!-- end of #header-main-row -->
	<?php
}

/**
 * The 3rd horizontal bar(optional, just below header)
 */
function cb_header_bottom_row() {
?>
	<!-- top horizontal logo/search bar -->
	<div id="header-bottom-row" class="site-header-row" >
		<div class="inner clearfix">
			<?php do_action( 'cb_header_bottom_row' ); ?>
		</div> <!-- end of .inner -->
	</div><!-- end of #header-bottom-row -->
	<?php
}

/**
 * Global Header layout Block
 * See lib/framework/builder.php to see how they are used
 */


/**
 * Container for header middle
 * 
 */
function cb_header_middle() { ?>
	<!-- search bar -->
	<div id="header-middle">
		<?php do_action( 'cb_header_middle' ); ?>
	</div><!-- #search-bar -->
<?php 
}

/**
 * Container used for header right
 */
function cb_header_right() { ?>
	<div id="header-right">
		<?php do_action( 'cb_header_right' ); ?>
	</div><!-- end of header right -->
<?php 
}

/**
 * Container for account/notification/register links
 */
function cb_header_links() { ?>
	<ul class='header-links'>
		<?php do_action( 'cb_header_links' ); ?>
	</ul>
<?php 	
}

function cb_header_social_links () {
    if ( cb_get_option( 'header-show-social' ) ) {
        cb_social_links();
    }
}

function cb_footer_social_links() {
    if ( cb_get_option( 'footer-show-social' ) ) {
       cb_social_links();
    }
}
