<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SB1_Services_Shortcode {

	public static function register() {
		add_shortcode( 'sb1_services', array( __CLASS__, 'render' ) );
	}

	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'count'   => -1,
				'tag'     => '',
				'columns' => 3,
				'orderby' => 'menu_order',
				'order'   => 'ASC',
			),
			$atts,
			'sb1_services'
		);

		$query_args = array(
			'post_type'      => 'service',
			'posts_per_page' => intval( $atts['count'] ),
			'orderby'        => sanitize_key( $atts['orderby'] ),
			'order'          => in_array( strtoupper( $atts['order'] ), array( 'ASC', 'DESC' ), true ) ? strtoupper( $atts['order'] ) : 'ASC',
		);

		if ( ! empty( $atts['tag'] ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'service_tag',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $atts['tag'] ),
				),
			);
		}

		$services = new WP_Query( $query_args );

		if ( ! $services->have_posts() ) {
			return '';
		}

		$columns = max( 1, intval( $atts['columns'] ) );

		ob_start();

		$template = self::locate_template();
		include $template;

		wp_reset_postdata();

		return ob_get_clean();
	}

	private static function locate_template() {
		$theme_template = locate_template( 'sb1-services/services-grid.php' );

		if ( $theme_template ) {
			return $theme_template;
		}

		return SB1_SERVICES_DIR . 'templates/services-grid.php';
	}
}
