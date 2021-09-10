<?php

/**
 *
 * Custom Post meta to allow selecting layout
 */
class CB_Page_Layout_Metabox_Helper {

	public function __construct() {

		$this->setup();
	}

	/**
	 * Setup
	 */
	public function setup() {
		//add metabox when admin_menu action is called, we may do it on admin_init too
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta' ) ); //save the meta value when post is saved
	}

	/**
	 * Register Layout metabox for supported post types
	 */
	public function add_meta_box() {

		$allowed_types = $this->get_enabled_post_types();

		foreach ( $allowed_types as $post_type ) {

			add_meta_box(
				'cb_page_layout_type_meta_box', // $id
				__( 'Layout', 'social-portal' ), // $title
				array( $this, 'render_meta_box' ), // $callback
				$post_type, // $page
				'side', // $context
				'low'
			); // $priority
		}
	}

	/**
	 * Display Layout metabox on supported post type edit screens
	 */
	public function render_meta_box() {

		global $post;
		// Use nonce for verification
		echo '<input type="hidden" name="cb_page_layout_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

		//get the meta key
		$key = $this->get_meta_key();

		// get value of this field if it exists for this post
		$val = get_post_meta( $post->ID, $key, true ); //it wil be either 1 or empty

		if ( ! $val ) {
			$val = 0;
		}

		?>

        <p>
            <label for="default-<?php echo $key; ?>">
                <input type="radio" name="<?php echo $key; ?>"
                       id="default-<?php echo $key; ?>" <?php checked( 0, $val ) ?> value="0"/>
				<?php _e( 'Standard Layout', 'social-portal' ); ?>
            </label>
        </p>

        <p>
            <label for="single-col-<?php echo $key; ?>">
                <input type="radio" name="<?php echo $key; ?>"
                       id="single-col-<?php echo $key; ?>" <?php checked( 'page-single-col', $val ) ?>
                       value="page-single-col"/>
				<?php _e( 'Einspaltiges Layout', 'social-portal' ); ?>
            </label>
        </p>

        <p>
            <label for="two-col-right-<?php echo $key; ?>">
                <input type="radio" name="<?php echo $key; ?>"
                       id="two-col-right-<?php echo $key; ?>" <?php checked( 'page-two-col-right-sidebar', $val ) ?>
                       value="page-two-col-right-sidebar"/>
				<?php _e( '2 Spalten rechts (Seitenleiste) Layout', 'social-portal' ); ?>
            </label>
        </p>

        <p>
            <label for="two-col-left-<?php echo $key; ?>">
                <input type="radio" name="<?php echo $key; ?>"
                       id="two-col-left-<?php echo $key; ?>" <?php checked( 'page-two-col-left-sidebar', $val ) ?>
                       value="page-two-col-left-sidebar"/>
				<?php _e( '2 Spalten links (Seitenleiste) Layout', 'social-portal' ); ?>
            </label>
        </p>
		<?php $this->show_page_template_dropdown( $post ); ?>
        <hr/>
        <p><strong><?php _e( 'Layout Blocks', 'social-portal' ) ?></strong></p>
        <label class="cb-block-item">
            <input type="checkbox" name="_cb_hide_header"
                   value="1" <?php checked( 1, get_post_meta( $post->ID, '_cb_hide_header', true ) ); ?> > <?php _e( 'Header ausblenden', 'social-portal' ); ?>
        </label>
        <label class="cb-block-item">
            <input type="checkbox" name="_cb_hide_footer"
                   value="1" <?php checked( 1, get_post_meta( $post->ID, '_cb_hide_footer', true ) ); ?> > <?php _e( 'Footer ausblenden', 'social-portal' ); ?>
        </label>

        <label class="cb-block-item">
            <input type="checkbox" name="_cb_hide_footer_copyright"
                   value="1" <?php checked( 1, get_post_meta( $post->ID, '_cb_hide_footer_copyright', true ) ); ?> > <?php _e( 'Footer Copyright-Bereich ausblenden', 'social-portal' ); ?>
        </label>

        <hr/>
        <p><strong><?php _e( 'Panel links', 'social-portal' ) ?></strong></p>
        <label class="cb-block-item"
               for="_cb_panel_left_visibility"><?php _ex( 'Sichtbarkeit', 'Einzelbeitrag-Layout-Option', 'social-portal' ); ?></label>
		<?php $this->show_panel_visibility_dropdown( get_post_meta( $post->ID, '_cb_panel_left_visibility', true ), '_cb_panel_left_visibility' ); ?>
        <label class="cb-block-item"
               for="_cb_panel_left_user_scope"><?php _ex( 'Benutzerbereich', 'Single post layout option', 'social-portal' ); ?></label>
		<?php $this->show_panel_user_scope_dropdown( get_post_meta( $post->ID, '_cb_panel_left_user_scope', true ), '_cb_panel_left_user_scope' ); ?>

        <hr/>
        <p><strong><?php _e( 'Panel Right', 'social-portal' ) ?></strong></p>
        <label class="cb-block-item"
               for="_cb_panel_right_visibility"><?php _ex( 'Sichtbarkeit', 'Single post layout option', 'social-portal' ); ?> </label>
		<?php $this->show_panel_visibility_dropdown( get_post_meta( $post->ID, '_cb_panel_right_visibility', true ), '_cb_panel_right_visibility' ); ?>
        <label class="cb-block-item"
               for="_cb_panel_right_user_scope"><?php _ex( 'Benutzerbereich', 'Single post layout option', 'social-portal' ); ?> </label>
		<?php $this->show_panel_user_scope_dropdown( get_post_meta( $post->ID, '_cb_panel_right_user_scope', true ), '_cb_panel_right_user_scope' ); ?>

        <style type="text/css">
            .cb-block-item {
                display: block;
                margin-top: 10px;
            }
        </style>
		<?php
	}

	public function show_page_template_dropdown( $post ) {

		$post = get_post( $post );

		if ( ! $this->is_custom_template_allowed( $post ) ) {
			return;
		}

		$template = get_post_meta( $post->ID, '_wp_page_template', true );
		?>

        <p><strong><?php _e( 'Template', 'social-portal' ) ?></strong></p>
        <label class="screen-reader-text"
               for="page_template"><?php _e( 'Seitenvorlage', 'social-portal' ) ?></label>
        <select name="page_template" id="page_template">
			<?php
			$default_title = apply_filters( 'default_page_template_title', __( 'Standardvorlage', 'social-portal' ), 'meta-box' );
			?>
            <option value="default"><?php echo esc_html( $default_title ); ?></option>
			<?php page_template_dropdown( $template ); ?>
        </select>
		<?php
	}


	public function show_panel_visibility_dropdown( $visibility, $name, $id = '' ) {

		if ( ! $id ) {
			$id = sanitize_title( $name );
		}

		$choices = $this->get_panel_visibility_options();
		?>

        <select name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>">
			<?php foreach ( $choices as $key => $label ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $visibility ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
        </select>

		<?php
	}


	public function show_panel_user_scope_dropdown( $scope, $name, $id = '' ) {

		if ( ! $id ) {
			$id = sanitize_title( $name );
		}

		$choices = $this->get_panel_user_scopes();
		?>

        <select name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>">
			<?php foreach ( $choices as $key => $label ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $scope ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
        </select>

		<?php
	}


// Save the meta value

	public function save_meta( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( ! isset( $_POST['cb_page_layout_meta_box_nonce'] ) ) {
			return $post_id;
		}

		// verify nonce
		if ( ! wp_verify_nonce( $_POST['cb_page_layout_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		if ( $this->is_custom_template_allowed( $post_id ) ) {
			$this->save_page_template( $post_id );
		}
		//get the post type
		$post_type = $_REQUEST['post_type'];

		if ( empty( $post_type ) ) {//if post type is empty, extract it from the post id
			$post_type = get_post_type( $post_id );
		}
		//get the array of allowed post types
		$allowed_post_types = $this->get_enabled_post_types();

		//if current post(which we are editing) is not in the allowed post type, let us return
		if ( ! in_array( $post_type, $allowed_post_types ) ) {
			return $post_id;
		}

		//if we are here, all the conditions have met, let us update the meta 

		update_post_meta( $post_id, $this->get_meta_key(), $_POST[ $this->get_meta_key() ] );

		//For On/ff Keys
		$keys = array(
			'_cb_hide_header'           => '_cb_hide_header',
			'_cb_hide_footer'           => '_cb_hide_footer',
			'_cb_hide_footer_copyright' => '_cb_hide_footer_copyright',
		);

		foreach ( $keys as $post_field => $meta_key ) {

			if ( isset( $_POST[ $post_field ] ) ) {
				update_post_meta( $post_id, $meta_key, 1 );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}

		}
		$panel_options = array(
			'_cb_panel_left_visibility',
			'_cb_panel_right_visibility',
		);

		foreach ( $panel_options as $panel_name ) {
			if ( isset( $_POST[ $panel_name ] ) && $_POST[ $panel_name ] != 'default' ) {
				// validate and update
				if ( in_array( $_POST[ $panel_name ], $this->get_panel_visibility_option_keys() ) ) {
					update_post_meta( $post_id, $panel_name, $_POST[ $panel_name ] );
				}
			} else {
				// remove panel info
				delete_post_meta( $post_id, $panel_name );
			}
		}

		$panel_scope_options = array(
			'_cb_panel_left_user_scope',
			'_cb_panel_right_user_scope',
		);


		foreach ( $panel_scope_options as $panel_scope_name ) {
			if ( isset( $_POST[ $panel_scope_name ] ) && $_POST[ $panel_scope_name ] != 'default' ) {
				// validate and update
				if ( in_array( $_POST[ $panel_scope_name ], $this->get_panel_user_scope_keys() ) ) {
					update_post_meta( $post_id, $panel_scope_name, $_POST[ $panel_scope_name ] );
				}
			} else {
				// remove panel scope info
				delete_post_meta( $post_id, $panel_scope_name );
			}
		}

	}

	public function save_page_template( $post_id ) {

		if ( isset( $_POST['page_template'] ) ) {
			update_post_meta( $post_id, '_wp_page_template', $_POST['page_template'] );
		} else {
			delete_post_meta( $post_id, '_wp_page_template' );
		}
	}

	//get the meta key
	public function get_meta_key() {
		return cb_get_page_layout_meta_key();
	}

	/**
	 * Get list of allowed post types which support layout metabox
	 * @return array
	 */
	public function get_enabled_post_types() {

		$types = get_post_types( array( 'public' => true ) ); //get all public post types names

		return apply_filters( 'cb_layout_enabled_post_types', $types );
	}

	/**
	 * Is custom page template allowed for this post type?
	 *
	 * @param $post
	 *
	 * @return bool
	 */
	public function is_custom_template_allowed( $post ) {
		$post             = get_post( $post );
		$disallowed_types = array( 'page', 'attachment' );
		$disallowed_types = apply_filters( 'cb_page_template_disallowed_post_types', $disallowed_types );

		if ( in_array( $post->post_type, $disallowed_types ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Get side panel visibility allowed values.
	 *
	 * @return array
	 */
	private function get_panel_visibility_option_keys() {

		return array_keys( $this->get_panel_visibility_options() );
	}

	/**
	 * Get side panel visibility options
	 *
	 * @return array
	 */
	private function get_panel_visibility_options() {
		return array(
			'default' => __( 'Standard', 'social-portal' ),
			'always'  => __( 'Immer', 'social-portal' ),
			//'only'    => _x( 'Only For', 'Panel visibility option', 'social-portal' ),
			'mobile'  => __( 'Nur kleiner Bildschirm', 'social-portal' ),
			'never'   => __( 'Niemals', 'social-portal' ),
		);
	}

	/**
     * Get an array of valid user scope options as option=>label associative array
	 * @return array
	 */
	private function get_panel_user_scopes() {
		return array(
			'default'    => __( 'Standard', 'social-portal' ),
			'all'        => __( 'Jeder', 'social-portal' ),
			'logged-in'  => __( 'Eingeloggt', 'social-portal' ),
			'logged-out' => __( 'Abgemeldet', 'social-portal' ),
		);
	}

	/**
	 * Get a list of valid options
     *
	 * @return array
	 */
	private function get_panel_user_scope_keys() {
		return array_keys( $this->get_panel_user_scopes() );
	}

}

new CB_Page_Layout_Metabox_Helper();