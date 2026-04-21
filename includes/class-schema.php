<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SB1_Services_Schema {

	public static function register() {
		add_action( 'wp_head', array( __CLASS__, 'output' ) );
	}

	public static function output() {
		if ( ! is_singular( 'service' ) ) {
			return;
		}

		$post_id = get_the_ID();

		$description  = get_post_meta( $post_id, '_sb1_short_description', true );
		$service_type = get_post_meta( $post_id, '_sb1_service_type', true );
		$service_area = get_post_meta( $post_id, '_sb1_service_area', true );
		$cta_url      = get_post_meta( $post_id, '_sb1_cta_url', true );

		if ( ! $description ) {
			$description = get_the_excerpt( $post_id );
		}

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Service',
			'name'     => get_the_title( $post_id ),
			'url'      => get_permalink( $post_id ),
			'provider' => array(
				'@type' => 'LocalBusiness',
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url(),
			),
		);

		if ( $description ) {
			$schema['description'] = $description;
		}

		if ( $service_type ) {
			$schema['serviceType'] = $service_type;
		}

		if ( $service_area ) {
			$schema['areaServed'] = $service_area;
		}

		if ( $cta_url ) {
			$schema['offers'] = array(
				'@type' => 'Offer',
				'url'   => $cta_url,
			);
		}

		echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
	}
}
