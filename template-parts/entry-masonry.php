<?php
/**
 * Entry used when displaying masonry grid layout of posts
 *
 */
?>
<article <?php post_class( cb_get_post_display_class( 'clearfix' ) ); ?> id="post-<?php the_ID(); ?>">

	<?php cb_post_thumbnail( 'thumbnail' ); ?>

	<div class="entry-inner">

		<?php do_action( 'cb_before_post_entry' ); ?>


		<header class="entry-header clearfix">

			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

			<?php $article_header_meta = cb_get_article_header_meta(); ?>

			<?php if ( ! empty( $article_header_meta ) ) : ?>

				<div class="entry-meta clearfix">

					<?php echo do_shortcode( $article_header_meta ); ?>

				</div>

			<?php endif; ?>

			<?php edit_post_link( __( '<i class="fa fa-pencil-square"></i> Bearbeiten', 'social-portal' ), '<span class="edit-link">', '</span>' ); ?>

		</header>

		<?php // Only display Excerpts for Search, Archive ?>

		<div class="entry-summary clearfix">
			<?php
				if ( has_excerpt() ) :
					the_excerpt();
				else:
					cb_truncate_post();
				endif;
			?>
		</div><!-- .entry-summary -->


		<footer class="entry-footer clearfix">

			<?php $article_footer_meta = cb_get_article_footer_meta() ?>

			<?php if ( ! empty( $article_footer_meta ) ) : ?>

				<div class="entry-meta clearfix">

					<?php echo do_shortcode( $article_footer_meta ); ?>

				</div>

			<?php endif; ?>

		</footer>

		<?php do_action( 'cb_after_post_entry' ); ?>
	</div> <!-- entry of entry-inner -->

</article>