<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
		<!--[if lt IE 9]>
			<script src="<?php echo combuilder()->get_url();?>/assets/js/html5shiv.js"></script>
		<![endif]-->
		
		<?php wp_head(); ?>
		
		<?php 
		//Any custom Head js?
			$custom_scripts = cb_get_option( 'custom-head-js' );
		    if ( ! empty( $custom_scripts ) ) {
				echo $custom_scripts;
			}
		?>
		
	</head>

	<body <?php body_class( cb_get_theme_layout_class() ); ?> id="social-portal">
		<h1 class="accessibly-hidden"><?php bloginfo( 'name' ) ; ?></h1>
		<div id='page'>

			<?php do_action( 'cb_before_header' ); ?>

			<?php if ( cb_has_header_enabled() ): ?>
				<header id="header" class="site-header clearfix">

					<?php
					/**
					 * Never ever, never ever comment the below line, It is used to build the header layout
					 * For more details, Please see
					 * lib/framework/layout-builder/cb-page-builder.php &
					 * lib/framework/layout-builder/cb-site-header-generator.php
					 *
					 */
					 ?>
					<?php do_action( 'cb_header' ); ?>

				</header><!-- #header -->
			<?php endif; ?>

			<?php do_action( 'cb_after_header' ); ?>
			
			<?php do_action( 'cb_before_container' ); 
