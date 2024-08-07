<?php
/**
 * Plugin Name: React CRUD Plugin
 * Plugin URI:  https://www.ganeshbhatt.com/
 * Description: A modern WordPress plugin to perform CRUD operations.
 * Version:     1.0.0
 * Author:      Ganesh Bhatta
 * Author URI:  https://www.ganeshbhatt.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: react-crud-plugin
 * Domain Path: /languages
 *
 * @package Ganesh
 */

use Ganesh\CRUD\Deactivate;
use Ganesh\CRUD\Uninstall;

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define REACT_CRUD_PLUGIN_FILE.
if ( ! defined( 'REACT_CRUD_PLUGIN_FILE' ) ) {
	define( 'REACT_CRUD_PLUGIN_FILE', __FILE__ );
}

/**
 * The code that runs during plugin deactivation.
 *
 * @since    1.0.0
 */
function react_crud_deactivate_plugin() {
	Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'react_crud_deactivate_plugin' );

/**
 * The code that runs during plugin un-installation.
 *
 * @since    1.0.0
 */
function react_crud_uninstall_plugin() {
	Uninstall::uninstall();
}
register_uninstall_hook( __FILE__, 'react_crud_uninstall_plugin' );

// Include the autoload file.
if ( ! class_exists( 'ReactCrudPlugin' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

use Ganesh\CRUD\ReactCrudPlugin;

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_react_crud_plugin() {
	$plugin = ReactCrudPlugin::get_instance();
	$plugin->run();
}
run_react_crud_plugin();
