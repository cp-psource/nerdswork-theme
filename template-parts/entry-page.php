<?php
/**
 * @package social-portal
 *
 * Single Page Content
 */
?>
<article <?php post_class( 'clearfix' ); ?> id="post-<?php the_ID(); ?>">
	
	<?php do_action( 'cb_before_page_entry' ); ?>

	<?php cb_post_thumbnail(); ?>
	<?php  $class_hidden = cb_is_post_title_visible() ? '' : 'hidden-post-title'; ?>
	<header class="entry-header <?php echo $class_hidden;?>">
				
		<?php
			if ( is_singular() ) :
               the_title( "<h1 class='entry-title {$class_hidden}'>", "</h1>" );
            else :
				the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
			endif;

			unset( $class_hidden );//no global
		?>

		<?php edit_post_link( __( '<i class="fa fa-pencil-square"></i> Bearbeiten', 'social-portal' ), '<span class="edit-link">', '</span>' ); ?>

	</header>

	<?php if (  is_search() ) : // Only display Excerpts for Search ?>

        <div class="entry-summary">
            <?php
                if ( has_excerpt() ) :
                    the_excerpt();
                else:
                    cb_truncate_post();
                endif;
            ?>
        </div><!-- .entry-summary -->
		
	<?php else :?>

		<div class="entry-content">

			<?php the_content( __( 'Weiterlesen <span class="meta-nav">&rarr;</span>', 'social-portal' ) ); ?>

			<?php
				wp_link_pages( array(
					'before'	=> '<div class="page-links">' . __( 'Seiten:', 'social-portal' ),
					'after'		=> '</div>',
				) );
			?>

		</div><!-- .entry-content -->

	<?php endif;?>

	<?php do_action( 'cb_after_page_entry' ); ?>

	<?php if ( is_singular() && current_user_can( 'edit_post', get_queried_object_id() ) ) : ?>
		<footer class="entry-footer clearfix">
			<?php edit_post_link( __( '<i class="fa fa-pencil-square"></i> Bearbeiten', 'social-portal' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>
	<?php endif; ?>

</article>