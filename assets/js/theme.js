;var jq = jQuery;

jq( document ).ready( function () {

    SocialPortal.disable_main_menu_dropdown_icon = parseInt( SocialPortal.disable_main_menu_dropdown_icon );

    // Add dropdown angle in top main menu
    if( ! SocialPortal.disable_main_menu_dropdown_icon ) {
        jq('#nav>ul>li.menu-item-has-children>a').each( function() {
            jq(this).html( jq(this).text() + '<i class="fa fa-angle-down"></i>');
        });

    }


    // Left/right panel toggles
    jQuery( '#panel-left-toggle' ).panelslider();

    // Right panel
    jQuery( '#panel-right-toggle' ).panelslider( {
        bodyClass: 'ps-active-right',
        clickClose: true,
    } );

    // enable stackable menu
    enable_stackable_menu();

    // Masonry Posts
    var $container = jQuery('.posts-display-masonry');

    $container.imagesLoaded( function () {
        $container.masonry({
            columnWidth: '.post-display-type-masonry',
            itemSelector: '.post-display-type-masonry'
        });
    });

    // Right panel Menu, angle?
    jq('.panel-account-menu li.menupop>a').each( function() {
        jq(this).prepend('<span class="submenu-state-indicator submenu-closed"><i class="fa fa-angle-left"></i></span>');
    });

    // Panel Account Menu
    jq('.panel-account-menu li.menupop>a').click( function() {
        var $this = jq(this);
        $this.find('.fa').toggleClass('fa-angle-left, fa-angle-down');
        $this.parent().find('.nav-links-wrapper').toggle();
        return false;
    });

    //Should we enable fastclik on mobile devices
    if ( typeof FastClick !== 'undefined' ) {
        FastClick.attach( document.body );
    }

	// enable liquid image for thumbnails
    if ( SocialPortal.featured_image_fit_container ) {
        jQuery( '.has-post-thumbnail a.post-thumbnail' ).imgLiquid();
        jQuery( '.has-post-thumbnail div.post-thumbnail' ).imgLiquid();
    }

    if ( SocialPortal.enable_textarea_autogrow ) {
        // Make all textarea autogrowable.
        jQuery(document).on( 'focus', 'textarea', function () {
            autosize(this);
        });
    }

    // panel menu.
    jq.treeNav( '.panel-menu' );

	// setup scroll to top.
    jQuery.scrollUp({
        scrollName: 'scrollUp', // Element ID
        scrollDistance: 300, // Distance from top/bottom before showing element (px)
        scrollFrom: 'top', // 'top' or 'bottom'
        scrollSpeed: 300, // Speed back to top (ms)
        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
        animation: 'fade', // Fade, slide, none
        animationInSpeed: 200, // Animation in speed (ms)
        animationOutSpeed: 200, // Animation out speed (ms)
        scrollText: '<i class="fa fa-chevron-circle-up"></i>', // Text for element, can contain HTML
        scrollTitle: false, // Set a custom <a> title if required. Defaults to scrollText
        scrollImg: false, // Set true to use image
        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        zIndex: 2147483647 // hahaha, that is some z index. Not required to have this value but nothing wrong to have it Z-Index for the overlay
    });

    // Enable the Nice scrollbar in the left/right panel.
    var panel_left = document.querySelector('#panel-left');
    var panel_right = document.querySelector('#panel-right');

    if ( panel_left !== null ) {
        SimpleScrollbar.initEl( panel_left );
    }

    if ( panel_right !== null ) {
        SimpleScrollbar.initEl( panel_right );
    }

    /**
     * Enable stackable menu for items nav & profile Edit button nav.
     */
    function enable_stackable_menu() {
        //enable stack nave for user/group navigation
        jQuery('#object-nav ul').stackable({
            stackerLabel: '<i class="fa fa-bars fa-object-nav-bars"></i>'
        });
        //enable stack nav for directory
        var dir_item_tabs = jQuery( 'body.directory div.item-list-tabs ul').get(0);
        jQuery( dir_item_tabs).stackable({
            stackerLabel: '<i class="fa fa-bars fa-object-nav-bars"></i>'
        });

        //enable stack nav for Profile Edit groups
        jQuery('ul.button-nav').stackable({
            stackerLabel: '<i class="fa fa-bars fa-object-nav-bars"></i>'
        });

    }
} );

// tree function taken from AdminLTE and modified
jq.treeNav = function ( menu ) {

	var animationSpeed = 500;

    jq( 'li a', jq( menu ) ).on( 'click', function ( e ) {
		//Get the clicked link and the next element
		var jqthis = jq( this );
		var checkElement = jqthis.next();

		//Check if the next element is a menu and is visible
		if ( ( checkElement.is( '.treeview-menu' ) ) && ( checkElement.is( ':visible' ) ) ) {
			//Close the menu
			checkElement.slideUp( animationSpeed, function () {
				checkElement.removeClass( 'menu-open' );
			} );
			checkElement.parent( 'li' ).removeClass( 'active' );
		}
		//If the menu is not visible
		else if ( ( checkElement.is( '.treeview-menu' ) ) && ( !checkElement.is( ':visible' ) ) ) {
			//Get the parent menu
			var parent = jqthis.parents( 'ul' ).first();
			//Close all open menus within the parent
			var ul = parent.find( 'ul:visible' ).slideUp( animationSpeed );
			//Remove the menu-open class from the parent
			ul.removeClass( 'menu-open' );
			//Get the parent li
			var parent_li = jqthis.parent( 'li' );

			//Open the target menu and add the menu-open class
			checkElement.slideDown( animationSpeed, function () {
				//Add the class active to the parent li
				checkElement.addClass( 'menu-open' );
				parent.find( 'li.active' ).removeClass( 'active' );
				parent_li.addClass( 'active' );
				//Fix the layout in case the sidebar stretches over the height of the window
			} );
		}
		//if this isn't a link, prevent the page from being redirected
		if ( checkElement.is( '.treeview-menu' ) ) {
			e.preventDefault();
		}
	} );
};
