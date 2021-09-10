<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Load the main page header section
 * 
 * Locates the template from current child theme/Theme use filter to override the loaded template part
 * 
 */
function cb_load_page_header() {
	if ( cb_show_page_header() ) {
        $template = apply_filters( 'cb_page_header_template_part', 'template-parts/page-header' );
		get_template_part(  $template );
	}
}

/**
 * Injects header background image for posts/blog/directory section which is later processed by imgLiquid plugin to
 *  have a nice looking header
 * @return string
 */
function cb_get_header_image() {
    $object_id = get_queried_object_id();
    $image_url = '';

    //is term archive?
    if ( is_category() || is_tax() ) {

        //pre 4.4 the term meta did not exist
        if ( function_exists( 'get_term_meta' ) ) {
            $image_url = get_term_meta( $object_id, 'cb-header-image', true ) ;
        }
        //fallback
        if ( ! $image_url ) {
            $image_url = get_theme_mod( 'archive_header_image' );
        }
    } elseif ( is_404() ) {
        $image_url = get_theme_mod( '404_header_image' );
    } elseif ( is_search() ) {
        $image_url = get_theme_mod( 'search_header_image' );
    } elseif ( $object_id ) {
        $image_url = get_post_meta( $object_id, 'cb-header-image', true );
    }
    //fallback
	if ( empty( $image_url ) ) {
		$image_url = get_header_image();
	}

    $image_url = apply_filters( 'cb_custom_header_image_url', $image_url );
   
    return $image_url;
}


function cb_get_page_header_contents() {
	$title = $content = $meta = '';

	if ( cb_is_wc_active() && is_woocommerce() ) {
		$title = woocommerce_page_title(false );

		/*if (  is_product()  ) {
			ob_start(); // Can not use rating as the $product is not initialized yet.
			woocommerce_template_single_rating();
			$meta = ob_get_clean();
		}*/

	} elseif ( is_singular() ) {
		$title = get_the_title();
	} elseif ( is_search() ) {
		$title = sprintf( esc_html__( 'Suchergebnisse für: %s', 'social-portal' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
	}  elseif ( is_archive() ) {
		$title = get_the_archive_title( '', '' );
		$meta = get_the_archive_description( '<span class="taxonomy-description">', '</span>' );
	} elseif ( is_404() ) {
		$meta = '<i class="fa fa-user-secret"></i>' . __( '404, Inhalt nicht gefunden!', 'social-portal' );
	}

	if ( $title ) {
		$content .= "<div class='page-header-title'>{$title}</div>";
	}

	if( $meta ) {
		$content .="<div class='page-header-meta'>{$meta}</div>";
	}

	return apply_filters( 'cb_page_header_contents', $content, $title, $meta );
}