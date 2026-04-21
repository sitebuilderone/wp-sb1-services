<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SB1_Services_CPT {

	public static function register() {
		$labels = array(
			'name'               => __( 'Services', 'wp-sb1-services' ),
			'singular_name'      => __( 'Service', 'wp-sb1-services' ),
			'add_new'            => __( 'Add New', 'wp-sb1-services' ),
			'add_new_item'       => __( 'Add New Service', 'wp-sb1-services' ),
			'edit_item'          => __( 'Edit Service', 'wp-sb1-services' ),
			'new_item'           => __( 'New Service', 'wp-sb1-services' ),
			'view_item'          => __( 'View Service', 'wp-sb1-services' ),
			'search_items'       => __( 'Search Services', 'wp-sb1-services' ),
			'not_found'          => __( 'No services found', 'wp-sb1-services' ),
			'not_found_in_trash' => __( 'No services found in trash', 'wp-sb1-services' ),
			'menu_name'          => __( 'Services', 'wp-sb1-services' ),
		);

		$args = array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'services' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon'    => 'dashicons-hammer',
			'show_in_rest' => true,
			'rest_base'    => 'services',
		);

		register_post_type( 'service', $args );
	}
}
