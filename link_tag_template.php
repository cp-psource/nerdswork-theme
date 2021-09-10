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
<?php
$target = in_array( BPFB_LINKS_TARGET, array( 'all', 'external' ) ) ? 'target="_blank"' : ''; ?>
<div class="bpfb_final_link clearfix">

	<?php if ( $image ) : ?>
		<div class="bpfb_link_preview_container">
			<a href="<?php echo esc_url( $url ); ?>" <?php echo $target; ?> ><img src="<?php echo esc_url( $image ); ?>" /></a>
		</div>
	<?php endif; ?>

	<div class="bpfb_link_contents">
		<div class="bpfb_link_preview_title"><?php echo $title; ?></div>
		<div class="bpfb_link_preview_url">
			<a href="<?php echo esc_url($url);?>" <?php echo $target; ?> ><?php echo $url; ?></a>
		</div>
		<div class="bpfb_link_preview_body"><?php echo $body; ?></div>
	</div>
</div>