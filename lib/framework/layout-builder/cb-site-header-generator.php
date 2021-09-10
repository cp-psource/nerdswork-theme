<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * All the site header styles
 */


/* Header Layout Default
 * 
 * |------------------------------------|
 * | Logo -| menu |Account/Login--|<- main row
 * |------------------------------------|
 * 
 */

function cb_header_layout_default() {


	//main row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );

	add_action( 'cb_header_main_row', 'cb_header_middle' );

	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_primary_menu' );


	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );
	//add_action( 'cb_header_right', 'cb_header_social_links' );
}

/* Header Layout 2
 * 
 * |---------------Social Links---------|<- top bar/first row
 * |------------------------------------|
 * | Logo -| Menu|Account/Login--|<- main row
 * |------------------------------------|

 */

function cb_header_layout_2() {


	//row 1
	add_action( 'cb_header', 'cb_header_top_row' );

	//2nd row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//
	
	//Adding contents to first row
	//social links to the top row
	add_action( 'cb_header_top_row', 'cb_header_social_links' );

	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );
	add_action( 'cb_header_main_row', 'cb_header_middle' );
	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_primary_menu' );

	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );
}

/* Header Layout 3
 * 
 * |--Menu---|-----Social Links---------|<- top bar/first row
 * |------------------------------------|
 * | Logo -| Search Form |Account/Login--|<- main row
 * |------------------------------------|

 */

function cb_header_layout_3() {


	//row 1
	add_action( 'cb_header', 'cb_header_top_row' );

	//2nd row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//
	
	//Adding contents to first row
	//social links to the top row
	add_action( 'cb_header_top_row', 'cb_primary_menu' );
	add_action( 'cb_header_top_row', 'cb_header_social_links' );

	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );
	add_action( 'cb_header_main_row', 'cb_header_middle' );
	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_header_search_form' );


	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );
}

/* Header Layout 4
 * 
 * |--Search form---|-----Social Links---------|<- top bar/first row
 * |------------------------------------|
 * | Logo -| Search Form |Account/Login--|<- main row
 * |------------------------------------|

 */

function cb_header_layout_4() {


	//row 1
	add_action( 'cb_header', 'cb_header_top_row' );

	//2nd row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//
	
	//Adding contents to first row
	//social links to the top row
	add_action( 'cb_header_top_row', 'cb_header_search_form' );
	add_action( 'cb_header_top_row', 'cb_header_social_links' );

	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );
	add_action( 'cb_header_main_row', 'cb_header_middle' );
	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_primary_menu' );


	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );
}

/* Header Layout 7
 * 
 * |------------------------------------|
 * | Logo -| Search |Account/Login--|<- main row
 * |------------------------------------|
 * | -------------menu ----------|
 */

function cb_header_layout_5() {



	//main row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//bottom row
	add_action( 'cb_header', 'cb_header_bottom_row' );


	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );

	add_action( 'cb_header_main_row', 'cb_header_middle' );

	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_header_search_form' );


	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );
	//add_action( 'cb_header_right', 'cb_header_social_links' );

	add_action( 'cb_header_bottom_row', 'cb_primary_menu' );
}


/* Header Layout 6
 *
 * |------------------------------------|
 * | Logo -| Menu |Account/Login--|<- main row
 * |------------------------------------|
 * | -------------Search form ----------|
 */

function cb_header_layout_6() {


	//main row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//bottom row
	add_action( 'cb_header', 'cb_header_bottom_row' );


	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );

	add_action( 'cb_header_main_row', 'cb_header_middle' );

	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_primary_menu' );


	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );
	//add_action( 'cb_header_right', 'cb_header_social_links' );

	add_action( 'cb_header_bottom_row', 'cb_header_search_form' );
}

/* Header Layout 7
 * 
 * |---------------Social Links---------|<- top bar/first row
 * |------------------------------------|
 * | Logo -| Menu|Account/Login--|<- main row
 * |------------------------------------|
 * |---------------Search form ----------------|<- Third/bottom row
 */

function cb_header_layout_7() {

	//row 1
	add_action( 'cb_header', 'cb_header_top_row' );

	//2nd row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//row 3
	add_action( 'cb_header', 'cb_header_bottom_row' ); //3rd row
	//
	
	//Adding contents to first row
	//social links to the top row
	add_action( 'cb_header_top_row', 'cb_header_social_links' );

	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );
	add_action( 'cb_header_main_row', 'cb_header_middle' );
	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_primary_menu' );

	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );

	//Adding content to 3rd row
	add_action( 'cb_header_bottom_row', 'cb_header_search_form' );
}
/* Header Layout 1
 * 
 * |---------------Social Links---------|<- top bar/first row
 * |------------------------------------|
 * | Logo -| Search From|Account/Login--|<- main row
 * |------------------------------------|
 * |---------------Menu ----------------|<- Third/bottom row
 */

function cb_header_layout_8() {


	//row 1
	add_action( 'cb_header', 'cb_header_top_row' );

	//2nd row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//row 3
	add_action( 'cb_header', 'cb_header_bottom_row' ); //3rd row
	//
	
	//Adding contents to first row
	//social links to the top row
	add_action( 'cb_header_top_row', 'cb_header_social_links' );

	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );
	add_action( 'cb_header_main_row', 'cb_header_middle' );
	add_action( 'cb_header_main_row', 'cb_header_right' );

	add_action( 'cb_header_middle', 'cb_header_search_form' );

	//Account, Notification/Login,register Links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );

	//Adding content to 3rd row
	add_action( 'cb_header_bottom_row', 'cb_primary_menu' );
}

/* Header Layout 9
 * 
 * | Menu ------ | Social Links---------|<- top bar/first row
 * |------------------------------------|
 * | Logo --------------|Account/Login--|<- main row
 * |------------------------------------|
 * | Search Form -----------------------|<- Third/bottom row
 */

function cb_header_layout_9() {



	//row 1
	add_action( 'cb_header', 'cb_header_top_row' );

	//2nd row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//row 3
	add_action( 'cb_header', 'cb_header_bottom_row' ); //3rd row
	//Adding contents to first row
	//Add menu 
	add_action( 'cb_header_top_row', 'cb_primary_menu' );
	//social menu
	add_action( 'cb_header_top_row', 'cb_header_social_links' );

	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );
	add_action( 'cb_header_main_row', 'cb_header_right' );
	//social links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );

	//Adding content to 3rd row
	add_action( 'cb_header_bottom_row', 'cb_header_search_form' );
}

/* Header Layout 10
 * 
 * | Search Form -- | Social Links---------|<- top bar/first row
 * |---------------------------------------|
 * | Logo --------------|Account/Login-----|<- main row
 * |---------------------------------------|
 * |  Menu---------------------------------|<- Third/bottom row
 */

function cb_header_layout_10() {
	//row 1
	add_action( 'cb_header', 'cb_header_top_row' );

	//2nd row
	add_action( 'cb_header', 'cb_header_main_row' ); //first row
	//row 3
	add_action( 'cb_header', 'cb_header_bottom_row' ); //3rd row
	//Adding contents to first row
	//Add searchbox
	add_action( 'cb_header_top_row', 'cb_header_search_form' );
	//social menu
	add_action( 'cb_header_top_row', 'cb_header_social_links' );

	//Adding contents to the main row
	//Left toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_left' );
	//Right toggle
	add_action( 'cb_header_main_row', 'cb_offcanvas_toggle_right', 5000 );

	//Logo
	add_action( 'cb_header_main_row', 'cb_site_branding' );
	add_action( 'cb_header_main_row', 'cb_header_right' );
	//social links
	add_action( 'cb_header_right', 'cb_header_links' );
	add_action( 'cb_header_links', 'cb_login_account_links' );

	//Adding content to 3rd row
	add_action( 'cb_header_bottom_row', 'cb_primary_menu' );
}
