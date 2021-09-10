<?php
/**
 * Original code by Bavotasan for Arcade theme
 * 
 * Modified and adapted for WMS N@W Theme by @sbrajesh
 * 
 */
class CB_Header_Image_Metabox_Helper {

	public function __construct() {
		$this->setup();
	}
	
	public function setup() {
		
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 10, 2 );
		add_action( 'pre_post_update', array( $this, 'update' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_js' ) );
	}

	/**
	 * Add the metabx
	 */
	public function add_meta_box( $post_type, $post ) {

		if ( ! cb_is_post_type_page_header_enabled( $post_type ) ) {
			return ;
		}

		$allowed_post_types = get_post_types( array( 'public'=> true ) );
		
		$allowed_post_types = apply_filters( 'cb_allowed_post_types_for_custom_header', $allowed_post_types );
		
		foreach ( $allowed_post_types as $post_type ) {
			add_meta_box( 'cb-header-image', __( 'Benutzerdefinierter Header', 'social-portal' ), array( $this, 'render_metabox' ), $post_type, 'normal', 'default' );
		}
	}

	/**
	 * Render custom header metabox
	 *
	 * @param $post
	 */
	public function render_metabox( $post ) {
		
		$header_image = get_post_meta( $post->ID, 'cb-header-image', true );
		$img_src = ( $header_image ) ? '<img src="' . esc_url( $header_image ) . '" alt="" style="max-width:100%;" />' : '';
		$header_disabled = get_post_meta( $post->ID, '_cb_header_disabled', true );

		// Use nonce for verification
		wp_nonce_field( 'cb-custom-header-actions', 'cb-header-action-nonce' );

		echo '<p id="cb-header-image-container">' . $img_src . '</p>';
		//should we use attachment id instead?
		echo '<input type="hidden" id="cb-header-image-url" name="cb-header-image-url" value="' . esc_attr( $header_image) . '" />';
		echo '<p><button class="button primary-button select-image">' . __( 'Headerbild setzen', 'social-portal' ) . '</button> <button class="button delete-image">' . __( 'Remove Image', 'social-portal' ) . '</button></p>';
		echo '<p>' . __( 'Lege ein benutzerdefiniertes Bild für den Header fest, wenn Du etwas anderes als das Standardbild/die Standardfarbe verwenden möchtest.', 'social-portal' ) . '</p>';
		echo '<p>' .'<label><input type="checkbox" name="cb_disable_header" value="1"' . checked( 1, $header_disabled , false ) .' >' . __( 'Header deaktivieren', 'social-portal' ) . '</label>';
	}

	/**
	 * Save post custom fields
	 *
	 * This function is attached to the 'pre_post_update' action hook.
	 *
	 * @since 1.0.0
	 */
	public function update( $post_id ) {
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check if quick edit
		if ( ! empty( $_POST['_inline_edit'] ) && wp_verify_nonce( $_POST['_inline_edit'], 'inlineeditnonce' ) ) {
			return;
		}

		if ( ! isset( $_POST['cb-header-action-nonce'] ) || ! wp_verify_nonce( $_POST['cb-header-action-nonce'], 'cb-custom-header-actions' ) ) {
			return;
		}

		if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {
			//is the user able to edit post?
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

		}
	
		// Sanitize
		$custom_image =  empty( $_POST['cb-header-image-url'] ) ? '' : esc_url_raw( $_POST['cb-header-image-url'] ) ;
		$header_enabled = empty( $_POST['cb_disable_header'] ) ? 0 : 1;

		$this->save_meta_value( $post_id, 'cb-header-image', $custom_image );
		$this->save_meta_value( $post_id, '_cb_header_disabled', $header_enabled );
	}

	/**
	 * Save meta helper function
	 *
	 * @param	int $post_id	The post id
	 * @param	string $name	The custom field meta key
	 *
	 * @since 1.0.0
	 */
	public function save_meta_value( $post_id, $name, $value ) {
		if ( $value ) {
			update_post_meta( $post_id, $name, $value );
		} else {
			delete_post_meta( $post_id, $name );
		}
	}

	/**
	 * Load js on add/edit post type screen
	 *
	 * @param string $hook
	 */
	public function load_js( $hook ) {
		if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
			global $post_type;
			if ( ! cb_is_post_type_page_header_enabled( $post_type ) ) {
				return ;
			}

			wp_enqueue_script( 'cb-header-image', combuilder()->get_url() . '/admin/assets/js/custom-header.js', array( 'jquery' ), '', true );
		}
	}

}

new CB_Header_Image_Metabox_Helper();
