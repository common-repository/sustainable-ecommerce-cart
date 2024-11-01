<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use PHPMailer\PHPMailer\Exception;
use Throwable;
use WP_Error;
use WP_REST_Request;

class Rest_Routes extends Singleton {

	/**
	 * @return void
	 */
	public function init() {
		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
	}

	/**
	 * @return void
	 */
	public function register_rest_routes() {
		/**
		 * Site verification
		 */
		register_rest_route(
			'netzero/v1',
			'/site_verification',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'site_verification' ],
				'permission_callback' => '__return_true',
				'args'                => [
					'secret_key' => [
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => [ Rest_Helper::get_instance(), 'sanitize_text_field' ],
						'validate_callback' => [ Rest_Helper::get_instance(), 'validate_sanitized_text_field' ],
						'min_length'        => Constants::SECRET_KEYS_LENGTH,
						'max_length'        => Constants::SECRET_KEYS_LENGTH,
					],
				],
			]
		);

		/**
		 * Site verification
		 */
		register_rest_route(
			'netzero/v1',
			'/ping',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'ping' ],
				'permission_callback' => '__return_true',
				'args'                => [
					'jwt' => [
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => [ Rest_Helper::get_instance(), 'sanitize_text_field' ],
					],
				],
			]
		);

		/**
		 * Suspend site
		 */
		register_rest_route(
			'netzero/v1',
			'/suspend_site',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'suspend_site' ],
				'permission_callback' => '__return_true',
				'args'                => [
					'website_secret_key' => [
						'required'          => true,
						'type'              => 'string',
						'validate_callback' => [ Rest_Helper::get_instance(), 'validate_sanitized_text_field' ],
						'sanitize_callback' => [ Rest_Helper::get_instance(), 'sanitize_text_field' ],
					],
				],
			]
		);
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return bool[]|WP_Error
	 */
	public function site_verification( $request ) {
		try {
			$site_secret_key = Helper::get_instance()->get_secret_key();
			$secret_key      = $request->get_param( 'secret_key' );

			if ( mb_strlen( $secret_key ) !== Constants::SECRET_KEYS_LENGTH || $secret_key !== $site_secret_key ) {
				throw new Exception( esc_html__( 'Invalid secret key', 'rgbc_netzero_sm' ) );
			}

			return [
				'site_verification' => true,
			];
		} catch ( Throwable $e ) {
			return new WP_Error(
				Constants::VALIDATION_ERROR_CODE,
				esc_html__( 'Verification error', 'rgbc_netzero_sm' ),
				[ 'status' => Constants::VALIDATION_ERROR_CODE ]
			);
		}
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return true[]
	 */
	public function ping( $request ) {
		return [
			'jwt' => sanitize_text_field( $request->get_param( 'jwt' ) ),
		];
	}

	/**
	 * @param $request
	 *
	 * @return true[]|WP_Error
	 */
	public function suspend_site( $request ) {
		$website_secret_key        = $request->get_param( 'website_secret_key' );
		$stored_website_secret_key = Helper::get_instance()->get_secret_key();

		if ( ! $website_secret_key || $website_secret_key !== $stored_website_secret_key ) {
			return new WP_Error(
				Constants::CLIENT_ERROR_CODE,
				esc_html__( 'Invalid site secret key', 'rgbc_netzero_sm' ),
				[ 'status' => Constants::CLIENT_ERROR_CODE ]
			);
		}

		update_option( Constants::OPTION_SITE_IS_SUSPENDED, true );

		return [ 'site_suspended' => true ];
	}
}
