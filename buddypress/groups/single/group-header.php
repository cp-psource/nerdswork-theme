<?php
/**
 * BuddyPress Group Header
 */

/**
 * Fires before the display of a group's header.
 */
do_action( 'bp_before_group_header' );

?>
<div id="item-header-avatar">

	<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
	
		<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">
			<?php bp_group_avatar(); ?>
		</a>
	
	<?php endif; ?>
	
</div><!-- #item-header-avatar -->

<div id="item-header-content">
	 <h2>
		 <a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a>
     </h2>
    <span class="highlight"><?php bp_group_type(); ?></span>
	<?php
		/**
		 * Fires before the display of the group's header meta.
		 *
		 */
		do_action( 'bp_before_group_header_meta' );
	?>
	<div id="item-meta">

		<?php //bp_group_description(); ?>

		<div id="item-buttons">
			<?php cb_displayed_group_action_buttons(); ?>
		</div><!-- #item-buttons -->

		<?php

		/**
		 * Fires after the group header actions section.
		 *
		 */
		do_action( 'bp_group_header_meta' );
		?>

	</div><!-- /#item-meta -->

</div> <!-- /#item-header-content -->
<?php

/**
 * Fires after the display of a group's header.
 *
 */
do_action( 'bp_after_group_header' );


