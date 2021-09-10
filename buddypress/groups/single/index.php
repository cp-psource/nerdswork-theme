<?php
/**
 * BuddyPress - groups Home
 * Main template Loader fro BuddyPress Single Group
 */
get_header( "buddypress" );
?>
	<?php if ( bp_has_groups() ) : ?>
		<?php while ( bp_groups() ) : bp_the_group(); ?>

			<?php do_action( 'bp_before_group_single_contents' ); ?>

			<div id="item-header" role="complementary" class="page-header">
				<div class="page-header-mask"></div><!-- mask -->
				<div class="inner item-header-inner clearfix">
					<?php bp_locate_template( array( 'groups/single/group-header.php' ), true ); ?>
				</div>
			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="inner clearfix">
					<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
						<ul>
							<?php bp_get_options_nav(); ?>
							<?php do_action( 'bp_group_options_nav' ); ?>
						</ul>
					</div>
				</div>
			</div><!-- #item-nav -->

		<?php endwhile; ?>
		
		<?php //Lesson of life: Never ever, never ever , Never ever put the group widget inside group loop, you will repent the outcome; ?>
		<div id="container" class="inner-container <?php echo cb_get_page_layout_class(); ?>">

			<?php do_action( 'cb_before_container_contents' ); ?>

			<div class="inner clearfix ">

				<div id="content">
					<?php bp_get_template_part( 'groups/single/home' ); ?>
				</div><!-- #content -->

				<?php get_sidebar( "buddypress" ); ?>

			</div> <!-- /.inner -->

			<?php do_action( 'cb_after_container_contents' ); ?>

		</div><!-- #container -->
		
		<?php do_action( 'bp_after_group_single_contents' ); ?>

	<?php  endif; ?>
		
<?php get_footer( "buddypress" ); ?>