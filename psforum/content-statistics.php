<?php

/**
 * Statistics Content Part
 *
 */

// Get the statistics
$stats = psf_get_statistics(); ?>

<dl role="main">

	<?php do_action( 'psf_before_statistics' ); ?>

	<dt><?php _e( 'Registrierte Benutzer', 'social-portal' ); ?></dt>
	<dd>
		<strong><?php echo esc_html( $stats['user_count'] ); ?></strong>
	</dd>

	<dt><?php _e( 'Foren', 'social-portal' ); ?></dt>
	<dd>
		<strong><?php echo esc_html( $stats['forum_count'] ); ?></strong>
	</dd>

	<dt><?php _e( 'Themen', 'social-portal' ); ?></dt>
	<dd>
		<strong><?php echo esc_html( $stats['topic_count'] ); ?></strong>
	</dd>

	<dt><?php _e( 'Antworten', 'social-portal' ); ?></dt>
	<dd>
		<strong><?php echo esc_html( $stats['reply_count'] ); ?></strong>
	</dd>

	<dt><?php _e( 'Themen-Tags', 'social-portal' ); ?></dt>
	<dd>
		<strong><?php echo esc_html( $stats['topic_tag_count'] ); ?></strong>
	</dd>

	<?php if ( ! empty( $stats['empty_topic_tag_count'] ) ) : ?>

		<dt><?php _e( 'Leere Themen-Tags', 'social-portal' ); ?></dt>
		<dd>
			<strong><?php echo esc_html( $stats['empty_topic_tag_count'] ); ?></strong>
		</dd>

	<?php endif; ?>

	<?php if ( ! empty( $stats['topic_count_hidden'] ) ) : ?>

		<dt><?php _e( 'Versteckte Themen', 'social-portal' ); ?></dt>
		<dd>
			<strong>
				<abbr title="<?php echo esc_attr( $stats['hidden_topic_title'] ); ?>"><?php echo esc_html( $stats['topic_count_hidden'] ); ?></abbr>
			</strong>
		</dd>

	<?php endif; ?>

	<?php if ( ! empty( $stats['reply_count_hidden'] ) ) : ?>

		<dt><?php _e( 'Versteckte Antworten', 'social-portal' ); ?></dt>
		<dd>
			<strong>
				<abbr title="<?php echo esc_attr( $stats['hidden_reply_title'] ); ?>"><?php echo esc_html( $stats['reply_count_hidden'] ); ?></abbr>
			</strong>
		</dd>

	<?php endif; ?>

	<?php do_action( 'psf_after_statistics' ); ?>

</dl>

<?php unset( $stats );