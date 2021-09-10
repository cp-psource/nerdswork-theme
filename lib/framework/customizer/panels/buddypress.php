<?php
/**
 * @package social-portal
 * Customizer BuddyPress Panel
 * 
 */

//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_BP_Panel_Helper {

	private $panel =  'cb_bp';
	
	public function __construct() {
		if ( function_exists( 'buddypress' ) ) {
			add_filter( 'cb_customizer_sections', array( $this, 'add_sections' ) );
		}
	}
	
	public function add_sections( $sections ) {
		//get all sections here
		//merge and return
		$new_sections = $this->get_sections();

		return array_merge( $sections, $new_sections );
	}

	public function get_sections() {
		
		$panel = $this->panel;
		$sections = array();

		$options = array(
			'bp-use-wp-page-title'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-use-wp-page-title' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'type'			=> 'checkbox',
					'label'			=> __( 'Verwende den WordPress-Seitentitel für Verzeichnisseiten?', 'social-portal' ),
					'description'   => __( 'Standardmäßig wird dies von BuddyPress nicht berücksichtigt. Du kannst es aktivieren, um den Titel zu steuern.', 'social-portal' ),
				),
			),

			'bp-excerpt-length'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-excerpt-length' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'type'			=> 'text',
					'label'			=> __( 'Max. Auszugslänge?', 'social-portal' ),
					'description'   => __( 'Wird verwendet, um die Länge der Beschreibung usw. in der Liste zu begrenzen.', 'social-portal' ),
				),
			),

			'bp-item-list-avatar-size'                => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'transport'         => 'refresh',
					'default'			=> cb_get_default( 'bp-item-list-avatar-size' ),
				),
				'control' => array(
					'control_type'  => 'CB_Customize_Range_Control',
					'input_attrs'   => array(
						'min'	=> 50,
						'max'	=> 450,
						'step'	=> 5,
					),
					'label'			=> __( 'Avatar-Größe (in Listen)', 'social-portal' ),
					'description'	=> __( 'Verwende diese Fotogröße in Artikellisten?', 'social-portal' ),
				),
			),

			'bp-item-list-use-gradient'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-item-list-use-gradient' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'type'			=> 'checkbox',
					'label'			=> __( 'Farbverlauf verwenden?', 'social-portal' ),
					'description'   => __( 'Farbverlauf in Überschriften in Artikellisten verwenden?', 'social-portal' ),

				),
			),

			'bp-item-list-display-type'     => array(
				'setting' => array(
					'sanitize_callback' => 'cb_sanitize_setting_choice',
					'default'			=> cb_get_default( 'bp-item-list-display-type' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'type'			=> 'select',
					'choices'		=> cb_get_setting_choices( 'bp-item-list-display-type' ),
					'label'			=> __( 'Anzeigetyp der Artikelliste?', 'social-portal' ),
					'description'   => __( 'Wird für die Artikelliste verwendet.', 'social-portal' ),

				),
			),

			'bp-user-avatar-image'     => array(
				'setting' => array(
					'sanitize_callback' => 'esc_url_raw',
					'default'			=> cb_get_default( 'bp-user-avatar-image' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'WP_Customize_Image_Control',
					'label'			=> __( 'Standardbenutzer-Avatar?', 'social-portal' ),
					'description'   => __( 'Maximal 512x512px Bild.', 'social-portal' ),
				),
			),

			'bp-user-cover-image'     => array(
				'setting' => array(
					'sanitize_callback' => 'esc_url_raw',
					'default'			=> cb_get_default( 'bp-user-cover-image' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'WP_Customize_Image_Control',
					'label'			=> __( 'Standard-Benutzer-Titelbild?', 'social-portal' ),
					'description'   => __( 'Maximal 2000x512px Bild.', 'social-portal' ),
				),
			),

			'bp-group-avatar-image'     => array(
				'setting' => array(
					'sanitize_callback' => 'esc_url_raw',
					'default'			=> cb_get_default( 'bp-group-avatar-image' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'		=> 'WP_Customize_Image_Control',
					'label'				=> __( 'Standardgruppen-Avatar?', 'social-portal' ),
					'description'		=> __( 'Maximal 512x512px Bild.', 'social-portal' ),
					'active_callback'	=> 'cb_is_bp_groups_active',
				),
			),

			'bp-group-cover-image'     => array(
				'setting' => array(
					'sanitize_callback' => 'esc_url_raw',
					'default'			=> cb_get_default( 'bp-group-cover-image' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'		=> 'WP_Customize_Image_Control',
					'label'				=> __( 'Standardgruppen-Titelbild?', 'social-portal' ),
					'description'		=> __( 'Maximal 2000x512px Bild.', 'social-portal' ),
					'active_callback'	=> 'cb_is_bp_groups_active',

				),
			),
		);

		$options = array_merge( $options,
			cb_get_typography_group_definitions( 'bp-single-item-title',
				__( 'Titel eines einzelnen Artikels', 'social-portal' ),
				__( 'Für einzelne Elementtitel, z.B. (Profilanzeigename, Gruppenname)', 'social-portal' )
			) );

		$options['bp-single-item-title-link-color'] = cb_get_color_definition( array(
			'default'   => cb_get_default( 'bp-single-item-title-link-color' ),
			'label'     => __( 'Farbe', 'social-portal' ),
		) );

		$options['bp-single-item-title-link-hover-color'] = cb_get_color_definition( array(
			'default'   => cb_get_default( 'bp-single-item-title-link-hover-color' ),
			'label'     => __( 'Hover Farbe', 'social-portal' ),
		) );

		$toggle_styling = cb_get_button_style_definition( 'bp-dropdown-toggle', __( 'Toggle Schaltfläche', 'social-portal' ) );

		$options = array_merge( $options, $toggle_styling );
		$sections['buddypress-general'] = array(
			'panel'   => $panel,
			'title'   => __( 'Allgemein', 'social-portal' ),
			'options' => $options
		);

		unset( $options );

		$sections['buddypress-activity'] = array(
			'panel'				=> $panel,
			'title'				=> __( 'Aktivität', 'social-portal' ),
			'active_callback'	=> 'cb_is_bp_activity_active',
			'options' => array(
				'bp-activity-directory-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'			=> cb_get_activity_dir_page_layout()
					),
					'control' => array(
						'control_type'		=> 'CB_Customize_Control_Page_Layout',
						'label'				=> __( 'Verzeichnislayout', 'social-portal' ),
						'description'		=> __( 'Wähle das Layout für die Verzeichnisseite.', 'social-portal' ),
					),
				),
				
				'bp-activity-item-arrow'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-activity-item-arrow' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'type'			=> 'checkbox',
						'label'			=> __( 'Aktivitätselemente mit Pfeil anzeigen?', 'social-portal' ),
						'description'   => __( 'Präsentation des Aktivitätselements.', 'social-portal' ),
						
					),
				),

				'bp-activity-enable-autoload'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-activity-enable-autoload' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'type'			=> 'checkbox',
						'label'			=> __( 'Autoload-Aktivitäten?', 'social-portal' ),
						'description'   => __( 'Weitere Aktivitäten werden automatisch geladen, wenn der Benutzer zum Ende der Aktivitätsliste blättert.', 'social-portal' ),
						
					),
				),
				
				'bp-activities-per-page'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-activities-per-page' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Aktivitäten pro Seite?', 'social-portal' ),
						'description'   => __( 'Wie viele Aktivitäten werden pro Seite aufgelistet?.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 500,
							'step' => 1,
						),
					),
				),
		));

		$sections['buddypress-members-dir'] = array(
			'panel'   => $panel,
			'title'   => __( 'Mitgliederverzeichnis', 'social-portal' ),
			'options' => array(
				'bp-members-directory-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'	        => cb_get_default( 'bp-members-directory-layout' ),//cb_get_members_dir_page_layout()
					),
					'control' => array(
						'control_type'		=> 'CB_Customize_Control_Page_Layout',
						'label'				=> __( 'Layout', 'social-portal' ),
						'description'		=> __( 'Wähle das Layout für die Mitgliederverzeichnisseite.', 'social-portal' ),
					),
				),

				'bp-members-per-row'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-members-per-row' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Mitglieder pro Zeile?', 'social-portal' ),
						'description'   => __( 'Es steuert das Rasterlayout des Mitgliederverzeichnisses.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 5,
							'step' => 1,
						),
					),
				),

				'bp-members-per-page'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-members-per-page' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Mitglieder pro Seite?', 'social-portal' ),
						'description'   => __( 'Wie viele Mitglieder werden pro Seite aufgelistet?.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 200,
							'step' => 1,
						),
					),
				),
			)
		);

		$member_profile_options =  array(

			'bp-member-profile-layout'				=> array(
				'setting' => array(
					'sanitize_callback'	=> 'cb_sanitize_setting_choice',
					//'transport'			=> 'postMessage',
					'default'				=> cb_get_default( 'bp-member-profile-layout' )
				),
				'control' => array(
					'control_type'		=> 'CB_Customize_Control_Page_Layout',
					'label'				=> __( 'Layout', 'social-portal' ),
					'description'		=> __( 'Wähle das Layout für die Mitgliederprofilseite.', 'social-portal' ),
				),
			),

			'bp-enable-extra-profile-links'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-enable-extra-profile-links' ),
					'transport'			=> 'refresh',

				),
				'control' => array(
					'type'				=> 'checkbox',
					'label'				=> __( 'Zusätzliche Profil-Links aktivieren?', 'social-portal' ),
					'description'		=> __( 'Wenn Du es aktivierst, kannst Du ein WordPress-Menü für zusätzliche Profillinks zuweisen. Alle Links aus diesem Menü werden zur Benutzerprofilnavigation hinzugefügt.', 'social-portal' ),
				),
			),

			'bp-member-show-breadcrumb'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-member-show-breadcrumb' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'type'			=> 'checkbox',
					'label'			=> __( 'Breadcrumb aktivieren?', 'social-portal' ),
					'description'   => __( 'Wenn Du es aktivieren, wird dem Benutzer die Breadcrumb-Navigation angezeigt.', 'social-portal' ),
					'active_callback' => 'cb_is_breadcrumb_plugin_active',
				),
			),

			'bp-member-friends-per-row'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-member-friends-per-row' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'CB_Customize_Range_Control',
					'label'			=> __( 'Benutzer (Freunde/Follower) pro Zeile?', 'social-portal' ),
					'description'   => __( 'Steuere das Benutzerraster in BuddyPress-Profillisten (Freunde/Follower usw.).', 'social-portal' ),
					'type'			=> 'range',
					'input_attrs'	=> array(
						'min'  => 1,
						'max'  => 5,
						'step' => 1,
					),
				),
			),

			'bp-member-friends-per-page'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-member-friends-per-page' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'CB_Customize_Range_Control',
					'label'			=> __( 'Wie viele Benutzer (Freunde/Follower) pro Seite?', 'social-portal' ),
					'description'   => __( 'Wie viele Benutzer werden pro Seite für Freunde/Follower usw. im Profil aufgelistet?.', 'social-portal' ),
					'type'			=> 'range',
					'input_attrs'	=> array(
						'min'  => 1,
						'max'  => 200,
						'step' => 1,
					),
				),
			),


			'bp-member-groups-per-row'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-member-groups-per-row' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'CB_Customize_Range_Control',
					'label'			=> __( 'Gruppen pro Reihe?', 'social-portal' ),
					'description'   => __( 'Steuere das Gruppenraster unter BuddyPress Profile-> Groups.', 'social-portal' ),
					'type'			=> 'range',
					'input_attrs'	=> array(
						'min'  => 1,
						'max'  => 5,
						'step' => 1,
					),
				),
			),

			'bp-member-groups-per-page'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-member-groups-per-page' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'CB_Customize_Range_Control',
					'label'			=> __( 'Gruppen pro Seite?', 'social-portal' ),
					'description'   => __( 'Wie viele Benutzer werden pro Seite für Freunde/Follower usw. im Profil aufgelistet?.', 'social-portal' ),
					'type'			=> 'range',
					'input_attrs'	=> array(
						'min'  => 1,
						'max'  => 200,
						'step' => 1,
					),
				),
			),

			'bp-member-blogs-per-row'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-member-blogs-per-row' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'CB_Customize_Range_Control',
					'active_callback' => 'is_multisite',
					'label'			=> __( 'Blogs pro Zeile?', 'social-portal' ),
					'description'   => __( 'Steuere das Blog-Raster auf BuddyPress Profile->Seiten.', 'social-portal' ),
					'type'			=> 'range',
					'input_attrs'	=> array(
						'min'  => 1,
						'max'  => 5,
						'step' => 1,
					),
				),
			),

			'bp-member-blogs-per-page'     => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
					'default'			=> cb_get_default( 'bp-member-blogs-per-page' ),
					'transport'			=> 'refresh',
				),
				'control' => array(
					'control_type'	=> 'CB_Customize_Range_Control',
					'active_callback' => 'is_multisite',
					'label'			=> __( 'Blogs pro Seite?', 'social-portal' ),
					'description'   => __( 'Wie viele Webseiten werden pro Seite für die Seite Profil->Webseiten aufgelistet?.', 'social-portal' ),
					'type'			=> 'range',
					'input_attrs'	=> array(
						'min'  => 1,
						'max'  => 200,
						'step' => 1,
					),
				),
			),

		);

		$sections['buddypress-members-single'] = array(
			'panel'   => $panel,
			'title'   => __( 'Mitgliederprofil', 'social-portal' ),
			'options' => $member_profile_options
		);

		$sections['buddypress-groups-dir'] = array(
			'panel'				=> $panel,
			'active_callback'	=> 'cb_is_bp_groups_active',
			'title'				=> __( 'Gruppenverzeichnis', 'social-portal' ),
			'options'			=> array(
								
				'bp-groups-directory-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'			=> cb_get_default( 'bp-groups-directory-layout' ),
					),
					'control' => array(
						'control_type'		=> 'CB_Customize_Control_Page_Layout',
						'label'				=> __( 'Directory Layout', 'social-portal' ),
						'description'		=> __( 'Wähle das Layout für die Verzeichnisseite.', 'social-portal' ),
					),
				),

				'bp-create-group-layout'			=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'	=> 'default'
					),
					'control' => array(
						'control_type'		=> 'CB_Customize_Control_Page_Layout',
						'label'				=> __( 'BuddyPress Gruppenseite erstellen', 'social-portal' ),
						'description'		=> __( 'Wähle das Layout für die Gruppenerstellungsseite.', 'social-portal' ),
	
					),
				),

				'bp-groups-per-row'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-groups-per-row' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Gruppen pro Zeile?', 'social-portal' ),
						'description'   => __( 'Es steuert das Gruppenverzeichnis-Rasterlayout.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 5,
							'step' => 1,
						),
					),
				),

				'bp-groups-per-page'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-groups-per-page' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Gruppen pro Seite?', 'social-portal' ),
						'description'   => __( 'Wie viele Gruppen werden pro Seite aufgelistet?.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 200,
							'step' => 1,
						),
					),
				),

				));
		
		$sections['buddypress-groups'] = array(
			'panel'   => $panel,
			'title'   => __( 'Gruppe', 'social-portal' ),
			'active_callback'	=> 'cb_is_bp_groups_active',
			'options' => array(
				'bp-single-group-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'	        => cb_get_default( 'bp-single-group-layout' ),
					),
					'control' => array(
						'control_type'		=> 'CB_Customize_Control_Page_Layout',
						'label'				=> __( 'BuddyPress Einzelgruppenseite', 'social-portal' ),
						'description'		=> __( 'Wähle das Layout für eine einzelne Gruppenseite.', 'social-portal' ),
					),
				),
				
				'bp-enable-extra-group-links'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-enable-extra-group-links' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'type'			=> 'checkbox',
						'label'			=> __( 'Zusätzliche Gruppenlinks aktivieren?', 'social-portal' ),
						'description'   => __( 'Wenn Du es aktivierst, kannst Du ein WordPress-Menü für zusätzliche Gruppenlinks zuweisen, und alle Links aus diesem Menü werden der Gruppennavigation hinzugefügt.', 'social-portal' ),
					),
				),

				'bp-group-show-breadcrumb'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-group-show-breadcrumb' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'type'			=> 'checkbox',
						'label'			=> __( 'Breadcrumb aktivieren?', 'social-portal' ),
						'description'   => __( 'WennDu es aktivierst, wird die Breadcrumb-Navigation für die Gruppe angezeigt.', 'social-portal' ),
						'active_callback' => 'cb_is_breadcrumb_plugin_active',
					),
				),

				'bp-group-members-per-row'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-group-members-per-row' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Mitglieder pro Reihe?', 'social-portal' ),
						'description'   => __( 'Steuere das Benutzerraster auf Gruppenmitgliedern und auf der Seite für Gruppenadministratoren.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 5,
							'step' => 1,
						),
					),
				),

				'bp-group-members-per-page'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-group-members-per-page' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Benutzer pro Seite?', 'social-portal' ),
						'description'   => __( 'Wie viele Benutzer werden pro Seite auf den Unterseiten der Gruppe aufgelistet?.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 200,
							'step' => 1,
						),
					),
				),
			)
		);

		$sections['buddypress-blogs-dir'] = array(
			'panel'				=> $panel,
			'title'				=> __( 'Blogs-Verzeichnis', 'social-portal' ),
			'active_callback'	=> 'cb_is_bp_blogs_active',
			'options' => array(
				
				'bp-blogs-directory-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'			=> cb_get_default( 'bp-blogs-directory-layout' ),
					),
					'control' => array(
						'control_type'		=> 'CB_Customize_Control_Page_Layout',
						'label'				=> __( 'Verzeichnislayout', 'social-portal' ),
						'description'		=> __( 'Wähle das Layout für die Blog-Verzeichnisseite.', 'social-portal' ),
					),
				),

				'bp-create-blog-layout'			=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'	=> 'default'
					),
					'control' => array(
						'control_type'		=> 'CB_Customize_Control_Page_Layout',
						'label'				=> __( 'Blog-Seite erstellen', 'social-portal' ),
						'description'		=> __( 'Wähle das Layout für die Blog-Erstellungsseite.', 'social-portal' ),
						'active_callback'	=> 'cb_is_bp_active',
					),
				),

				'bp-blogs-per-row'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-blogs-per-row' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Blogs pro Zeile?', 'social-portal' ),
						'description'   => __( 'Steuert das Layout des Blog-Verzeichnisrasters.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 5,
							'step' => 1,
						),
					),
				),

				'bp-blogs-per-page'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'bp-blogs-per-page' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Range_Control',
						'label'			=> __( 'Wie viele Blogs pro Seite?', 'social-portal' ),
						'description'   => __( 'Wie viele Blogs werden pro Seite aufgelistet?.', 'social-portal' ),
						'type'			=> 'range',
						'input_attrs'	=> array(
							'min'  => 1,
							'max'  => 500,
							'step' => 1,
						),
					),
				),

				));

            $sections['buddypress-registration'] = array(
                'panel'   => $panel,
                'title'   => __( 'Registrierung', 'social-portal' ),
                 'options' => array(

                    'bp-signup-page-layout'				=> array(
                        'setting' => array(
                            'default'	=> cb_get_default( 'bp-signup-page-layout' )
                        ),
                        'control' => array(
                            'control_type'		=> 'CB_Customize_Control_Page_Layout',
                            'label'				=> __( 'Registrierungsseite', 'social-portal' ),
                            'description'		=> __( 'Wähle das Layout für die Registrierungsseite.', 'social-portal' ),
                        ),
                    ),

                     'bp-activation-page-layout'				=> array(
                        'setting' => array(
                            'default'	=> cb_get_default( 'bp-activation-page-layout' )
                        ),
                        'control' => array(
                            'control_type'		=> 'CB_Customize_Control_Page_Layout',
                            'label'				=> __( 'Aktivierungsseite', 'social-portal' ),
                            'description'		=> __( 'Wähle das Layout für die Aktivierungsseite.', 'social-portal' ),
                        ),
                    ),
                )
            );

		return apply_filters( 'cb_customizer_buddypress_sections', $sections );
	}


}//end of class

new CB_BP_Panel_Helper();

