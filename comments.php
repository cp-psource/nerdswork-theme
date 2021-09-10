<?php
/**
 * Comment List/Form
 *
 * @package social-portal
 * @author WMS N@W Team
 */
?>
<?php
	//if the post is password protected, do not show comment by default
	if ( post_password_required() ) {
		return;
	}
?>

<section id="comments" class="clearfix">

	<?php if ( have_comments() ) : ?>

		<h2 id="comments-title">
			<?php
				printf( _n( 'Ein Kommentar zu &ldquo;%2$s&rdquo;', '%1$s Kommentare zu &ldquo;%2$s&rdquo;', get_comments_number(), 'social-portal' ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
	    </h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<nav id="comment-nav-above" class="clearfix navigation comment-navigation comment-navigation-top">

					<h1 class="assistive-text"><?php _e( 'Kommentar Navigation', 'social-portal' ); ?></h1>

					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Ältere Kommentare', 'social-portal' ) ); ?></div>

					<div class="nav-next"><?php next_comments_link( __( 'Neuere Kommentare &rarr;', 'social-portal' ) ); ?></div>
				</nav>
		<?php endif; ?>

        <ul class="comment-list">
            <?php
                wp_list_comments( array(
                    'style'			=> 'ul',
                    'short_ping'	=> true,
					'avatar_size'	=> 50,
                ) );
            ?>
        </ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<div id="comment-nav-below" class="navigation comment-navigation comment-navigation-bottom">

					<h2 class="assistive-text"><?php _e( 'Kommentar Navigation', 'social-portal' ); ?></h2>

					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Ältere Kommentare', 'social-portal' ) ); ?></div>

					<div class="nav-next"><?php next_comments_link( __( 'Neuere Kommentare &rarr;', 'social-portal' ) ); ?></div>
				</div>

		<?php endif; ?>
	<?php endif; // end for have_comments().  ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Kommentarfunktion ist geschlossen.', 'social-portal' ); ?></p>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>

		<?php
		
		$commenter = wp_get_current_commenter();
		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';
		$format = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html_req = ( $req ? " required='required'" : '' );
		$html5    = 'html5' === $format;

		?>
		<?php
			comment_form( array(
				'class_form'    => 'standard-form comment-form',
				'fields'   =>  array(
						'author' => '<p class="comment-form-author">' . '<label for="author">' .
									'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . '  placeholder ="'. ( $req? __( 'Dein Name*', 'social-portal' ): __( 'Dein Name', 'social-portal' ) ) . '"/></label></p>',
						'email'  => '<p class="comment-form-email"><label for="email">' .
									'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . '  placeholder="' . ( $req ? __( 'Deine Email*', 'social-portal' ) : __( 'Deine Email', 'social-portal' ) ). '"/></label></p>',
						'url'    => '<p class="comment-form-url"><label for="url">' .
									'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="'.  __( 'Webseite', 'social-portal' ) . '"/></label></p>',
					),
				'comment_field'  => '<p class="comment-form-comment"><textarea name="comment" id="comment" cols="60" rows="5" aria-required="true"></textarea></p>',

			) );
		?>
	<?php endif; ?>

	<?php
		$trackbacks = get_comments( array( 'type' => 'trackback' ) );
		$num_trackbacks = count( $trackbacks );
		if ( ! empty( $trackbacks ) ) :
			?>
			<div id="trackbacks" class="clearfix">
				<h3 class="trackback-title"><?php printf( _n( '1 Trackback', '%d Trackbacks', $num_trackbacks, 'social-portal' ), number_format_i18n( $num_trackbacks ) ) ?></h3>

				<ul id="trackbacklist">

					<?php foreach ( (array) $trackbacks as $trackback ) : ?>

						<li>
							<strong><?php echo get_comment_author_link( $trackback->comment_ID ); ?></strong>
							<em><?php _e( 'am', 'social-portal'); ?> <?php echo get_comment_date( '', $trackback->comment_ID ); ?></em>
						</li>

					<?php endforeach; ?>
				</ul>

			</div>
	<?php endif; ?>

</section><!-- #comments -->