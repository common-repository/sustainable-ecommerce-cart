<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use WP_Post;

class Plugin_Control extends Singleton {

	/**
	 * @return void
	 */
	public function on_activate() {
		if ( is_multisite() ) {
			exit( esc_html__( 'Plugin not activated: multisite is not supported', 'rgbc_netzero_sm' ) );
		}

		$plugin_activation_time = Helper::get_instance()->get_plugin_activation_time();

		if ( ! $plugin_activation_time ) {
			update_option( Constants::PLUGIN_ACTIVATION_TIME_OPTION_NAME, time() );
		}
	}

	/**
	 * @return void
	 */
	public function on_deactivate() {
		$this->delete_netzero_product();
		Helper::get_instance()->reset_registration();
	}

	/**
	 * @return void
	 */
	private function delete_netzero_product() {
		$save_trees_product = Save_Trees::get_instance()->get_save_trees_product();

		if ( $save_trees_product instanceof WP_Post ) {
			$save_trees_product = wc_get_product( $save_trees_product );

			if ( $save_trees_product instanceof WC_Product_Save_Trees ) {
				$product_id = $save_trees_product->get_id();
				$res        = $save_trees_product->delete( true );

				if ( $res ) {
					$deleted_products   = get_option( Constants::DELETED_NETZERO_PRODUCTS_OPTION_NAME, [] );
					$deleted_products   = is_array( $deleted_products ) ? $deleted_products : [];
					$deleted_products[] = $product_id;
					update_option( Constants::DELETED_NETZERO_PRODUCTS_OPTION_NAME, array_unique( $deleted_products ), false );
				}
			}
		}
	}
}
