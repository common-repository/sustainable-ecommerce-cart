<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Wp_Admin extends Singleton {
	/**
	 * @return void
	 */
	public function init() {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

		if ( Helper::get_instance()->user_is_registered() ) {
			add_action( 'pre_current_active_plugins', [ $this, 'deactivation_prompt' ] );
		}
	}

	/**
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		$css_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/wp-admin/wp-admin.min.*.css' );
		$css_file_path = $css_file_path ? $css_file_path[0] : false;
		if ( $css_file_path ) {
			$css_file_url = RGBC_NETZERO_SM_URL . '/build/wp-admin/' . basename( $css_file_path );
			wp_enqueue_style( 'rgbc_netzero_sm_wp_admin_css', $css_file_url, [], RGBC_NETZERO_SM_VER );
		}

		$js_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/wp-admin/wp-admin.min.*.js' );
		$js_file_path = $js_file_path ? $js_file_path[0] : false;
		if ( $js_file_path ) {
			$js_file_uri = RGBC_NETZERO_SM_URL . '/build/wp-admin/' . basename( $js_file_path );
			wp_enqueue_script( 'rgbc_netzero_sm_wp_admin_js', $js_file_uri, null, RGBC_NETZERO_SM_VER, true );

			wp_localize_script(
				'rgbc_netzero_sm_wp_admin_js',
				'rgbc_netzero_sm_wp_admin',
				[
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( Constants::ADMIN_NONCE ),
					'api_url'  => Helper::get_instance()->get_server_rest_api_url(),
					'jwt'      => Helper::get_instance()->get_jwt(),
				]
			);
		}
	}

	/**
	 * @return void
	 */
	public function deactivation_prompt() {
		load_template( RGBC_NETZERO_SM_DIR . '/src/templates/wp-admin/deactivation-prompt.php', false );
	}
}
