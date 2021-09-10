<?php do_action( 'bp_before_group_body' ); ?>
<?php do_action( 'bp_before_group_media' ); ?>
<div class="item-list-tabs no-ajax" id="subnav">
	<ul>

		<?php rtmedia_sub_nav(); ?>

		<?php do_action( 'rtmedia_sub_nav' ); ?>

	</ul>
</div><!-- .item-list-tabs -->

<?php rtmedia_load_template();

do_action( 'bp_after_group_media' );
do_action( 'bp_after_group_body' );
do_action( 'bp_after_group_home_content' );