<?php
/**
 * BuddyPress - Groups Admin
 *
 */

?>
<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>
		<?php bp_group_admin_tabs(); ?>
	</ul>
</div><!-- .item-list-tabs -->

<?php
/**
 * Fires before the group admin form and content.
 *
 *
 */
do_action( 'bp_before_group_admin_form' ); ?>

<form action="<?php bp_group_admin_form_action(); ?>" name="group-settings-form" id="group-settings-form" class="standard-form group-setup-form" method="post" enctype="multipart/form-data">
<div class="group-admin-contents <?php echo esc_attr( bp_action_variable() ); ?>">
<?php

/**
 * Fires inside the group admin form and before the content.
 *
 */
do_action( 'bp_before_group_admin_content' ); ?>

<?php /* Fetch the template for the current admin screen being viewed */ ?>

<?php if ( bp_is_group_admin_screen( bp_action_variable() ) ) : ?>
	<?php bp_get_template_part( 'groups/single/admin/' . bp_action_variable() ); ?>
<?php endif; ?>

<?php

/**
 * Fires inside the group admin template.
 *
 * Allows plugins to add custom group edit screens.
 *
 */
do_action( 'groups_custom_edit_steps' ); ?>
<?php /* This is important, don't forget it */ ?>
	<input type="hidden" name="group-id" id="group-id" value="<?php bp_group_id(); ?>" />

<?php

/**
 * Fires inside the group admin form and after the content.
 *
 */
do_action( 'bp_after_group_admin_content' ); ?>
</div>
</form><!-- #group-settings-form -->
<?php
/**
 * Fires after the group admin form and content.
 *
 */
do_action( 'bp_after_group_admin_form' ); ?>