<?php
/**
 * @package social-portal
 * Single Activity Page
 * Also referred as activity permalink page in BuddyPress
 *
 */

?>
<?php get_header( "buddypress" ); ?>

<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- section container -->

	<?php do_action( 'cb_before_container_contents' ); ?>

    <div class="clearfix inner">

        <section id="content">
			
			<?php do_action( 'cb_before_content_contents' ); ?>

			<?php bp_get_template_part( 'activity/single/home');?>

			<?php do_action( 'cb_after_content_contents' ); ?>

        </section><!-- #content -->

        <?php get_sidebar( "buddypress" ); ?>

    </div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( "buddypress" ); ?>
