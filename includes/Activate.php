<?php
/**
 * Activation class for the plugin.
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
 * Activation class for the plugin.
 *
 * @since 1.0.0
 */
class Activate {

	/**
	 * The function called when the plugin is activated
	 *
	 * @since 1.0.0
	 * @package    Ganesh
	 * @subpackage CRUD
	 */
	public static function activate() {
		// Register custom post type for plugin items.
		register_post_type(
			'react_crud_item',
			array(
				'label'           => 'React CRUD Items',
				'public'          => true,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'capability_type' => 'post',
				'hierarchical'    => false,
				'rewrite'         => array( 'slug' => 'react-crud-items' ),
				'query_var'       => true,
				'menu_icon'       => 'dashicons-welcome-write-blog',
				'supports'        => array(
					'title',
					'editor',
					'excerpt',
					'trackbacks',
					'custom-fields',
					'comments',
					'revisions',
					'thumbnail',
					'author',
					'page-attributes',
				),
			)
		);
	}
}
