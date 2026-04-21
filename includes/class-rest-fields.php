<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SB1_Services_Rest_Fields {

	public static function register() {
		$meta_fields = array(
			'_sb1_short_description' => array(
				'type'        => 'string',
				'description' => 'Short description for the service.',
			),
			'_sb1_icon'              => array(
				'type'        => 'string',
				'description' => 'Icon URL or CSS class for the service.',
			),
			'_sb1_cta_url'           => array(
				'type'        => 'string',
				'description' => 'Call-to-action button URL for the service.',
			),
			'_sb1_service_type'      => array(
				'type'        => 'string',
				'description' => 'Service type used in Schema.org markup.',
			),
			'_sb1_service_area'      => array(
				'type'        => 'string',
				'description' => 'Area served, used in Schema.org markup.',
			),
		);

		foreach ( $meta_fields as $key => $config ) {
			register_post_meta( 'service', $key, array(
				'type'         => $config['type'],
				'description'  => $config['description'],
				'single'       => true,
				'show_in_rest' => true,
			) );
		}
	}
}
