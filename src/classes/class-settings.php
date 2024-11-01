<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Settings extends Singleton {

	/**
	 * @return void
	 */
	public function init() {
		add_action( 'admin_menu', [ $this, 'register_page' ] );
		add_action( 'wp_ajax_netzero_sm_switch_units', [ $this, 'ajax_handle_switch_units' ] );
		add_action( 'wp_ajax_nopriv_netzero_sm_switch_units', [ $this, 'ajax_handle_switch_units' ] );
	}

	/**
	 * @return void
	 */
	public function ajax_handle_switch_units() {
		$nonce = sanitize_text_field( $_POST['nonce'] ?? '' );

		if ( ! wp_verify_nonce( $nonce, Constants::ADMIN_NONCE ) ) {
			wp_send_json_error( null, Constants::UNAUTHORIZED_CODE );
		}

		$units_is_metric = isset( $_POST['units'] ) && sanitize_text_field( $_POST['units'] ) !== 'false';

		update_option( Constants::OPTION_UNITS_IS_METRIC, $units_is_metric );

		wp_send_json_success();
	}

	/**
	 * @return void
	 */
	public function register_page() {
		add_menu_page(
			esc_html__( 'Sustainable eCommerce Cart', 'rgbc_netzero_sm' ),
			'Sustainable eCommerce Cart',
			Constants::PLUGIN_CAPABILITY,
			Constants::SETTINGS_SLUG,
			[ $this, 'render_settings' ],
			RGBC_NETZERO_SM_URL . '/src/assets/images/menu-icon.svg',
			58
		);
		add_action( 'admin_init', [ $this, 'process_render_settings' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	/**
	 * @return void
	 */
	public function process_render_settings() {
		if ( ! Helper::get_instance()->is_settings_page() ) {
			return;
		}

		Flash::get_instance();

		remove_all_actions( 'user_admin_notices' );
		remove_all_actions( 'admin_notices' );

		Router::get_instance()->run();
	}

	/**
	 * @return void
	 */
	public function render_settings() {
		Router::get_instance()->load_template();
	}

	/**
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		if ( ! Helper::get_instance()->is_settings_page() ) {
			return;
		}

		$css_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/back/back.min.*.css' );
		$css_file_path = $css_file_path ? $css_file_path[0] : false;
		if ( $css_file_path ) {
			$css_file_url = RGBC_NETZERO_SM_URL . '/build/back/' . basename( $css_file_path );
			wp_enqueue_style( 'rgbc_netzero_sm_back_css', $css_file_url, [], RGBC_NETZERO_SM_VER );
		}

		$js_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/back/back.min.*.js' );
		$js_file_path = $js_file_path ? $js_file_path[0] : false;
		if ( $js_file_path ) {
			$js_file_uri = RGBC_NETZERO_SM_URL . '/build/back/' . basename( $js_file_path );
			wp_enqueue_script( 'rgbc_netzero_sm_back_js', $js_file_uri, null, RGBC_NETZERO_SM_VER, true );

			wp_localize_script(
				'rgbc_netzero_sm_back_js',
				'rgbc_netzero_sm_back',
				[
					'ajax_url'               => admin_url( 'admin-ajax.php' ),
					'nonce'                  => wp_create_nonce( Constants::ADMIN_NONCE ),
					'plugin_url'             => RGBC_NETZERO_SM_URL,
					'jwt'                    => Helper::get_instance()->get_jwt(),
					'api_url'                => Helper::get_instance()->get_server_rest_api_url(),
					'email_verification_url' => Helper::get_instance()->get_page_link( Constants::ACTION_MAIN ),
				]
			);
		}
	}
}
