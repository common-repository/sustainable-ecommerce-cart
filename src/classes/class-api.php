<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

use WP_Error;
use Automattic\WooCommerce\Admin\Overrides\Order;

class Api extends Singleton {

	/**
	 * @param array $data
	 *
	 * @return array|false|WP_Error
	 */
	public function registration( $data ) {
		if ( ! is_array( $data ) ) {
			return false;
		}

		$json_body = wp_json_encode(
			array_merge(
				$data,
				[
					'secret_key'             => Helper::get_instance()->get_secret_key(),
					'email_verification_url' => Helper::get_instance()->get_page_link( Constants::ACTION_MAIN ),
					'site_url'               => get_site_url(),
					'site_name'              => get_bloginfo( 'name' ),
					'admin_email'            => get_option( 'admin_email' ),
				]
			)
		);

		if ( $json_body === false ) {
			return false;
		}

		return wp_remote_request(
			Helper::get_instance()->get_server_rest_api_url() . '/registration',
			[
				'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
				'body'    => $json_body,
				'method'  => 'POST',
				'timeout' => Constants::API_REQUEST_TIMEOUT_SECONDS,
			]
		);
	}

	/**
	 * @param string $email_secret_key
	 *
	 * @return array|false|WP_Error
	 */
	public function verify_email( $email_secret_key ) {
		$jwt              = Helper::get_instance()->get_jwt();
		$email_secret_key = sanitize_text_field( $email_secret_key );

		if ( ! $jwt || ! $email_secret_key ) {
			return false;
		}

		$json_body = wp_json_encode(
			[
				'jwt'              => $jwt,
				'email_secret_key' => $email_secret_key,
			]
		);

		return wp_remote_request(
			Helper::get_instance()->get_server_rest_api_url() . '/verify_email',
			[
				'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
				'body'    => $json_body,
				'method'  => 'POST',
				'timeout' => Constants::API_REQUEST_TIMEOUT_SECONDS,
			]
		);
	}

	/**
	 * @return array|false|WP_Error
	 */
	public function get_currency_rates() {
		$jwt = Helper::get_instance()->get_jwt();

		if ( ! $jwt ) {
			return false;
		}

		$json_body = wp_json_encode(
			[
				'jwt' => $jwt,
			]
		);

		if ( $json_body === false ) {
			return false;
		}

		return wp_remote_request(
			Helper::get_instance()->get_server_rest_api_url() . '/get_currency_rates',
			[
				'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
				'body'    => $json_body,
				'method'  => 'POST',
				'timeout' => Constants::API_REQUEST_TIMEOUT_SECONDS,
			]
		);
	}

	/**
	 * @param Order $order
	 * @param float $save_trees_fee
	 * @param bool $is_friendly_order
	 *
	 * @return array|false|void|WP_Error
	 */
	public function create_order( $order, $save_trees_fee, $is_friendly_order ) {
		if ( ! $order instanceof Order || ! is_numeric( $save_trees_fee ) ) {
			return false;
		}

		$jwt = Helper::get_instance()->get_jwt();

		if ( ! $jwt ) {
			return false;
		}

		$json_body = wp_json_encode(
			[
				'jwt'                => $jwt,
				'order_id'           => $order->get_id(),
				'donation_sum'       => $save_trees_fee,
				'currency'           => $order->get_currency(),
				'total_order_amount' => $order->get_subtotal(),
				'is_friendly_order'  => (bool) $is_friendly_order,
				'site_url'           => get_site_url(),
			]
		);

		if ( $json_body === false ) {
			return false;
		}

		return wp_remote_request(
			Helper::get_instance()->get_server_rest_api_url() . '/create_order',
			[
				'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
				'body'    => $json_body,
				'method'  => 'POST',
				'timeout' => Constants::API_REQUEST_TIMEOUT_SECONDS,
			]
		);
	}

	/**
	 * @param array $orders
	 *
	 * @return array|false|void|WP_Error
	 */
	public function batch_insert_orders( $orders ) {
		if ( ! is_array( $orders ) ) {
			return false;
		}

		$jwt = Helper::get_instance()->get_jwt();

		if ( ! $jwt ) {
			return false;
		}

		$json_body = wp_json_encode(
			[
				'jwt'    => $jwt,
				'orders' => $orders,
			]
		);

		if ( $json_body === false ) {
			return;
		}

		return wp_remote_request(
			Helper::get_instance()->get_server_rest_api_url() . '/batch_insert_orders',
			[
				'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
				'body'    => $json_body,
				'method'  => 'POST',
				'timeout' => Constants::API_REQUEST_TIMEOUT_SECONDS,
			]
		);
	}

	/**
	 * @return array|false|WP_Error
	 */
	public function check_access() {
		$jwt = Helper::get_instance()->get_jwt();

		if ( ! $jwt ) {
			return false;
		}

		$json_body = wp_json_encode(
			[
				'jwt' => $jwt,
			]
		);

		if ( $json_body === false ) {
			return false;
		}

		return wp_remote_request(
			Helper::get_instance()->get_server_rest_api_url() . '/check_access',
			[
				'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
				'body'    => $json_body,
				'method'  => 'POST',
				'timeout' => Constants::API_REQUEST_TIMEOUT_SECONDS,
			]
		);
	}

	/**
	 * @param array $response
	 *
	 * @return array
	 */
	public function process_response( $response ) {
		$res = [
			'data'   => [],
			'errors' => [],
			'code'   => 0,
		];

		if ( ! is_array( $response ) ) {
			$res['errors'][ Constants::FLASH_MESSAGES ][] = [
				'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
				'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
			];

			return $res;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );
		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		$res['code'] = $code;

		if ( $code === Constants::TOKEN_ERROR_CODE ) {
			Helper::get_instance()->reset_registration();
		}

		if ( $code === Constants::SITE_IS_SUSPENDED_ERROR_CODE ) {
			update_option( Constants::OPTION_SITE_IS_SUSPENDED, true );
		}

		if ( $code === Constants::WEBSITE_NOT_VERIFIED_ERROR_CODE ) {
			update_option( Constants::OPTION_EMAIL_IS_VERIFIED, false );
		}

		if ( $code === Constants::OK_CODE ) {
			$res['data'] = $body;

			return $res;
		}

		if ( ! $code || ! is_array( $body ) || ! $body ) {
			$res['errors'][ Constants::FLASH_MESSAGES ][] = [
				'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
				'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
			];

			return $res;
		}

		//Validation error
		if ( $code === Constants::VALIDATION_ERROR_CODE ) {
			$params = $body['data']['params'] ?? false;

			if ( ! is_array( $params ) ) {
				$res['errors'][ Constants::FLASH_MESSAGES ][] = [
					'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
					'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
				];

				return $res;
			}

			$field_errors = [];

			foreach ( $params as $k => $v ) {
				if ( $k === 'first_name' ) {
					$field_errors[ $k ] = Helper::get_instance()->get_message( Constants::MSG_FIRST_NAME_ERROR );
				}
				if ( $k === 'last_name' ) {
					$field_errors[ $k ] = Helper::get_instance()->get_message( Constants::MSG_LAST_NAME_ERROR );
				}
				if ( $k === 'email' ) {
					$field_errors[ $k ] = Helper::get_instance()->get_message( Constants::MSG_EMAIL_ERROR );
				}
				if ( $k === 'email_secret_key' ) {
					$field_errors[ $k ] = Helper::get_instance()->get_message( Constants::MSG_INVALID_EMAIL_SECRET_KEY );
				}
			}

			if ( $field_errors ) {
				$res['errors'][ Constants::FIELDS_ERRORS ] = $field_errors;

				return $res;
			}

			$res['errors'][ Constants::FLASH_MESSAGES ][] = [
				'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
				'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
			];
		} elseif (
			$code === Constants::CLIENT_ERROR_CODE ||
			$code === Constants::SERVER_ERROR_CODE ||
			$code === Constants::TOKEN_ERROR_CODE ||
			$code === Constants::WEBSITE_NOT_VERIFIED_ERROR_CODE
		) {
			$message = sanitize_text_field( $body['message'] ?? '' );
			if ( ! $message ) {
				$message = Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US );
			}

			$res['errors'][ Constants::FLASH_MESSAGES ][] =
				[
					'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
					'message' => $message,
				];
		} else { //Unknown errors
			$res['errors'][ Constants::FLASH_MESSAGES ][] = [
				'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
				'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
			];
		}

		return $res;
	}

}
