<?php

/**
 * Scraps adminbar to use in account menus
 *
 * Class CB_Admin_Bar_Scrapper
 */
class CB_Admin_Bar_Scrapper {

	private $renderable_html = '';

	public function __construct() {
		$this->setup();
	}

	public function setup() {
		//remove default wp rendering of the menu bar
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {

		if ( ! is_user_logged_in() || is_admin() ) {
			return ;
		}

		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
		//force to render early
		add_action( 'cb_before_header', 'wp_admin_bar_render' );
		//setup catch for storing nodes
		add_action( 'wp_before_admin_bar_render', array( $this, 'store_nodes' ) );
		//if adminbar is not showing, we emulate it
		add_action( 'template_redirect', array( $this, 'emulate_init'), 1 );
		add_action( 'cb_before_header', array( $this, 'emulate_render' ) );

		add_action( 'wp_before_admin_bar_render', array( $this, 'start_buffering' ) );
		add_action( 'wp_after_admin_bar_render', array( $this, 'end_buffering' ) );

		//after cloning the items, we keep the menu and print them at the bottom, that makes the html output clean
		add_action( 'wp_footer', array( $this, 'render' ), 1000 );

	}

	/**
	 * Simulate initialization of adminbar for logged in users when the adminbar is not enabled
	 *
	 * @return bool
	 */
	public function emulate_init() {
		global $wp_admin_bar;

		if (  is_admin_bar_showing() ) {
			return false;
		}

		/* Load the admin bar class code ready for instantiation */
		require_once( ABSPATH . WPINC . '/class-wp-admin-bar.php' );

		/* Instantiate the admin bar */

		/**
		 * Filter the admin bar class to instantiate.
		 *
		 *
		 * @param string $wp_admin_bar_class Admin bar class to use. Default 'WP_Admin_Bar'.
		 */
		$admin_bar_class = apply_filters( 'wp_admin_bar_class', 'WP_Admin_Bar' );

		if ( class_exists( $admin_bar_class ) ) {
			$wp_admin_bar = new $admin_bar_class;
		} else {
			return false;
		}

		$wp_admin_bar->initialize();
		$wp_admin_bar->add_menus();

		wp_dequeue_script( 'admin-bar' );
		wp_dequeue_style( 'admin-bar' );

		return true;
	}

	/**
	 * Emulate rendering if the adminbar is disabled
	 *
	 */
	public function emulate_render() {

		if ( ! is_user_logged_in() ) {
			return ;
		}

		if ( is_admin_bar_showing() ) {
			return ;
		}

		global $wp_admin_bar;

		if ( ! is_object( $wp_admin_bar ) ) {
			return;
		}

		/**
		 * Load all necessary admin bar items.
		 *
		 * This is the hook used to add, remove, or manipulate admin bar items.
		 *
		 *
		 * @param WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance, passed by reference
		 */
		do_action_ref_array( 'admin_bar_menu', array( &$wp_admin_bar ) );

		/**
		 * Fires before the admin bar is rendered.
		 *
		 */
		do_action( 'wp_before_admin_bar_render' );


		/**
		 * Fires after the admin bar is rendered.
		 *
		 */
		do_action( 'wp_after_admin_bar_render' );

	}
	//2. When Adminbar is enabled, Catch the nodes and add the Menu Builder

	public function store_nodes() {
		global $wp_admin_bar;

		if ( ! is_user_logged_in() || is_admin() ) {
			return ;
		}

		$builder = new CB_Admin_Bar_Menu_Manager( $wp_admin_bar->get_nodes() );

		combuilder()->adminbar( $builder );
	}

	public function start_buffering() {
		ob_start();
	}

	public function end_buffering() {

		$adminbar = ob_get_clean();
		$this->renderable_html = $adminbar;
	}

	public function render() {

		echo $this->renderable_html;
		$this->renderable_html = null;
	}

}
//1.
//Remove the renderer from the footer and render before the header to cacth the items

new CB_Admin_Bar_Scrapper();

if ( ! class_exists('WP_Admin_Bar') ) {
	require_once ABSPATH . '/'. WPINC.'/class-wp-admin-bar.php';
}

/**
 * Yes, WP Has a messed implementation of admin bar that does not allow for partial rendering
 * and we are doing all kinds of hack here to make that possible
 *
 * Class CB_Adminbar_Builder
 *
 */
class CB_Admin_Bar_Menu_Manager extends WP_Admin_Bar {
	//protected $nodes;

	protected $nodes = array();
	protected $bound = false;

	public function __construct( $nodes = array()) {
		$this->nodes = $nodes;
		$this->_xbind();
	}

	/**
	 * Render the item given by the id
	 *
	 * @param $id
	 * @return string
	 */
	public function partial( $id ) {
		$node = $this->_xget_node( $id );

		if ( ! $node ) {
			return ;
		}

		ob_start();

		if ( $node->type == 'item' ) {
			$this->_render_item( $node );
		} else {
			$this->_render_group( $node );
		}

		$menus = ob_get_clean();// We got them all, let us change the ids

		return $menus;
	}

	/**
	 * Render account Menu
	 * @param string $prefix the prefix used to replace wp-admin-bar-my-account
	 */
	public function account( $prefix = 'nav-account' ) {

		$menus = $this->partial( 'my-account-buddypress' );
		$menus = str_replace( array( 'wp-admin-bar-my-account', 'ab-sub-wrapper') , array( $prefix, 'nav-links-wrapper' ), $menus );
		echo $menus;
	}

	/**
	 * Render Notifications menu
	 */
	public function notifications() {

		$menus = $this->partial( 'bp-notifications-default' );
		$menus = str_replace( array( 'wp-admin-bar', 'ab-sub-wrapper') , array( 'nav-account', 'nav-links-wrapper' ), $menus );
		echo $menus;
	}

	public function sites() {
		$menus = $this->partial( 'my-sites' );
		$menus = str_replace( array( 'wp-admin-bar', 'ab-sub-wrapper') , array( 'nav-account', 'nav-links-wrapper' ), $menus );

		echo '<ul class="sites-dashboard-list">';

		if ( cb_is_sites_menu_visible() ) {
			echo $menus ;
		}

		$cap = cb_get_option( 'dashboard-link-capability' );

		if ( cb_is_header_account_menu_visible() && $cap && current_user_can( $cap ) ) {
			echo '<li><a href="'. admin_url('/') .'">' .__( 'Dashboard', 'social-portal' ) .'</a></li>';
		}
		echo '</ul>';
	}
	/**
	 * @return object|void
	 */
	final protected function _xbind() {
		//do not bind again
		if ( $this->bound ) {
			return;
		}

		// Normalize nodes: define internal 'children' and 'type' properties.
		foreach ( $this->nodes as $node ) {
			$node->children = array();
			$node->type = ( $node->group ) ? 'group' : 'item';
			unset( $node->group );

			// The Root wants your orphans. No lonely items allowed.
			if ( ! $node->parent )
				$node->parent = 'root';
		}

		foreach ( $this->nodes as $node ) {

			if ( 'root' == $node->id ) {
				continue;
			}

			// Fetch the parent node. If it isn't registered, ignore the node.
			if ( ! $parent = $this->_xget_node( $node->parent ) ) {
				continue;
			}

			// Generate the group class (we distinguish between top level and other level groups).
			$group_class = ( $node->parent == 'root' ) ? 'ab-top-menu' : 'ab-submenu';

			if ( $node->type == 'group' ) {
				if ( empty( $node->meta['class'] ) ) {
					$node->meta['class'] = $group_class;
				} else {
					$node->meta['class'] .= ' ' . $group_class;
				}
			}

			// Items in items aren't allowed. Wrap nested items in 'default' groups.
			if ( $parent->type == 'item' && $node->type == 'item' ) {
				$default_id = $parent->id . '-default';
				$default    = $this->_xget_node( $default_id );

				// The default group is added here to allow groups that are
				// added before standard menu items to render first.
				if ( ! $default ) {
					// Use _set_node because add_node can be overloaded.
					// Make sure to specify default settings for all properties.
					$this->_xset_node( array(
						'id'        => $default_id,
						'parent'    => $parent->id,
						'type'      => 'group',
						'children'  => array(),
						'meta'      => array(
							'class'     => $group_class,
						),
						'title'     => false,
						'href'      => false,
					) );
					$default = $this->_xget_node( $default_id );
					$parent->children[] = $default;
				}
				$parent = $default;

				// Groups in groups aren't allowed. Add a special 'container' node.
				// The container will invisibly wrap both groups.
			} elseif ( $parent->type == 'group' && $node->type == 'group' ) {
				$container_id = $parent->id . '-container';
				$container    = $this->_xget_node( $container_id );

				// We need to create a container for this group, life is sad.
				if ( ! $container ) {
					// Use _set_node because add_node can be overloaded.
					// Make sure to specify default settings for all properties.
					$this->_xset_node( array(
						'id'       => $container_id,
						'type'     => 'container',
						'children' => array( $parent ),
						'parent'   => false,
						'title'    => false,
						'href'     => false,
						'meta'     => array(),
					) );

					$container = $this->_xget_node( $container_id );

					// Link the container node if a grandparent node exists.
					$grandparent = $this->_xget_node( $parent->parent );

					if ( $grandparent ) {
						$container->parent = $grandparent->id;

						$index = array_search( $parent, $grandparent->children, true );

						if ( $index === false ) {
							$grandparent->children[] = $container;
						} else {
							array_splice( $grandparent->children, $index, 1, array( $container ) );
						}
					}

					$parent->parent = $container->id;
				}

				$parent = $container;
			}

			// Update the parent ID (it might have changed).
			$node->parent = $parent->id;

			// Add the node to the tree.
			$parent->children[] = $node;
		}

		$root = $this->_xget_node( 'root' );
		$this->bound = true;
		return $root;
	}

	public function _xset_node( $args ) {
		$this->nodes[ $args['id'] ] = (object) $args;
	}

	public function _xget_node( $id ) {
		return isset( $this->nodes[ $id ] ) ? $this->nodes[$id] : null;
	}
}
