<?php
/**
 *
 * BuddyPress Activity Plus Image list Override
 *
 * This note is for the developers who will understand the pain of keeping the source clean
 *
 * The BuddyPress Activity plus only allows overriding from the root of the theme and pollutes our template hierarchy.
 * Any plugin, which is good should atleast try to avoid allowing the bare files in the root directory, instead some subdirectory
 * should be used to make it more sane. There are no hooks, so I will have to keep i here for now.
 *
 * If the code below looks like crap to you, You are right my friend. It is what I feel.
 * The templates should be simple/clean but we don't have the controls here. It is a copy of the Activity Plus template.
 *
 */
?>
<div class="bpfb_images cb-ap-images">
<?php $rel = md5( microtime() . rand() ); ?>
<?php foreach ( $images as $img ) : ?>

	<?php if ( ! $img ) {
			continue;
		}
	?>

	<?php if ( preg_match( '!^https?:\/\/!i', $img ) ) : // Remote image ?>
		<img src="<?php echo esc_url( $img ); ?>" />
	<?php  else : ?>

		<?php $info = pathinfo( trim( $img ) ); ?>
		<?php $thumbnail = file_exists( bpfb_get_image_dir( $activity_blog_id ) . $info['filename'] . '-bpfbt.' . strtolower( $info['extension'] ) ) ?
				bpfb_get_image_url( $activity_blog_id ) . $info['filename'] . '-bpfbt.' . strtolower( $info['extension'] ) :
				bpfb_get_image_url( $activity_blog_id ) . trim( $img );

			$target = 'all' == BPFB_LINKS_TARGET ? 'target="_blank"' : '';
		?>
		<a href="<?php echo esc_url( bpfb_get_image_url( $activity_blog_id ) . trim( $img ) ); ?>" class="<?php echo $use_thickbox; ?>" rel="<?php echo $rel; ?>" <?php echo $target; ?> >
			<img src="<?php echo esc_url( $thumbnail ); ?>" />
		</a>
	<?php endif; ?>
<?php endforeach; ?>
</div>