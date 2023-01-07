<?php
/**
 * Deactivation class for the plugin.
 *
 * @since 1.0.0
 * @package    Ganesh
 * @subpackage CRUD
 */

namespace Ganesh\CRUD;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Deactivation class for the plugin.
 *
 * @since 1.0.0
 */
class Deactivate {

	/**
	 * Deactivation function for the plugin.
	 *
	 * @since 1.0.0
	 * @package    Ganesh
	 * @subpackage CRUD
	 */
	public static function deactivate() {
		// Unregister custom post type for plugin items.
		unregister_post_type( 'react_crud_item' );
	}
}
