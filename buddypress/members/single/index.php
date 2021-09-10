<?php
/**
 * BuddyPress - Users Home
 * Main Template Used to render All Profile Views
 *
 */
get_header( "buddypress" );
?>

<?php if ( cb_show_members_header() ):?>

    <div id="item-header" role="complementary" class="page-header">
        <div class="page-header-mask"></div>
        <div class="inner item-header-inner clearfix">
            <?php bp_locate_template( array( 'members/single/member-header.php' ), true ); ?>
        </div>
    </div><!-- #item-header -->

<?php endif;?>

<?php if ( cb_show_members_horizontal_main_nav() ) :?>

    <div id="item-nav">
        <div class="inner clearfix">
            <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                <ul>
                    <?php bp_get_displayed_user_nav(); ?>
                    <?php do_action( 'bp_member_options_nav' ); ?>
                </ul>
            </div>
        </div>
    </div><!-- #item-nav -->

<?php endif;?>

<div id="container" class="inner-container <?php echo cb_get_page_layout_class(); ?>"><!-- main container -->

	<?php do_action( 'cb_before_container_contents' ); ?>

	<div class="inner clearfix ">

        <div id="content">
            <?php bp_get_template_part( 'members/single/home' ); ?>
        </div><!-- #content -->

	    <?php get_sidebar( "buddypress" ); ?>

	</div><!-- inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div><!-- #container -->       

<?php get_footer( "buddypress" ); ?>