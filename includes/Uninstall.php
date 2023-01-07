<?php
/**
 * Uninstall class for the plugin.
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
 * Uninstall class for the plugin.
 *
 * @since 1.0.0
 * @package    Ganesh
 * @subpackage CRUD
 */
class Uninstall {

	/**
	 * Uninstall function for the plugin.
	 *
	 * @since 1.0.0
	 * @package    Ganesh
	 * @subpackage CRUD
	 */
	public static function uninstall() {
		// Delete all plugin items.
		$items = get_posts(
			array(
				'post_type'      => 'react_crud_item',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);
		foreach ( $items as $item_id ) {
			wp_delete_post( $item_id, true );
		}

		// Unregister custom post type for plugin items.
		unregister_post_type( 'react_crud_item' );
	}
}
