<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Ganesh
 * @subpackage CRUD
 */

namespace Ganesh\CRUD;

use Ganesh\CRUD\Admin\Loader;
use Ganesh\CRUD\I18n;
use Ganesh\CRUD\Admin\Admin;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    Ganesh
 * @subpackage CRUD
 */
final class ReactCrudPlugin {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The text domain of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The text domain of the plugin.
	 */
	protected $text_domain;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @var      ReactCrudPluginLoader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the internationalization functionality.
	 *
	 * @since    1.0.0
	 * @var      I18n    $i18n    Loads and defines the internationalization files for this plugin.
	 */
	protected $i18n;

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @var      Admin    $admin    The admin-specific functionality of the plugin.
	 */
	protected $admin;

	/**
	 * The single instance of the class.
	 *
	 * @since    1.0.0
	 * @var      ReactCrudPlugin    $_instance    The single instance of the class.
	 */
	protected static $instance = null;

	/**
	 * Return the main instance of the plugin.
	 *
	 * @since    1.0.0
	 * @return   object    The main instance of the plugin.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'react-crud-plugin' ), '1.0.0' ); // @codingStandardsIgnoreLine
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'react-crud-plugin' ), '1.0.0' ); // @codingStandardsIgnoreLine
	}

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->version     = '1.0.0';
		$this->plugin_name = 'react-crud-plugin';
		$this->text_domain = 'react-crud-plugin';

		$this->define_constants();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

		do_action( 'react_crud_plugin_loaded' );
	}

	/**
	 * Define Constants.
	 *
	 * @since    1.0.0
	 */
	private function define_constants() {
		$this->define( 'REACT_CRUD_PLUGIN_VERSION', $this->version );
		$this->define( 'REACT_CRUD_PLUGIN_URI', plugins_url( '', REACT_CRUD_PLUGIN_FILE ) );
		$this->define( 'REACT_CRUD_PLUGIN_DIR', plugin_dir_path( REACT_CRUD_PLUGIN_FILE ) );
		$this->define( 'REACT_CRUD_PLUGIN_ABSPATH', dirname( REACT_CRUD_PLUGIN_FILE ) . '/' );
		$this->define( 'REACT_CRUD_PLUGIN_BASENAME', plugin_basename( REACT_CRUD_PLUGIN_FILE ) );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name Constant name.
	 * @param string|bool $value Constant value.
	 *
	 * @since    1.0.0
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ReactCrudPlugin_Loader. Orchestrates the hooks of the plugin.
	 * - ReactCrudPlugin_i18n. Defines internationalization functionality.
	 * - ReactCrudPlugin_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function load_dependencies() {
		$this->loader = new Loader();
		$this->i18n   = new I18n();
		$this->admin  = new Admin( $this->get_plugin_name(), $this->get_version() );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ReactCrudPlugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {
		$this->i18n->set_domain( $this->get_text_domain() );
		$this->loader->add_action( 'plugins_loaded', $this->i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {
		$this->loader->add_action( 'admin_menu', $this->admin, 'add_admin_menu_page' );

		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_scripts' );

		// Register custom REST API endpoint.
		$this->loader->add_action( 'rest_api_init', $this->admin, 'init_api_endpoint' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    ReactCrudPlugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the text domain of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The text domain of the plugin.
	 */
	public function get_text_domain() {
		return $this->text_domain;
	}

	/**
	 * Get the plugin url.
	 *
	 * @since     1.0.0
	 * @return string       The url of the plugin.
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', REACT_CRUD_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @since     1.0.0
	 * @return string       The path of the plugin.
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( REACT_CRUD_PLUGIN_FILE ) );
	}

}
