<article <?php post_class( cb_get_post_display_class( 'clearfix' ) ); ?> id="post-<?php the_ID(); ?>">

	<?php do_action( 'cb_before_post_entry' ); ?>

	<?php cb_post_thumbnail(); ?>

	<header class="entry-header clearfix">

		<?php
			if ( is_single() ) :
				$class_hidden = cb_is_post_title_visible() ? '' : 'hidden-post-title';
				the_title( "<h1 class='entry-title {$class_hidden}'>", "</h1>" );
				unset( $class_hidden );//no globals
			else :
				the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
			endif;
		?>

		<?php $article_header_meta = cb_get_article_header_meta(); ?>

		<?php if ( ! empty( $article_header_meta ) ) : ?>

			<div class="entry-meta clearfix">

				<?php echo do_shortcode( $article_header_meta ); ?>

			</div>

		<?php endif; ?>

		<?php edit_post_link( __( '<i class="fa fa-pencil-square"></i> Bearbeiten', 'social-portal' ), '<span class="edit-link">', '</span>' ); ?>

	</header>

	<?php if ( ! is_singular() ) : // Only display Excerpts for Search, Archive ?>

		<div class="entry-summary clearfix">
			<?php
				if ( has_excerpt() ) :
					the_excerpt();
				else:
					cb_truncate_post();
				endif;
			?>
		</div><!-- .entry-summary -->

	<?php else : ?>

		<div class="entry-content clearfix">

			<?php the_content( __( 'Weiterlesen <span class="meta-nav">&rarr;</span>', 'social-portal' ) ); ?>

			<?php
			wp_link_pages( array(
				'before'    => '<div class="page-links">' . __( 'Seiten:', 'social-portal' ),
				'after'     => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

	<?php endif; ?>

	<footer class="entry-footer clearfix">

		<?php $article_footer_meta = cb_get_article_footer_meta() ?>

		<?php if ( ! empty( $article_footer_meta ) ) : ?>

			<div class="entry-meta clearfix">

				<?php echo do_shortcode( $article_footer_meta ); ?>

			</div>

		<?php endif; ?>

		<?php if ( is_single() ) : ?>
			<?php edit_post_link( __( '<i class="fa fa-pencil-square"></i> Bearbeiten', 'social-portal' ), '<span class="edit-link">', '</span>' ); ?>
		<?php endif; ?>

	</footer>

	<?php do_action( 'cb_after_post_entry' ); ?>

</article>