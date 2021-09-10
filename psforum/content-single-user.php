<?php

/**
 * Single User Content Part
 *
 */

?>

<div id="psforum-forums">



	<div id="psf-user-wrapper">
		<?php psf_get_template_part( 'user', 'details' ); ?>

		<div id="psf-user-body">
			<?php do_action( 'psf_template_notices' ); ?>
			<?php if ( psf_is_favorites()                 ) psf_get_template_part( 'user', 'favorites'       ); ?>
			<?php if ( psf_is_subscriptions()             ) psf_get_template_part( 'user', 'subscriptions'   ); ?>
			<?php if ( psf_is_single_user_topics()        ) psf_get_template_part( 'user', 'topics-created'  ); ?>
			<?php if ( psf_is_single_user_replies()       ) psf_get_template_part( 'user', 'replies-created' ); ?>
			<?php if ( psf_is_single_user_edit()          ) psf_get_template_part( 'form', 'user-edit'       ); ?>
			<?php if ( psf_is_single_user_profile()       ) psf_get_template_part( 'user', 'profile'         ); ?>
		</div>
	</div>
</div>
