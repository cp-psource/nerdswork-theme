<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit( 0 );
}

/**
 * Template tags t be used in theme templates
 *
 */
/**
 * Is post title visible
 * Checks whether the post title should be shown inside the <article> tag.
 * When the Page header is visible, It is off by default
 *
 * @param int $post_id
 * @return boolean
 */
function cb_is_post_title_visible( $post_id = 0 ) {

	$visible = false;
	if ( is_page() && cb_get_option( 'page-show-title' ) ) {
		$visible = true;
	} elseif ( is_singular() && cb_get_option( get_post_type() . '-show-title', cb_get_default( 'post-show-title' ) ) ) {
		$visible = true;
	}

	return apply_filters( 'cb_post_title_visible', $visible, $post_id );
}

/**
 * Get the appropriate comment count message
 * 
 * @global WP_Post $post
 * @return string
 *
 */
function cb_get_comment_count() {

	$comment_count = get_comments_number();

	if ( comments_open() && $comment_count >= 0 ) {
		return get_comments_number_text( __( 'Keine Kommentare', 'social-portal' ), __( 'Eine Antwort', 'social-portal' ), __( '% Antworten', 'social-portal' ) );
	} else {
		return __( 'Kommentarfunktion ist geschlossen', 'social-portal' );
	}
}

/**
 * Get post entry header meta
 * 
 * @return string
 */
function cb_get_article_header_meta() {

	$show = false;

	if ( is_singular() ) {
		$post_type = get_post_type();
		$show = cb_get_option( $post_type . '-show-article-header', cb_get_default( 'post-show-article-header' ) );
	} elseif ( is_search() || is_archive() || is_home() ) {
		$show = cb_get_option( 'archive-show-article-header' );
	}

	$meta = '';

	if ( $show ) {

		if ( is_singular() ) {
			$meta = cb_get_option( $post_type . '-header', cb_get_default( 'post-header' ) );
		} else {
			$meta = cb_get_option( 'post-header', cb_get_default( 'post-header' ) );
		}
	}


	return apply_filters( 'cb_article_header_meta', $meta );
}

/**
 * Get Post entry footer meta
 * 
 * @return string
 */
function cb_get_article_footer_meta() {

	$show = false;

	if ( is_singular() ) {
		$post_type = get_post_type();
		$show = cb_get_option( $post_type . '-show-article-footer', cb_get_default( 'post-show-article-footer' ) );
	} elseif ( is_search() || is_archive() ) {
		$show = cb_get_option( 'archive-show-article-footer' );
	}

	$meta = '';

	if ( $show ) {
		if ( is_singular() ) {
			$meta = cb_get_option( $post_type . '-footer', cb_get_default( 'post-footer' ) );
		} else {
			$meta = cb_get_option( 'post-footer', cb_get_default( 'post-footer' ) );
		}
	}

	return apply_filters( 'cb_article_footer_meta', $meta );
}

/**
 * Should we show the post thumbnail?
 * 
 * @return boolean
 */
function cb_show_post_thumbnail() {

    $show = true;
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        $show = false;
    } elseif( is_page() && ! cb_get_option( 'page-show-featured-image' )) {
        $show = false;
   } elseif ( is_singular() && ! cb_get_option( get_post_type() . '-show-featured-image' , cb_get_default( 'post-show-featured-image' ) ) ) {
        $show = false ;
    } elseif ( ! is_singular() && ! cb_get_option( 'archive-show-featured-image' ) ) {
        $show = false;
    }

    return apply_filters( 'cb_show_post_thumbnail', $show );
}

/**
 * Functions used to generate html content and used inside the theme as template tags
 **/

/**
 * Prints the html code for post thumbnail
 */
function cb_post_thumbnail( $size = '' ) {

    if ( ! cb_show_post_thumbnail() ) {
        return ;
    }

    //if size is not given, let us try o guess it
    if ( empty ( $size ) && is_singular() ) {
	    if ( cb_has_sidebar_enabled() ) {
		    $size = 'featured-mid';//782
	    } else {
		    $size = 'featured-large';//1220
	    }
    } elseif ( empty( $size ) ) {
	    //it is archive page
	    $display = cb_get_posts_display_type();
	    if ( $display == 'masonry' ) {
		    $size = 'thumbnail';
	    } elseif ( cb_has_sidebar_enabled() ) {
		    $size = 'featured-mid';
	    } else {
		    $size = 'featured-large';
	    }
    }
	//let theme use thumbnail and then convert to internal
    if ( $size == 'thumbnail' ) {
		$size = 'post-thumbnail';
	}

	?>
    <?php if ( is_singular() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( $size ); ?>
        </div><!-- .post-thumbnail -->
    <?php else : ?>
        <a class="post-thumbnail" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( $size, array( 'alt' => get_the_title() ) ); ?>
        </a>
    <?php endif; // End is_singular()?>
	<?php
}

/**
 * Prints the Generated Pagination links
 */
function cb_pagination() {

    if ( function_exists( 'the_posts_pagination' ) ) {

        the_posts_pagination( array(
            'prev_text'             => '<i class="fa fa-arrow-circle-left"></i>',
            'next_text'             => '<i class="fa fa-arrow-circle-right"></i>',
            'before_page_number'    => '', // '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'social-portal' ) . ' </span>',
            'type'                  => 'list'
        ) );
    }
}

/**
 * Check if we have a breadcrumb plugin active?
 *
 * @return mixed|void
 */
function cb_is_breadcrumb_plugin_active() {
	$is_enabled = 0;
	if ( function_exists( 'bcn_display' ) ) {
		$is_enabled = true;
	} elseif ( function_exists( 'breadcrumb_trail' ) ) {
		$is_enabled = 1;
	}

	return apply_filters( 'cb_breadcrumb_plugin_active', $is_enabled );
}

/**
 * @todo add template control to enable/disable it
 * Checks if the plugins for breadcrumb exists or not?
 *
 * @return type
 */
function cb_is_breadcrumb_enabled() {

    $is_enabled = false;

   if ( cb_is_breadcrumb_plugin_active() ) {
        $is_enabled = true;
    } elseif( cb_is_psf_active() && is_psforum() ) {
	    $is_enabled = true;
    } elseif( cb_is_wc_active() && is_woocommerce() ) {
		$is_enabled = true;
    }

    return apply_filters( 'cb_breadcrumb_enabled', $is_enabled );
}

/**
 * Generate breadcrumb links
 */
function cb_breadcrumb() {

    if ( function_exists( 'bcn_display' ) ) {
        bcn_display();
    } elseif ( function_exists( 'breadcrumb_trail' ) ) {
        breadcrumb_trail( cb_get_breadcrumb_args() );
    } elseif( cb_is_psf_active() && is_psforum() ) {
    	psf_breadcrumb(); //worst case, always show psf breadcrumb
    } elseif ( cb_is_wc_active() && is_woocommerce() ) {
	    woocommerce_breadcrumb();
    }

    do_action( 'cb_breadcrumb' );
}

/**
 * Get args for breadcrumb trail plugin
 *
 * @return array
 */
function cb_get_breadcrumb_args() {
    $args = array(
    	'before'        => false,
	    'separator'     => ' /',
	    'show_on_front' => false,
	    'show_browse'   => false,
    );

    return apply_filters( 'cb_bredcrumb_args', $args );
}

/**
 * Load breadcrumb template
 *
 */
function cb_load_breadcrumbs() {
    get_template_part( 'template-parts/breadcrumb' );
}

/**
 * Load Feedback template
 *
 */
function cb_load_site_feedback_message() {
	get_template_part( 'template-parts/site-feedback-message' );
}

/**
 * If it is today, returns time else day
 * based on bp_core_format_time
 *
 * @param float $time
 * @param boolean $exclude_time
 * @param boolean $gmt
 * @return boolean
 */
function cb_get_time_or_date( $time = '', $exclude_time = false, $gmt = true ) {

    // Bail if time is empty or not numeric
    if ( empty( $time ) || ! is_numeric( $time ) ) {
        return false;
    }

    // Get GMT offset from root blog
    if ( true === $gmt ) {

        // Use Timezone string if set
        $timezone_string = bp_get_option( 'timezone_string' );
        if ( ! empty( $timezone_string ) ) {
            $timezone_object = timezone_open( $timezone_string );
            $datetime_object = date_create( "@{$time}" );
            $timezone_offset = timezone_offset_get( $timezone_object, $datetime_object ) / HOUR_IN_SECONDS;

            // Fall back on less reliable gmt_offset
        } else {
            $timezone_offset = bp_get_option( 'gmt_offset' );
        }

        // Calculate time based on the offset
        $calculated_time = $time + ( $timezone_offset * HOUR_IN_SECONDS );

        // No localizing, so just use the time that was submitted
    } else {
        $calculated_time = $time;
    }

    $today = current_time( 'Y-m-d', $gmt );

    $message_day = date( 'Y-m-d', $calculated_time );

    if ( $today == $message_day ) {
        $format = 'h:i a';
    } else {
        $format = 'M j'; //Nov 27
    }

    // Formatted date: "March 18, 2014"
    $formatted_date = date_i18n( $format, $calculated_time, $gmt );

    return apply_filters( 'cb_time_or_date', $formatted_date, $calculated_time );
}

/**
 * wp_nav_menu() callback from the main navigation in header.php
 *
 * Used when the custom menus haven't been configured.
 *
 * @param array Menu arguments from wp_nav_menu()
 * @see wp_nav_menu()
 */
function cb_main_nav( $args ) {
    $pages_args = array(
        'depth'      => 1,
        'echo'       => false,
        'exclude'    => '',
        'title_li'   => ''
    );

    $menu = wp_page_menu( $pages_args );
    $menu = str_replace( array( '<div class="menu"><ul>', '</ul></div>' ), array( '<div id="nav" class="main-menu"><ul>', '</ul></div><!-- #nav -->' ), $menu );
    echo $menu;
}

/**
 * Display navigation to next/previous pages when applicable
 *
 * @global WP_Query $wp_query
 * @param string $nav_id DOM ID for this navigation
 */
function cb_content_nav( $nav_id ) {
    global $wp_query;

    if ( ! empty( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) : ?>
        <div id="<?php echo $nav_id; ?>" class="navigation clearfix">
            <div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'social-portal' ) ); ?></div>
            <div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'social-portal' ) ); ?></div>
        </div><!-- #<?php echo $nav_id; ?> -->
    <?php endif;
}

/**
 * Get the current selected display style for the archive posts
 *
 * @return string masonry|standard
 */
function cb_get_posts_display_type() {
	$display_type = cb_get_option( 'archive-posts-display-type' );

	if ( is_front_page() ) {
		$display_type =  cb_get_option( 'home-posts-display-type' );
	} elseif ( is_search() ) {
		$display_type = cb_get_option( 'search-posts-display-type' );
	}

	return apply_filters( 'cb_posts_display_type', $display_type );
}

/**
 * Get no. of cols per row for the current displayed list
 *
 * @return int
 */
function cb_get_post_list_column_count() {
	$key = 'archive-posts-per-row';

	if ( is_front_page() ) {
		$key = 'home-posts-per-row';
	} elseif ( is_search() ) {
		$key = 'search-posts-per-row';
	}

	return cb_get_option( $key );
}

function cb_is_posts_list_using_masonry() {

	if ( cb_get_posts_display_type() == 'masonry' ) {
		return true;
	}

	return false;
}

function cb_is_search_page_using_masonry () {
	return cb_get_option( 'search-posts-display-type' ) == 'masonry';
}

function cb_is_archive_page_using_masonry () {
	return cb_get_option( 'archive-posts-display-type' ) == 'masonry';
}

function cb_is_home_page_using_masonry () {
	return cb_get_option( 'home-posts-display-type' ) == 'masonry';
}

/**
 *
 * Get css class for the post entry
 *
 * @param string $class
 *
 * @return string
 */
function cb_get_post_display_class( $class = '' ) {

	if ( is_archive() || is_front_page() || is_search() ) {
		$display_type = cb_get_posts_display_type();
		$class .= ' post-display-type-' . $display_type ;

		if ( $display_type == 'masonry' ) {
			$class .= ' ' . cb_get_item_grid_class( cb_get_post_list_column_count() );//archive-posts-per-row
		}
	}

	return $class;
}

/**
 * Get the css class list to apply on posts list
 *
 * @param string $class
 *
 * @return string list of css classes to apply
 */
function cb_get_posts_list_class( $class = '' ) {

	//let us take the archive layout as default
	$display_type = cb_get_posts_display_type();

	$class .= ' posts-list posts-display-' . $display_type;

	if ( $display_type == 'masonry' || $display_type == 'grid' ) {
		$class .= ' row';//add bs row
	}

	$class = apply_filters( 'cb_posts_list_css_class', $class, $display_type );
	return $class;
}

/**
 * How many columns per row for the context
 *
 * @param $context
 *
 * @return string
 */
function cb_get_item_grid_cols( $context ) {

	$key  = $context . '-per-row';
	$cols = cb_get_option( $key, cb_get_default( $key ) );

	if ( empty( $cols ) ) {
		$cols = 'auto';
	}

	$cols = apply_filters( 'cb_item_grid_cols', $cols, $context );

	return $cols;
}

/**
 * Get the grid specific css classes to be applied to various buddyPress lists
 *
 * @param $context
 *
 * @return mixed
 */
function cb_bp_get_item_class( $context ) {
	//we need the layout for current page to decide the number of column
	//that only applies for md/lg
	//bp-members-per-page, bp-groups-per-page
    $display_type = cb_bp_get_item_display_type();

    if ( $display_type == 'standard' ) {
       $grid_cols = 1;
    }elseif ( $context == 'members' ) {
        $grid_cols = cb_bp_get_members_per_row();
    } elseif ( $context == 'groups' ) {
        $grid_cols = cb_bp_get_groups_per_row();
    }elseif ( $context == 'blogs' ) {
        $grid_cols = cb_bp_get_blogs_per_row();
    } else {
	    $grid_cols = cb_get_item_grid_cols( 'bp-' . $context );
    }

	//$grid_cols = cb_get_item_grid_cols( 'bp-' . $context );
    //we may drop this block in future since we have already added the column hinting now
	if ( $grid_cols && $grid_cols != 'auto' ) {
		$cols = $grid_cols;
	} elseif ( cb_has_sidebar_enabled()  && ( bp_is_user() || bp_is_group() ) ) {
		//cb_has_sidebar_enabled is not very useful while doing ajax
		//if the admin has not defined the grid columns and the page has sidebar
		$cols = 2;
	} else {
		//should never happen, still a fallback for 3 cols
		$cols = 3;
	}

	//override for group invite, it is special case
	//if (  bp_is_group() && bp_is_group_invites() ) {
		//$cols = 2;
	//}

	$classes = cb_get_item_grid_class( $cols );

	if (  cb_get_option( 'bp-item-list-use-gradient' ) ) {
		$classes .= ' item-gradient';
	}

	return apply_filters( 'cb_bp_item_grid_class', $classes, $context );
}

/**
 * Generates appropriate col-xyz-class names based on the given column count
 *
 * @param int $cols column count
 *
 * @return string
 */
function cb_get_item_grid_class( $cols ) {
	//do not allow mischief
	if ( intval( $cols ) <= 0 ) {
		return '';
	}

	$grid_class_suffix = absint( 12 / $cols );
	// we have a 12 col grid, we divide that by col count to get the grid class

	$classes = "col-xs-12 col-sm-6 col-md-{$grid_class_suffix} col-lg-{$grid_class_suffix}"; //for md/lg we care, for rest we don't

	return apply_filters( 'cb_item_grid_class', $classes, $cols );
}

/**
 * Truncate the content of current post
 *
 * @uses maximus_truncate_post()
 *
 * @param int $length
 */
function cb_truncate_post( $length = 0 ) {

	if ( ! $length ) {
		$length = get_post_thumbnail_id() ? '100' : '230';
	}

    if ( function_exists( 'maximus_truncate_post' ) && maximus_pb_is_pagebuilder_used( get_the_ID() ) ) {
        maximus_truncate_post( $length );
    } else {
        echo get_the_excerpt();
    }
}

/**
 * Get the contents to be shown in the footer copyright section
 *
 * @return mixed|void
 */
function cb_get_footer_copyright() {
    $content = cb_get_option( 'footer-text' );
    $content = str_replace( '[current-year]', date('Y'), $content );

    return apply_filters( 'cb_footer_copyright_contents', $content );
}

/**
 * Checks if we have a feedback to show?
 *
 * @return bool
 */
function cb_has_feedback_message() {

	if ( cb_is_bp_active() && ! empty( buddypress()->template_message ) ) {
		return true;
	}

	return false;
}

/**
 * Get the current feedback type
 *
 * Must be used if BuddyPress is active
 *
 * @return mixed|string
 */
function cb_get_feedback_message_type() {

	$bp = buddypress();
	$message_type = isset( $bp->template_message_type ) ? $bp->template_message_type : 'success';
	$type         = ( 'success' === $message_type ) ? 'updated' : 'error';

	return $type;
}

/**
 * displays account menu
 */
function cb_user_account_menu() {

	$adminbar = combuilder()->adminbar();

	if ( ! $adminbar ) {
		return ;//
	}

	//display Dashboard Links?

	$adminbar->sites();

	$adminbar->account();

	//display logout button?

}

/**
 * Displays notification menu
 */
function cb_notification_menu_links() {

	$adminbar = combuilder()->adminbar();

	if ( $adminbar ) {
		$adminbar->notifications();
	}
}
