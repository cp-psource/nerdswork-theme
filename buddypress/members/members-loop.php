<?php
/**
 * @package social-portal
 *
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 */

?>
<?php

/**
 * Fires before the display of the members loop.
 *
 */
do_action( 'bp_before_members_loop' );
?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-dir-pag-top">
			<?php bp_members_pagination_links(); ?>
		</div>

	</div>

	<?php

	/**
	 * Fires before the display of the members list.
	 *
	 */
	do_action( 'bp_before_directory_members_list' );
	?>
	<?php bp_get_template_part( 'members/members-list' ); ?>
	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 */
	do_action( 'bp_after_directory_members_list' );
	?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php echo cb_get_members_notfound_message(); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 */
do_action( 'bp_after_members_loop' );
