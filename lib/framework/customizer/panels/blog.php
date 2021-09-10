<?php
/**
 * @package social-portal
 * Customizer Blog Panel
 * 
 */

//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_Blog_Panel_Helper {

	private $panel =  'cb_blog';
	
	public function __construct() {
		add_filter( 'cb_customizer_sections', array( $this, 'add_sections' ) );
	}

	public function add_sections( $sections ) {

        $new_sections = $this->get_sections();
		return array_merge( $sections, $new_sections );
	}


	public function get_sections() {
		
		$sections = array();
		$panel = $this->panel;
		$shortcode_url = $this->get_shortcode_doc_url();

		$sections['blog-single-page'] = array(
			'panel'       => $panel,
			'title'       => __( 'Seite', 'social-portal' ),
			'description' => __( 'Einstellungen Seitenanzeige.', 'social-portal' ),
			'options'     => array(
				
				'page-show-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'page-show-header' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Seitenheader anzeigen?', 'social-portal' ),
						'description'	=> __( 'Möchtest Du den großen Seitenheader ausblenden?.', 'social-portal' ),
					),
				),

				'page-show-title'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'page-show-title' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Seitentitel unter Headertitel anzeigen?' , 'social-portal'),
						'description'	=> __( 'Zeige den Titel unter der Überschrift direkt vor dem Inhalt an.', 'social-portal' ),
					),
				),

				'page-show-featured-image'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'page-show-featured-image' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Ausgewähltes Bild anzeigen?', 'social-portal' ),
						'description'	=> __( 'Ausgewählte Bilder werden unter dem Seitenkopf angezeigt.', 'social-portal' ),
					),
				),

			),//end of options
		);//end of page section

		$post_types = get_post_types( array( 'public' => true ) );
		$non_customizable_post_types = array(
			'page',
			'attachment',
			'psmt-gallery',
			'product',
			'reply',
			'topic',
			'forum'
		);
		/**
		 * Skip configuration for these post types from the customizer screen.
		 */
		$non_customizable_post_types = apply_filters( 'cb_non_customizable_post_types', $non_customizable_post_types );

		foreach ( $post_types as $post_type_name ) {
			if (in_array( $post_type_name, $non_customizable_post_types ) ) {
				continue;
			}

			$post_type_object = get_post_type_object( $post_type_name );

			$sections['blog-single-'. $post_type_name ] = $this->get_post_type_settings( $post_type_name, $post_type_object, $panel ) ;
		}

		$sections['blog-archive-post'] = array(
			'panel'       => $panel,
			'title'       => __( 'Archiv', 'social-portal' ),
			'description' => __( 'Anzeigeeinstellungen für Beiträge.', 'social-portal' ),
			'options'     => array(

				'archive-show-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'archive-show-header' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Seitenkopf anzeigen?', 'social-portal' ),
						'description'	=> __( 'Möchtest Du den großen Seitenheader ausblenden?.', 'social-portal' ),
					),
				),
				'archive-posts-display-type'     => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'archive-posts-display-type' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'type'			=> 'select',
						'choices'		=> cb_get_setting_choices( 'archive-posts-display-type' ),
						'label'			=> __( 'Anzeigetyp der Postliste?', 'social-portal' ),
						'description'   => __( 'Wird zum Auflisten von Beiträgen verwendet.', 'social-portal' ),

					),
				),

				'archive-posts-per-row'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'archive-posts-per-row' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'  => 'CB_Customize_Range_Control',
						'input_attrs'   => array(
							'min'	=> 1,
							'max'	=> 6,
							'step'	=> 1,
						),
						'label'			=> __( 'Beiträge pro Zeile?', 'social-portal' ),
						'description'	=> __( 'Beiträge pro Zeile bei Verwendung von Rasterlayout.', 'social-portal' ),
						'active_callback'   => 'cb_is_archive_page_using_masonry',
					),
				),

				'archive-show-featured-image'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'archive-show-featured-image' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Ausgewähltes Bild in Archivbeiträgen anzeigen?', 'social-portal' ),
						'description'	=> __( 'Es wird auf verschiedenen Seiten wie Archiv, Suche usw. Angezeigt.', 'social-portal' ),
					),
				),

				'archive-show-article-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'archive-show-article-header' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Artikel-Header in Post-Loops anzeigen?', 'social-portal' ),
						'description'	=> __( 'Es wird auf verschiedenen Seiten wie Archiv, Suche usw. angezeigt.', 'social-portal' ),
					),
				),

				'archive-post-header'  => array(
					'setting' => array(
						//'sanitize_callback' => 'esc_url_raw',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'archive-post-header' ),
					),
					'control' => array(
						'type'	        => 'textarea',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Artikelüberschrift', 'social-portal' ),
						'description'	=> sprintf( __( 'Wird oben im Artikeleintrag angezeigt. Weitere Informationen findest Du unter <a href="%s">Beitrag Shortcodes</a>.', 'social-portal' ), $shortcode_url ),					),
				),


				'archive-show-article-footer'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'archive-show-article-footer' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Artikelfußzeile in Beitrags-Loops anzeigen?', 'social-portal' ),
						'description'	=> __( 'Es wird auf verschiedenen Seiten wie Archiv, Suche usw. Angezeigt.', 'social-portal' ),
					),
				),

				'archive-post-footer'  => array(
					'setting' => array(
						//'sanitize_callback' => 'esc_url_raw',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'archive-post-footer' ),
					),
					'control' => array(
						'type'	        => 'textarea',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Artikel Fußzeile', 'social-portal' ),
						'description'	=> sprintf( __( 'Wird am Ende des Artikeleintrags angezeigt. Weitere Informationen findest Du unter <a href="%s">Beitrag-Shortcodes</a>.', 'social-portal' ), $shortcode_url ),					),

				),



			),//end of options
		);//end of page section

		$sections['home-posts-list'] = array(
			'panel'       => $panel,
			'title'       => __( 'Startseite', 'social-portal' ),
			'description' => __( 'Beiträge Anzeigeeinstellungen.', 'social-portal' ),
			'options'     => array(

				'home-posts-display-type'     => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'home-posts-display-type' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'type'			=> 'select',
						'choices'		=> cb_get_setting_choices( 'home-posts-display-type' ),
						'label'			=> __( 'Anzeigetyp der Beitragsliste?', 'social-portal' ),
						'description'   => __( 'Wird zum Auflisten von Beiträgen verwendet.', 'social-portal' ),
					),
				),

				'home-posts-per-row'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'home-posts-per-row' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'  => 'CB_Customize_Range_Control',
						'input_attrs'   => array(
							'min'	=> 1,
							'max'	=> 6,
							'step'	=> 1,
						),
						'label'			=> __( 'Beiträge pro Zeile?', 'social-portal' ),
						'description'	=> __( 'Beiträge pro Zeile bei Verwendung von Rasterslayout.', 'social-portal' ),
						'active_callback'   => 'cb_is_home_page_using_masonry',
					),
				),

			),//end of options
		);//end of page section


		$sections['search-posts-list'] = array(
			'panel'       => $panel,
			'title'       => __( 'Suchseite', 'social-portal' ),
			'description' => __( 'Beiträge Anzeigeeinstellungen.', 'social-portal' ),
			'options'     => array(

				'search-posts-display-type'     => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'search-posts-display-type' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'type'			=> 'select',
						'choices'		=> cb_get_setting_choices( 'search-posts-display-type' ),
						'label'			=> __( 'Anzeigetyp der Beitragsliste?', 'social-portal' ),
						'description'   => __( 'Wird zum Auflisten von Beiträgen verwendet.', 'social-portal' ),
					),
				),

				'search-posts-per-row'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'default'			=> cb_get_default( 'search-posts-per-row' ),
						'transport'			=> 'refresh',
					),
					'control' => array(
						'control_type'  => 'CB_Customize_Range_Control',
						'input_attrs'   => array(
							'min'	=> 1,
							'max'	=> 6,
							'step'	=> 1,
						),
						'label'			=> __( 'Beiträge pro Zeile?', 'social-portal' ),
						'description'	=> __( 'Beiträge pro Zeile bei Verwendung von Rasterlayout.', 'social-portal' ),
						'active_callback'   => 'cb_is_search_page_using_masonry',
					),
				),

			),//end of options
		);//end of page section



        $sections['misc-blog-section'] = array(
            'panel'       => $panel,
            'title'       => __( 'Extra Einstellungen', 'social-portal' ),
            'description' => __( 'Verschiedene Einstellungen.', 'social-portal' ),
            'options'     => array(
                'featured-image-fit-container'     => array(
                    'setting' => array(
                        'sanitize_callback' => 'absint',
                        'default'			=> cb_get_default( 'featured-image-fit-container' ),
                        'transport'			=> 'refresh',
                        'std'               => 1
                    ),
                    'control' => array(
                        'type'			=> 'checkbox',
                        'label'			=> __( 'Größe des ausgewählten Bildes an den Container anpassen?', 'social-portal' ),
                        'description'   => __( 'Wenn Du es deaktivierst, werden ausgewählte Bilder nicht skaliert.', 'social-portal' ),
                    ),
                ),

            ),//end of options
        );//end of page section

		return apply_filters( 'cb_customizer_blog_sections', $sections );
	}

	public function get_shortcode_doc_url() {
		return 'https://n3rds.work/wiki/piestingtal-source-wiki/ps-socialportal-theme/ps-socialportal-theme-beitrag-meta-shortcode/';
	}

	public function get_post_type_settings( $post_type, $post_type_object,  $panel  ) {
		$shortcode_url = $this->get_shortcode_doc_url();
		$singular_label = $post_type_object->labels->singular_name;
		return array(
			'panel'       => $panel,
			'title'       =>  $singular_label ,
			'description' => sprintf( __( '%s Anzeigeeinstellungen.', 'social-portal' ), $singular_label ),
			'options'     => array(

				$post_type . '-show-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'post-show-header' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Seitenheader anzeigen?', 'social-portal' ),
						'description'	=> __( 'Möchtest Du den großen Seitenheader ausblenden?', 'social-portal' ),
					),
				),

				$post_type . '-show-title'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'post-show-title' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Titel im Inhaltsbereich anzeigen?', 'social-portal' ),
						'description'	=> __( 'Zeige den Titel im Inhaltsbereich an.', 'social-portal' ),
					),
				),

				$post_type . '-show-featured-image'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'post-show-featured-image' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> sprintf( __( 'Ausgewähltes Bild auf einzelnen %s anzeigen?', 'social-portal' ), $singular_label ),
						'description'	=> __( 'Zeige das vorgestellte Bild.', 'social-portal' ),
					),
				),

				$post_type . '-show-article-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'post-show-article-header' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> sprintf( __( 'Beitragsheader für einzelne %s anzeigen?', 'social-portal' ), $singular_label ),
						'description'	=> __( 'Es wird auf einer einzelnen Seite angezeigt.', 'social-portal' ),
					),
				),

				$post_type . '-header'  => array(
					'setting' => array(
						//'sanitize_callback' => 'esc_url_raw',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'post-header' ),
					),
					'control' => array(
						'type'	        => 'textarea',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Artikelheader', 'social-portal' ),
						'description'	=> sprintf( __( 'Wird oben im Eintrag angezeigt. Weitere Informationen findest Du unter <a href="%s">Beitrag-Shortcodes.', 'social-portal' ), $shortcode_url ),
					),
				),

				$post_type . '-show-article-footer'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'post-show-article-footer' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> sprintf( __( 'Eintragsfußzeile für einzelne %s anzeigen?', 'social-portal' ), $singular_label ),
						'description'	=> __( 'Es wird am Ende des Eintrags angezeigt.', 'social-portal' ),
					),
				),

				$post_type . '-footer'  => array(
					'setting' => array(
						//'sanitize_callback' => 'esc_url_raw',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'post-footer' ),
					),
					'control' => array(
						'type'	        => 'textarea',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Artikel Fußzeile', 'social-portal' ),
						'description'	=> sprintf( __( 'Wird am Ende des Artikeleintrags angezeigt. Weitere Informationen findest Du unter <a href="%s">Beitrag-Shortcodes.', 'social-portal' ), $shortcode_url ),					),
				),

			),//end of options
		);//end of page section
	}
}//end of class

new CB_Blog_Panel_Helper();
