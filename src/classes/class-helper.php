<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use WooCommerce;

class Helper extends Singleton {

	/**
	 * @return string
	 */
	public function get_server_rest_api_url() {
		return $this->is_dev_mode() && defined( 'RGBC_NETZERO_SM_REST_API_SERVER_URL' ) ? RGBC_NETZERO_SM_REST_API_SERVER_URL : Constants::REST_API_SERVER_URL;
	}

	/**
	 * @return bool
	 */
	public function is_dev_mode() {
		return defined( 'RGBC_NETZERO_SM_DEV_MODE' ) && RGBC_NETZERO_SM_DEV_MODE === true;
	}

	/**
	 * @return string
	 */
	public function get_secret_key() {
		$secret_key = get_option( Constants::SITE_SECRET_KEY_OPTION_NAME );

		$secret_key = is_string( $secret_key ) ? $secret_key : '';

		if ( mb_strlen( $secret_key ) !== Constants::SECRET_KEYS_LENGTH ) {
			$secret_key = md5( wp_generate_password( 32, true, true ) );
			update_option( Constants::SITE_SECRET_KEY_OPTION_NAME, sanitize_text_field( $secret_key ), false );
		}

		return $secret_key;
	}

	/**
	 * @param string $jwt
	 *
	 * @return bool
	 */
	public function save_jwt( $jwt ) {
		if ( ! $this->parse_jwt( $jwt ) ) {
			return false;
		}

		update_option( Constants::JWT_OPTION_NAME, $jwt, false );

		return true;
	}

	/**
	 * @return false|mixed|null
	 */
	public function get_jwt() {
		return get_option( Constants::JWT_OPTION_NAME );
	}

	/**
	 * @return bool
	 */
	public function user_is_registered() {
		return ! empty( sanitize_text_field( get_option( Constants::JWT_OPTION_NAME ) ) );
	}

	/**
	 * @return void
	 */
	public function reset_registration() {
		update_option( Constants::JWT_OPTION_NAME, '', false );
		update_option( Constants::OPTION_WIDGET_IS_ENABLED, false );
		update_option( Constants::OPTION_EMAIL_IS_VERIFIED, false );
	}

	/**
	 * @param string $jwt
	 *
	 * @return array|false
	 */
	public function parse_jwt( $jwt ) {
		if ( ! is_string( $jwt ) ) {
			return false;
		}

		$token_parts = explode( '.', $jwt );
		if ( ! is_array( $token_parts ) ) {
			return false;
		}

		//phpcs:ignore
		$header    = json_decode( base64_decode( $token_parts[0] ?? '' ) );
		//phpcs:ignore
		$payload   = json_decode( base64_decode( $token_parts[1] ?? '' ) );
		$signature = $token_parts[2] ?? '';

		if ( ! $header || ! $payload || ! $signature ) {
			return false;
		}

		return [
			'header'    => $header,
			'payload'   => $payload,
			'signature' => $signature,
		];
	}

	/**
	 * @param string $relative_path
	 *
	 * @return string
	 */
	public function get_url( $relative_path ) {
		$relative_path = sanitize_text_field( $relative_path );

		return RGBC_NETZERO_SM_URL . "/$relative_path";
	}

	/**
	 * @param string $page_name
	 *
	 * @return string
	 */
	public function get_page_link( $page_name ) {
		return add_query_arg(
			[
				'page'   => Constants::SETTINGS_SLUG,
				'action' => sanitize_text_field( $page_name ),
			],
			get_admin_url( null, 'admin.php' )
		);
	}

	/**
	 * @param string $page_name
	 *
	 * @return bool
	 */
	public function page_is_active( $page_name ) {
		$page_name = sanitize_text_field( $page_name );
		//phpcs:ignore
		$action    = sanitize_text_field( $_GET['action'] ?? '' );

		return $page_name === $action;
	}

	/**
	 * @return bool
	 */
	public function is_woocommerce_activated() {
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	}

	/**
	 * @return string
	 */
	public function get_widget_place() {
		return (string) get_option( Constants::OPTION_WIDGET_PLACE, Constants::WIDGET_PLACE_A );
	}

	/**
	 * @return string
	 */
	public function get_widget_color() {
		return (string) get_option( Constants::OPTION_WIDGET_COLOR, Constants::WIDGET_COLOR_WHITE );
	}

	/**
	 * @return bool
	 */
	public function is_settings_page() {
		global $pagenow;

		return $pagenow === 'admin.php' && filter_input( INPUT_GET, 'page' ) === Constants::SETTINGS_SLUG;
	}

	/**
	 * @return bool
	 */
	public function is_plugins_page() {
		global $pagenow;

		return $pagenow === 'plugins.php';
	}

	/**
	 * @param string $message_key
	 *
	 * @return string
	 */
	public function get_message( $message_key ) {
		switch ( $message_key ) {
			case Constants::MSG_FIRST_NAME_ERROR:
				return esc_html__( 'Invalid first name', 'rgbc_netzero_sm' );
			case Constants::MSG_LAST_NAME_ERROR:
				return esc_html__( 'Invalid last name', 'rgbc_netzero_sm' );
			case Constants::MSG_EMAIL_ERROR:
				return esc_html__( 'Invalid email', 'rgbc_netzero_sm' );
			case Constants::MSG_CONNECTION_SERVER_ERROR:
				return esc_html__( 'Connection to the server error. Please try again later', 'rgbc_netzero_sm' );
			case Constants::MSG_ERROR_PLEASE_CONTACT_US:
				return esc_html__( 'Something went wrong. Please contact service administrator', 'rgbc_netzero_sm' );
			case Constants::MSG_INVALID_EMAIL_SECRET_KEY:
				return esc_html__( 'Invalid email secret key', 'rgbc_netzero_sm' );
			case Constants::MSG_ACCEPT_TERMS_REQUIRED:
				return esc_html__( 'Accept Terms of Service is required', 'rgbc_netzero_sm' );
			case Constants::MSG_SUCCESSFULLY_UPDATED:
				return esc_html__( 'Successfully updated', 'rgbc_netzero_sm' );
			default:
				return '';
		}
	}

	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function save_flash_errors( $data ) {
		if ( ! is_array( $data ) || ! $data ) {
			return false;
		}

		$messages     = $data[ Constants::FLASH_MESSAGES ] ?? false;
		$field_errors = $data[ Constants::FIELDS_ERRORS ] ?? false;

		if ( $messages ) {
			Flash::get_instance()->set( Constants::FLASH_MESSAGES, $messages );
		}

		if ( $field_errors ) {
			Flash::get_instance()->set( Constants::FIELDS_ERRORS, $field_errors );
		}

		return true;
	}

	/**
	 * @return int
	 */
	public function get_plugin_activation_time() {
		return (int) get_option( Constants::PLUGIN_ACTIVATION_TIME_OPTION_NAME );
	}

	/**
	 * @return bool
	 */
	public function units_is_metric() {
		return get_option( Constants::OPTION_UNITS_IS_METRIC );
	}

	/**
	 * @param string $locale
	 *
	 * @return boolean
	 */
	public function translate_exists( $locale ) {
		return file_exists( RGBC_NETZERO_SM_DIR . "/languages/rgbc_netzero_sm-$locale.mo" );
	}

	/**
	 * @return string
	 */
	public function get_server_root_url() {
		$parsed_url = wp_parse_url( Constants::REST_API_SERVER_URL );

		if ( ! $parsed_url ) {
			return '';
		}

		$scheme = $parsed_url['scheme'] ?? '';
		$host   = $parsed_url['host'] ?? '';

		if ( ! $scheme || ! $host ) {
			return '';
		}

		return "{$scheme}://{$host}";
	}

	/**
	 * @return void
	 */
	public function update_site_suspended_status() {
		if ( ! $this->site_is_suspended() ) {
			return;
		}

		$res = get_transient( Constants::SITE_IS_SUSPENDED_TRANSIENT_NAME );

		if ( $res !== false ) {
			return;
		}

		$response = Api::get_instance()->check_access();

		if ( ! $response || is_wp_error( $response ) ) {
			return;
		}

		set_transient(
			Constants::SITE_IS_SUSPENDED_TRANSIENT_NAME,
			true,
			300
		);

		$res = Api::get_instance()->process_response( $response );

		$res = is_array( $res ) ? $res : [];

		$code = $res['code'] ?? 0;

		if ( $code === Constants::OK_CODE ) {
			update_option( Constants::OPTION_SITE_IS_SUSPENDED, false );
			if ( $this->is_settings_page() ) {
				wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
				exit();
			}
		}
	}

	/**
	 * @return bool
	 */
	public function widget_is_enabled() {
		return (bool) get_option( Constants::OPTION_WIDGET_IS_ENABLED );
	}

	/**
	 * @return bool
	 */
	public function site_is_suspended() {
		return (bool) get_option( Constants::OPTION_SITE_IS_SUSPENDED );
	}

	/**
	 * @return bool
	 */
	public function email_is_verified() {
		return (bool) get_option( Constants::OPTION_EMAIL_IS_VERIFIED );
	}

	/**
	 * @return bool
	 */
	public function site_is_active() {
		return $this->user_is_registered() && ! $this->site_is_suspended() && $this->email_is_verified();
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 */
	public function set_cart_items_on_widget_activated_moment( $data ) {
		if ( ! is_array( $data ) ) {
			return false;
		}

		$wc = function_exists( 'WC' ) ? WC() : false;

		if ( $wc instanceof WooCommerce ) {
			WC()->session->set( Constants::COOKIE_CART_ITEMS_ON_WIDGET_ACTIVATED_MOMENT, $data );

			return true;
		}

		return false;
	}

	/**
	 * @return array
	 */
	public function get_cart_items_on_widget_activated_moment() {
		$wc         = function_exists( 'WC' ) ? WC() : false;
		$cart_items = [];

		if ( $wc instanceof WooCommerce ) {
			$cart_items = WC()->session->get( Constants::COOKIE_CART_ITEMS_ON_WIDGET_ACTIVATED_MOMENT );
		}

		if ( ! is_array( $cart_items ) ) {
			return [];
		}

		return $cart_items;
	}

	/**
	 * @return void
	 */
	public function reset_cart_items_on_widget_activation_moment() {
		if ( ! Save_Trees::get_instance()->save_tree_product_exists() ) {
			$this->set_cart_items_on_widget_activated_moment( [] );
		}
	}
}
