<?php
/**
 * Plugin Name: SB1 Services
 * Plugin URI: https://sitebuilderone.com/
 * Description: Adds a Services custom post type, service tags, custom fields, REST metadata, schema markup, and a services grid shortcode.
 * Version: 1.0.0
 * Author: SiteBuilderOne
 * Text Domain: wp-sb1-services
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package WP_SB1_Services
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SB1_SERVICES_VERSION', '1.0.0' );
define( 'SB1_SERVICES_DIR', plugin_dir_path( __FILE__ ) );
define( 'SB1_SERVICES_URL', plugin_dir_url( __FILE__ ) );

require_once SB1_SERVICES_DIR . 'includes/class-cpt.php';
require_once SB1_SERVICES_DIR . 'includes/class-taxonomy.php';
require_once SB1_SERVICES_DIR . 'includes/class-meta-boxes.php';
require_once SB1_SERVICES_DIR . 'includes/class-rest-fields.php';
require_once SB1_SERVICES_DIR . 'includes/class-shortcode.php';
require_once SB1_SERVICES_DIR . 'includes/class-schema.php';

function sb1_services_activate() {
	SB1_Services_CPT::register();
	SB1_Services_Taxonomy::register();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'sb1_services_activate' );

function sb1_services_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'sb1_services_deactivate' );

add_action( 'init', array( 'SB1_Services_CPT', 'register' ) );
add_action( 'init', array( 'SB1_Services_Taxonomy', 'register' ) );
add_action( 'init', array( 'SB1_Services_Rest_Fields', 'register' ) );
add_action( 'add_meta_boxes', array( 'SB1_Services_Meta_Boxes', 'add' ) );
add_action( 'save_post_service', array( 'SB1_Services_Meta_Boxes', 'save' ) );
add_action( 'admin_enqueue_scripts', array( 'SB1_Services_Meta_Boxes', 'enqueue_styles' ) );
add_action( 'init', array( 'SB1_Services_Shortcode', 'register' ) );
add_action( 'init', array( 'SB1_Services_Schema', 'register' ) );
