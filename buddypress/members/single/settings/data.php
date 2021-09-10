<?php
/**
 * BuddyPress - Members Settings (Export Data)
 */

do_action( 'bp_before_member_settings_template' ); ?>

    <h2 class="screen-heading data-settings-screen">
		<?php esc_html_e( 'Datenexport', 'social-portal' ); ?>
    </h2>

<?php $request = bp_settings_get_personal_data_request(); ?>

<?php if ( $request ) : ?>

	<?php if ( 'request-completed' === $request->status ) : ?>

		<?php if ( bp_settings_personal_data_export_exists( $request ) ) : ?>

            <p><?php esc_html_e( 'Dein Antrag auf Export personenbezogener Daten wurde abgeschlossen.', 'social-portal' ); ?></p>
            <p><?php printf( esc_html__( 'Du kannst Deine persönlichen Daten herunterladen, indem Du auf den unten stehenden Link klickst. Aus Datenschutz- und Sicherheitsgründen löschen wir die Datei automatisch auf %s. Lade sie daher bitte vorher herunter.', 'social-portal' ), bp_settings_get_personal_data_expiration_date( $request ) ); ?></p>

            <p><strong><?php printf( '<a href="%1$s">%2$s</a>', bp_settings_get_personal_data_export_url( $request ), esc_html__( 'Lade persönliche Daten herunter', 'social-portal' ) ); ?></strong></p>

		<?php else : ?>

            <p><?php esc_html_e( 'Deine vorherige Anfrage für den Export personenbezogener Daten ist abgelaufen.', 'social-portal' ); ?></p>
            <p><?php esc_html_e( 'Bitte klicke auf die Schaltfläche unten, um eine neue Anfrage zu stellen.', 'social-portal' ); ?></p>

            <form id="bp-data-export" method="post">
                <input type="hidden" name="bp-data-export-delete-request-nonce" value="<?php echo wp_create_nonce( 'bp-data-export-delete-request' ); ?>" />
                <button type="submit" name="bp-data-export-nonce" value="<?php echo wp_create_nonce( 'bp-data-export' ); ?>"><?php esc_html_e( 'Neuen Datenexport anfordern', 'social-portal' ); ?></button>
            </form>

		<?php endif; ?>

	<?php elseif ( 'request-confirmed' === $request->status ) : ?>

        <p><?php printf( esc_html__( 'Du hast zuvor einen Export Deiner persönlichen Daten auf %s angefordert.', 'social-portal' ), bp_settings_get_personal_data_confirmation_date( $request ) ); ?></p>
        <p><?php esc_html_e( 'Du erhältst einen Link zum Herunterladen Ihres Exports per E-Mail, sobald wir Deine Anfrage erfüllen können.', 'social-portal' ); ?></p>

	<?php endif; ?>

<?php else : ?>

    <p><?php esc_html_e( 'Du kannst einen Export Deiner persönlichen Daten beantragen, die gegebenenfalls folgende Elemente enthalten:', 'social-portal' ); ?></p>
    <div class="cb-exportable-data-items">
	    <?php bp_settings_data_exporter_items(); ?>
    </div>

    <p><?php esc_html_e( 'Wenn Du eine Anfrage stellen möchtest, klicke bitte auf die Schaltfläche unten:', 'social-portal' ); ?></p>

    <form id="bp-data-export" method="post">
        <button type="submit" name="bp-data-export-nonce" value="<?php echo wp_create_nonce( 'bp-data-export' ); ?>"><?php esc_html_e( 'Export persönlicher Daten anfordern', 'social-portal' ); ?></button>
    </form>

<?php endif; ?>

    <h2 class="screen-heading data-settings-screen">
		<?php esc_html_e( 'Daten löschen', 'social-portal' ); ?>
    </h2>

<?php /* translators: Link to Delete Account Settings page */ ?>
    <p><?php esc_html_e( 'Um alle mit Deinem Konto verknüpften Daten zu löschen, muss Dein Benutzerkonto vollständig gelöscht werden.', 'social-portal' ); ?> <?php if ( bp_disable_account_deletion() ) : ?><?php esc_html_e( 'Please contact the site administrator to request account deletion.', 'social-portal' ); ?><?php else : ?><?php printf( esc_html__( 'You may delete your account by visiting the %s page.', 'social-portal' ), sprintf( '<a href="%s">%s</a>', bp_displayed_user_domain() . bp_get_settings_slug() . '/delete-account/', esc_html__( 'Delete Account', 'social-portal' ) ) ); ?><?php endif; ?></p>

<?php

do_action( 'bp_after_member_settings_template' );
