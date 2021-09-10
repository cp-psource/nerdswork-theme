<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}


/**
 * Applies cb customisations to the post comment form.
 *
 * @param array $default_labels The default options for strings, fields etc in the form
 * @see comment_form()
 * @return array
 */
function cb_filter_comment_form_defaults( $default_labels ) {

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$fields    =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'social-portal' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'social-portal' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Webseite', 'social-portal' ) . '</label>' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$new_labels = array(
		'comment_field'  => '<p class="form-textarea"><textarea name="comment" id="comment" cols="60" rows="10" aria-required="true"></textarea></p>',
		'fields'         => apply_filters( 'comment_form_default_fields', $fields ),
		'logged_in_as'   => '',
		'must_log_in'    => '<p class="alert">' . sprintf( __( 'Du musst <a href="%1$s">eingeloggt sein</a> um ein Kommentar abzugeben.', 'social-portal' ), wp_login_url( get_permalink() ) )	. '</p>',
		'title_reply'    => __( 'Hinterlasse eine Antwort', 'social-portal' )
	);

	return apply_filters( 'cb_comment_form_defaults', array_merge( $default_labels, $new_labels ) );
}
add_filter( 'comment_form_defaults', 'cb_filter_comment_form_defaults', 10 );


/**
 * Adds the user's avatar before the comment form box.
 *
 * The 'comment_form_top' action is used to insert our HTML within <div id="reply">
 * so that the nested comments comment-reply javascript moves the entirety of the comment reply area.
 *
 */
function cb_before_comment_form() {
	if ( ! cb_is_bp_active() ) {
		return ;
	}
?>
	<div class="comment-avatar-box">
		<div class="avb">
			<?php if ( bp_loggedin_user_id() ) : ?>
				<a href="<?php echo bp_loggedin_user_domain(); ?>">
					<?php echo get_avatar( bp_loggedin_user_id(), 50 ); ?>
				</a>
			<?php else : ?>
				<?php echo get_avatar( 0, 50 ); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="comment-content standard-form">
<?php
}
add_action( 'comment_form_top', 'cb_before_comment_form' );

/**
 * Closes tags opened in cb_before_comment_form().
 *
  */
function cb_after_comment_form() {
	if ( ! cb_is_bp_active() ) {
		return ;
	}
?>

	</div><!-- .comment-content standard-form -->

<?php
}
add_action( 'comment_form', 'cb_after_comment_form' );