<?php

/**
 * User Roles Profile Edit Part
 *
 */

?>

<div>
	<label for="role"><?php _e( 'Blog Role', 'social-portal' ) ?></label>

	<?php psf_edit_user_blog_role(); ?>

</div>

<div>
	<label for="forum-role"><?php _e( 'Forum Role', 'social-portal' ) ?></label>

	<?php psf_edit_user_forums_role(); ?>

</div>
