<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ganesh
 * @subpackage CRUD\Admin
 */

namespace Ganesh\CRUD\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ganesh
 * @subpackage CRUD\Admin
 */
class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, REACT_CRUD_PLUGIN_URI . '/assets/src/css/react-crud-plugin-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, REACT_CRUD_PLUGIN_URI . '/assets/dist/js/admin.bundle.js', array(), $this->version, false );
		$data = array(
			'nonce'   => wp_create_nonce( 'wp_rest' ),
			'restUrl' => esc_url_raw( rest_url( 'react-crud-plugin/v1' ) ),

		);
		wp_localize_script( $this->plugin_name, 'reactCrudPluginData', $data );
	}

	/**
	 * Add an admin menu page for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menu_page() {
		add_menu_page( 'React CRUD Plugin', 'React CRUD', 'manage_options', $this->plugin_name, array( $this, 'display_admin_menu_page' ), 'dashicons-welcome-widgets-menus', 20 );
	}

	/**
	 * Display the admin menu page for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_menu_page() {
		include_once dirname( __FILE__ ) . '/partials/react-crud-plugin-admin-display.php';
	}
}
