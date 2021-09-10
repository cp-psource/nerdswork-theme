
<?php

/**
 * Fires before the display of group membership requests admin.
 *
 */
do_action( 'bp_before_group_membership_requests_admin' ); ?>

<div class="requests">
	<?php bp_get_template_part( 'groups/single/requests-loop' ); ?>
</div>

<?php

/**
 * Fires after the display of group membership requests admin.
 *
 */
do_action( 'bp_after_group_membership_requests_admin' ); ?>