<?php
/**
 * Handle plugin REST API requests.
 *
 * @since      1.0.0
 *
 * @package    Ganesh
 * @subpackage CRUD\Admin
 */

namespace Ganesh\CRUD\Admin;

/**
 * Handle plugin REST API requests.
 *
 * @package    Ganesh
 * @subpackage CRUD\Admin
 */
class API {
	/**
	 * Register the routes for the objects of the plugin.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = 'react-crud-plugin/v' . $version;

		// Get or Add Items.
		register_rest_route(
			$namespace,
			'/items',
			array(
				array(
					'methods'  => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_items' ),
				),
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'add_item' ),
					'permission_callback' => array( $this, 'permission_check' ),
					'args'                => array(
						'title'       => array(
							'required' => true,
						),
						'description' => array(
							'required' => false,
						),
					),
				)
			)
		);

		register_rest_route(
			$namespace,
			'/item/(?P<id>\d+)',
			array(
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_item' ),
					'permission_callback' => array( $this, 'permission_check' ),
					'args'                => array(
						'title'       => array(
							'required' => true,
						),
						'description' => array(
							'required' => false,
						),
					),
				),
				array(
					'methods'             => \WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'permission_check' ),
				),
			)
		);
	}

	/**
	 * Check permission for REST API requests.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return bool|WP_Error
	 */
	public function permission_check( $request ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new \WP_Error( 'rest_forbidden', esc_html( 'You cannot view this resource.' ), array( 'status' => 401 ) );
		}

		// Check nonce for security.
		if ( ! wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ) {
			return new \WP_Error( 'rest_forbidden', esc_html( 'You are not allowed to do this.' ), array( 'status' => 401 ) );
		}

		return true;
	}

	/**
	 * Add an item to the database.
	 *
	 * @since    1.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 */
	public function add_item( $request ) {
		$data = $request->get_json_params();

		if ( isset( $data['title'] ) && ! empty( $data['title'] ) ) {
			$title = sanitize_text_field( $data['title'] );
		} else {
			wp_send_json_error( array( 'message' => 'Item is required.' ) );
		}

		$description = isset( $data['description'] ) ? sanitize_text_field( $data['description'] ) : '';

		$new_item = array(
			'post_title'   => $title,
			'post_content' => $description,
			'post_status'  => 'publish',
			'post_type'    => 'react_crud_item',
		);

		// Save item data.
		$item_id = wp_insert_post( $new_item );

		if ( $item_id ) {
			wp_send_json_success(
				array(
					'message' => 'Item created successfully.',
					'id'      => $item_id
				)
			);
		} else {
			wp_send_json_error( array( 'message' => 'Error creating item.' ) );
		}
	}

	/**
	 * Delete an item from the database.
	 *
	 * @since    1.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 */
	public function delete_item( $request ) {
		if ( isset( $request['id'] ) && intval( $request['id'] ) ) {
			$item_id = intval( $request['id'] );
		} else {
			wp_send_json_error( array( 'message' => 'Invalid item.' ) );
		}

		// Delete item data.
		$delete_result = wp_delete_post( $item_id );

		if ( $delete_result ) {
			wp_send_json_success( array( 'message' => 'Item deleted successfully.' ) );
		} else {
			wp_send_json_error( array( 'message' => 'Error deleting item.' ) );
		}
	}

	/**
	 * Get all items from the database.
	 *
	 * @since    1.0.0
	 */
	public function get_items() {
		$items = get_posts(
			array(
				'post_type'      => 'react_crud_item',
				'posts_per_page' => -1,
			)
		);

		$data = array();

		foreach ( $items as $item ) {
			$data[] = array(
				'id'          => $item->ID,
				'title'       => $item->post_title,
				'description' => $item->post_content
			);
		}

		if ( $items ) {
			wp_send_json_success( $data );
		} else {
			wp_send_json_error( array( 'message' => 'Error retrieving items.' ) );
		}
	}

	/**
	 * Update an item in the database.
	 *
	 * @since    1.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 */
	public function update_item( $request ) {
		if ( isset( $request['id'] ) && intval( $request['id'] ) ) {
			$item_id = intval( $request['id'] );
		} else {
			wp_send_json_error( array( 'message' => 'Invalid item.' ) );
		}

		$data = $request->get_json_params();

		if ( isset( $data['title'] ) && ! empty( $data['title'] ) ) {
			$title = sanitize_text_field( $data['title'] );
		} else {
			wp_send_json_error( array( 'message' => 'Item is required.' ) );
		}

		$description = isset( $data['description'] ) ? sanitize_text_field( $data['description'] ) : '';

		$updated_item  = array(
			'ID'           => $item_id,
			'post_title'   => $title,
			'post_content' => $description,
		);
		$update_result = wp_update_post( $updated_item );

		if ( $update_result ) {
			wp_send_json_success( array( 'message' => 'Item updated successfully.' ) );
		} else {
			wp_send_json_error( array( 'message' => 'Error updating item.' ) );
		}
	}

}
