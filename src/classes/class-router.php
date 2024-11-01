<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Router extends Singleton {
	private $template_file = '';
	private $template_args = [];

	private $registered_users_forbidden_actions = [
		Constants::ACTION_REGISTRATION,
	];

	private $unregistered_users_forbidden_actions = [];

	/**
	 * @return void
	 */
	public function run() {
		$action = sanitize_text_field( $_GET['action'] ?? '' );

		if ( Helper::get_instance()->user_is_registered() ) {
			if ( in_array( $action, $this->registered_users_forbidden_actions, true ) ) {
				wp_safe_redirect( add_query_arg( [ 'action' => Constants::ACTION_MAIN ], esc_url_raw( $_SERVER['REQUEST_URI'] ) ) );
				exit();
			}
		} else {
			if ( in_array( $action, $this->unregistered_users_forbidden_actions, true ) ) {
				wp_safe_redirect( add_query_arg( [ 'action' => Constants::ACTION_WELCOME ], esc_url_raw( $_SERVER['REQUEST_URI'] ) ) );
				exit();
			}
		}

		$settings_saved = false;

		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( ! wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ?? '' ), Constants::ADMIN_NONCE ) ) {
				Flash::get_instance()->add(
					Constants::FLASH_MESSAGES,
					[
						'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
						'message' => esc_html__( 'Security token expired. Please try again', 'rgbc_netzero_sm' ),
					]
				);
				wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
				exit();
			}

			$settings_saved = Settings_Storage::get_instance()->save_settings( $action, $_POST );
		}

		if ( $settings_saved ) {
			Flash::get_instance()->add(
				Constants::FLASH_MESSAGES,
				[
					'type'    => Constants::FLASH_MESSAGE_TYPE_SUCCESS,
					'message' => Helper::get_instance()->get_message( Constants::MSG_SUCCESSFULLY_UPDATED ),
				]
			);

			wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
			exit();
		}

		switch ( $action ) {
			//Welcome
			case Constants::ACTION_WELCOME:
				$this->set_template( RGBC_NETZERO_SM_DIR . '/src/templates/welcome.php', [] );
				break;
			//Registration
			case Constants::ACTION_REGISTRATION:
				if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
					$data = Registration::get_instance()->sanitize_registration_fields( $_POST );

					Flash::get_instance()->set(
						Constants::FIELDS_VALUES,
						$data
					);

					$errors = Registration::get_instance()->validate_registration_fields( $data );

					if ( $errors ) {
						Flash::get_instance()->set( Constants::FIELDS_ERRORS, $errors );
						wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
						exit();
					}

					$response = Api::get_instance()->registration( $data );

					if ( ! $response || is_wp_error( $response ) ) {
						Flash::get_instance()->add(
							Constants::FLASH_MESSAGES,
							[
								'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
								'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
							]
						);

						wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
						exit();
					}

					$res    = Api::get_instance()->process_response( $response );
					$errors = $res['errors'] ?? false;

					if ( $errors ) {
						Helper::get_instance()->save_flash_errors( $errors );

						wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
						exit();
					}

					$jwt = $res['data']['jwt'] ?? '';
					$res = Helper::get_instance()->save_jwt( $jwt );

					if ( ! $res ) {
						Flash::get_instance()->add(
							Constants::FLASH_MESSAGES,
							[
								'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
								'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
							]
						);

						wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
						exit();
					}

					wp_safe_redirect( add_query_arg( [ 'action' => Constants::ACTION_WELCOME ], esc_url_raw( $_SERVER['REQUEST_URI'] ) ) );
					exit();
				}

				$this->set_template(
					RGBC_NETZERO_SM_DIR . '/src/templates/register-form.php',
					[
						'flash' => Flash::get_instance()->get(),
					]
				);
				break;
			case Constants::ACTION_SETTINGS:
				$this->set_template(
					RGBC_NETZERO_SM_DIR . '/src/templates/settings.php',
					[
						'flash' => Flash::get_instance()->get(),
					]
				);
				break;
			case Constants::ACTION_DESIGN:
				$this->set_template(
					RGBC_NETZERO_SM_DIR . '/src/templates/design.php',
					[
						'flash' => Flash::get_instance()->get(),
					]
				);
				break;
			case Constants::ACTION_ACCOUNT:
				$this->set_template(
					RGBC_NETZERO_SM_DIR . '/src/templates/account.php',
					[
						'this_month_stat' => Orders_Stat::get_instance()->get_this_month_stat(),
						'last_month_stat' => Orders_Stat::get_instance()->get_last_month_stat(),
						'this_year_stat'  => Orders_Stat::get_instance()->get_this_year_stat(),
					]
				);
				break;
			case Constants::ACTION_JOURNEY:
				$this->set_template(
					RGBC_NETZERO_SM_DIR . '/src/templates/journey.php'
				);
				break;
			case Constants::ACTION_START:
				$this->set_template(
					RGBC_NETZERO_SM_DIR . '/src/templates/start.php'
				);
				break;
			case Constants::ACTION_MAIN:
				$email_secret_key = sanitize_text_field( $_GET['email_secret_key'] ?? '' );

				if ( $email_secret_key ) {
					$request_uri = remove_query_arg( [ 'email_secret_key' ], esc_url_raw( $_SERVER['REQUEST_URI'] ) );

					$response = Api::get_instance()->verify_email( $email_secret_key );

					if ( ! $response || is_wp_error( $response ) ) {
						Flash::get_instance()->add(
							Constants::FLASH_MESSAGES,
							[
								'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
								'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
							]
						);

						wp_safe_redirect( $request_uri );
						exit();
					}

					$res    = Api::get_instance()->process_response( $response );
					$errors = $res['errors'] ?? false;

					if ( $errors ) {
						Helper::get_instance()->save_flash_errors( $errors );

						wp_safe_redirect( $request_uri );
						exit();
					}

					$confirm_email = $res['data']['verify_email'] ?? false;

					if ( ! $confirm_email ) {
						Flash::get_instance()->add(
							Constants::FLASH_MESSAGES,
							[
								'type'    => Constants::FLASH_MESSAGE_TYPE_ERROR,
								'message' => Helper::get_instance()->get_message( Constants::MSG_ERROR_PLEASE_CONTACT_US ),
							]
						);

						wp_safe_redirect( $request_uri );
						exit();
					}

					update_option( Constants::OPTION_EMAIL_IS_VERIFIED, true );

					wp_safe_redirect( $request_uri );
					exit();
				}

				if ( Helper::get_instance()->site_is_suspended() ) {
					$this->set_template( RGBC_NETZERO_SM_DIR . '/src/templates/site-suspended.php' );
				} else {
					$this->set_template(
						RGBC_NETZERO_SM_DIR . '/src/templates/main.php',
						[
							'flash'             => Flash::get_instance()->get(),
							'total_stat'        => Orders_Stat::get_instance()->get_stats_since_install_plugin(),
							'monthly_stat'      => Orders_Stat::get_instance()->get_month_stat(),
							'last_month_stat'   => Orders_Stat::get_instance()->get_last_month_stat(),
							'units_is_imperial' => ! Helper::get_instance()->units_is_metric(),
						]
					);
				}
				break;
			default:
				if ( Helper::get_instance()->user_is_registered() ) {
					wp_safe_redirect( Helper::get_instance()->get_page_link( Constants::ACTION_MAIN ) );
					exit();
				}

				wp_safe_redirect( Helper::get_instance()->get_page_link( Constants::ACTION_REGISTRATION ) );
				exit( '' );
		}
	}

	/**
	 * @param string $template_file
	 * @param array $args
	 *
	 * @return bool
	 */
	private function set_template( $template_file, $args = [] ) {
		if ( ! file_exists( sanitize_text_field( $template_file ) ) ) {
			return false;
		}

		$args = is_array( $args ) ? $args : [];

		$this->template_file = $template_file;
		$this->template_args = $args;

		return true;
	}

	/**
	 * @return bool
	 */
	public function load_template() {
		if ( file_exists( $this->template_file ) ) {
			load_template( $this->template_file, false, $this->template_args );

			return true;
		}

		return false;
	}
}
