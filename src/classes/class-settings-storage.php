<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Settings_Storage extends Singleton {

	/**
	 * @param string $action
	 * @param array $data
	 *
	 * @return bool
	 */
	public function save_settings( $action, $data ) {
		$action = (string) $action;

		if ( ! is_array( $data ) ) {
			return false;
		}

		switch ( $action ) {
			case Constants::ACTION_SETTINGS:
				$widget_is_enabled          = isset( $data['widget_is_enabled'] );
				$enable_widget_on_cart_page = isset( $data['widget_is_enabled_on_cart_page'] );
				$enable_widget_on_mini_cart = isset( $data['widget_is_enabled_on_mini_cart'] );
				$enable_widget_on_checkout  = isset( $data['widget_is_enabled_on_checkout'] );

				update_option( Constants::OPTION_WIDGET_IS_ENABLED, $widget_is_enabled );
				update_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_CART, $enable_widget_on_cart_page );
				update_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_MINI_CART, $enable_widget_on_mini_cart );
				update_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_CHECKOUT, $enable_widget_on_checkout );

				return true;

			case Constants::ACTION_DESIGN:
				$widget_place = sanitize_text_field( $data['widget_place'] ?? Constants::WIDGET_PLACE_A );
				$widget_color = sanitize_text_field( $data['widget_color'] ?? Constants::WIDGET_COLOR_WHITE );

				update_option( Constants::OPTION_WIDGET_PLACE, $widget_place );
				update_option( Constants::OPTION_WIDGET_COLOR, $widget_color );

				return true;
		}

		return false;
	}

}
