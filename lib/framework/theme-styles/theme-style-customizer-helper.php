<?php

/**
 * WMS N@W Theme Theme Style customizer helper
 *
 * Class CB_Theme_Style_Customizer_Helper
 */
class CB_Theme_Style_Customizer_Helper {

    public function __construct() {
        $this->setup();
    }

    public function setup() {

        //Pre save settings, cleanup o9ld settings it there is a change of color scheme
        add_action( 'customize_save', array( $this, 'save_all_settings') );
        //on save of the theme-style setting, we will clear current previewing color as it becomes default
        add_action( 'customize_save_theme-style', array( $this, 'theme_style_saved' ) );

        //filter theme-style theme mod to point to the current scheme
        add_filter( 'theme_mod_theme-style', array( $this, 'filter_theme_style' )  );
        //set our scheme in the customized var
        $this->update_globals();
    }

    /**
     * Get the currently previewing color scheme or the already set
     *
     * @return string
     */
    public function get_preview_theme_style() {
        return get_theme_mod( 'theme-style' );
    }

    /**
     * get the already set color scheme if any
     * @return string
     */
    public function get_original_theme_style() {
        $mods = get_theme_mods();
        return isset( $mods['theme-style'] ) ? $mods['theme-style'] : '';
    }

    /**
     * Has color scheme changed
     *
     * @return bool
     */
    public function has_theme_style_changed() {

        if ( $this->get_original_theme_style() != $this->get_preview_theme_style() ) {
            return true;
        }

        return false;
    }

    /**
     * Update the $_POST and push our theme-style onto the customized variables
     */
    public function update_globals() {

        if ( ! $this->has_theme_style_changed() ) {
            return ;
        }

        //we only need to update the $_POST['customized'] with 'theme-style'
        if ( isset( $_POST['wp_customize'] ) ) {
            $customized = json_decode( wp_unslash( $_POST['customized'] ), true );
            $customized['theme-style'] = get_theme_mod( 'theme-style' );
            $_POST['customized'] = json_encode( $customized );
        }
    }

    /**
     * Are we previewing?, if ys, filter theme mod
     *
     * @param $value
     * @return mixed|void
     */
    public function filter_theme_style( $value ) {

        $previewing = get_option( 'cb-preview-theme-style' );

        if ( $previewing ) {
            $value = $previewing;
        }

        return $value;
    }

    /**
     * We delete the temp option when the theme-style is saved
     */
    public function theme_style_saved() {
        //delete from options table
        delete_option( 'cb-preview-theme-style' );
    }

    /**
     * Cleanup the existing theme mods when theme color scheme is switched and saved
     */
    public function cleanup_saved_setting() {

        $mods = get_theme_mods();
		$theme_style = combuilder()->get_theme_style( get_theme_mod( 'theme-style' ) );

	    if ( empty( $theme_style ) ) {
	    	return ;
	    }

	    $settings = $theme_style->get_settings();
		//any value governed by
        foreach ( $settings as $key => $value ) {

            if ( isset( $mods[ $key ] ) ) {
                unset( $mods[ $key ] );
            }
            //save
            $theme = get_option( 'stylesheet' );
            update_option( "theme_mods_$theme", $mods );
        }
    }

    /**
     * Before the customizer saves settings, check the settings array and see if we are going to save the value for the theme-style
     * If  yes, we delete all values from the saved settings to avoid mixing
     *
     * @param WP_Customize_Manager $manager
     */
    public function save_all_settings( $manager ) {
        /**
         * var [] WP_Customize_Setting
         */

        $settings = $manager->settings();

        foreach ( $settings as $setting ) {
            $value =  $setting->post_value();

            if ( empty( $value ) ) {
                continue;
            }
			//so the theme style did chang, ok, let us cleanup
            if ( $setting->id == 'theme-style' ) {
                $this->cleanup_saved_setting();
                break;
            }
            //only the changed variables are given now
        }

    }
}

new CB_Theme_Style_Customizer_Helper();