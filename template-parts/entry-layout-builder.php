<?php
/**
 * Specifically used for posts created via any page builder(preferably Maximus)
 */
?>
<article <?php post_class( 'clearfix' ); ?> id="post-<?php the_ID(); ?>">

    <?php do_action( 'cb_before_page_entry' ); ?>

    <?php if ( ! is_singular() ) : // Only display Excerpts for Search ?>

        <div class="entry-summary">

            <?php
	            if ( has_excerpt() ) :
	                the_excerpt();
	            else:
	                cb_truncate_post();
	            endif;
            ?>

        </div><!-- .entry-summary -->

    <?php else : ?>

        <div class="entry-content">

            <?php the_content( __( 'Weiterlesen <span class="meta-nav">&rarr;</span>', 'social-portal' ) ); ?>

            <?php
	            wp_link_pages( array(
	                'before'    => '<div class="page-links">' . __( 'Seiten:', 'social-portal' ),
	                'after'     => '</div>',
	            ) );
            ?>
        </div><!-- .entry-content -->

    <?php endif; ?>

    <?php do_action( 'cb_after_page_entry' ); ?>

</article>