<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SB1_Services_Meta_Boxes {

	public static function add() {
		add_meta_box(
			'sb1-services-meta',
			__( 'Service Details', 'wp-sb1-services' ),
			array( __CLASS__, 'render' ),
			'service',
			'normal',
			'high'
		);
	}

	public static function render( $post ) {
		wp_nonce_field( 'sb1_services_meta_save', 'sb1_services_meta_nonce' );

		$short_description = get_post_meta( $post->ID, '_sb1_short_description', true );
		$icon              = get_post_meta( $post->ID, '_sb1_icon', true );
		$cta_url           = get_post_meta( $post->ID, '_sb1_cta_url', true );
		$service_area      = get_post_meta( $post->ID, '_sb1_service_area', true );
		$service_type      = get_post_meta( $post->ID, '_sb1_service_type', true );
		?>
		<div id="sb1-services-meta">
			<div class="sb1-meta-field">
				<label for="sb1_short_description"><?php esc_html_e( 'Short Description', 'wp-sb1-services' ); ?></label>
				<textarea id="sb1_short_description" name="sb1_short_description" rows="3"><?php echo esc_textarea( $short_description ); ?></textarea>
			</div>

			<div class="sb1-meta-field">
				<label for="sb1_icon"><?php esc_html_e( 'Icon (URL or CSS class)', 'wp-sb1-services' ); ?></label>
				<input type="text" id="sb1_icon" name="sb1_icon" value="<?php echo esc_attr( $icon ); ?>" />
				<p class="description"><?php esc_html_e( 'Enter an image URL or a CSS class (e.g. fa-solid fa-gear).', 'wp-sb1-services' ); ?></p>
			</div>

			<div class="sb1-meta-field">
				<label for="sb1_cta_url"><?php esc_html_e( 'CTA Button URL', 'wp-sb1-services' ); ?></label>
				<input type="url" id="sb1_cta_url" name="sb1_cta_url" value="<?php echo esc_attr( $cta_url ); ?>" />
			</div>

			<div class="sb1-meta-field">
				<label for="sb1_service_type"><?php esc_html_e( 'Service Type', 'wp-sb1-services' ); ?></label>
				<input type="text" id="sb1_service_type" name="sb1_service_type" value="<?php echo esc_attr( $service_type ); ?>" />
				<p class="description"><?php esc_html_e( 'e.g. Web Design, Consulting, Photography — used in Schema.org markup.', 'wp-sb1-services' ); ?></p>
			</div>

			<div class="sb1-meta-field">
				<label for="sb1_service_area"><?php esc_html_e( 'Area Served', 'wp-sb1-services' ); ?></label>
				<input type="text" id="sb1_service_area" name="sb1_service_area" value="<?php echo esc_attr( $service_area ); ?>" />
				<p class="description"><?php esc_html_e( 'e.g. New York, Nationwide — used in Schema.org markup.', 'wp-sb1-services' ); ?></p>
			</div>
		</div>
		<?php
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['sb1_services_meta_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['sb1_services_meta_nonce'], 'sb1_services_meta_save' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['sb1_short_description'] ) ) {
			update_post_meta( $post_id, '_sb1_short_description', sanitize_textarea_field( $_POST['sb1_short_description'] ) );
		}

		if ( isset( $_POST['sb1_icon'] ) ) {
			update_post_meta( $post_id, '_sb1_icon', sanitize_text_field( $_POST['sb1_icon'] ) );
		}

		if ( isset( $_POST['sb1_cta_url'] ) ) {
			$cta_url = esc_url_raw( $_POST['sb1_cta_url'] );
			if ( $cta_url ) {
				update_post_meta( $post_id, '_sb1_cta_url', $cta_url );
			} else {
				delete_post_meta( $post_id, '_sb1_cta_url' );
			}
		}

		if ( isset( $_POST['sb1_service_type'] ) ) {
			update_post_meta( $post_id, '_sb1_service_type', sanitize_text_field( $_POST['sb1_service_type'] ) );
		}

		if ( isset( $_POST['sb1_service_area'] ) ) {
			update_post_meta( $post_id, '_sb1_service_area', sanitize_text_field( $_POST['sb1_service_area'] ) );
		}
	}

	public static function enqueue_styles( $hook ) {
		global $post;

		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		if ( ! $post || 'service' !== $post->post_type ) {
			return;
		}

		wp_enqueue_style(
			'sb1-services-admin',
			SB1_SERVICES_URL . 'assets/css/admin.css',
			array(),
			SB1_SERVICES_VERSION
		);
	}
}
