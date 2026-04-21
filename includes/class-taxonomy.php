<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SB1_Services_Taxonomy {

	public static function register() {
		$labels = array(
			'name'              => __( 'Service Tags', 'wp-sb1-services' ),
			'singular_name'     => __( 'Service Tag', 'wp-sb1-services' ),
			'search_items'      => __( 'Search Service Tags', 'wp-sb1-services' ),
			'all_items'         => __( 'All Service Tags', 'wp-sb1-services' ),
			'edit_item'         => __( 'Edit Service Tag', 'wp-sb1-services' ),
			'update_item'       => __( 'Update Service Tag', 'wp-sb1-services' ),
			'add_new_item'      => __( 'Add New Service Tag', 'wp-sb1-services' ),
			'new_item_name'     => __( 'New Service Tag Name', 'wp-sb1-services' ),
			'menu_name'         => __( 'Service Tags', 'wp-sb1-services' ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => false,
			'public'       => true,
			'rewrite'      => array( 'slug' => 'service-tag' ),
			'show_in_rest' => true,
		);

		register_taxonomy( 'service_tag', 'service', $args );
	}
}
