<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Currency_Rates extends Singleton {

	/**
	 * @return array
	 */
	public function get_currency_rates() {
		$currency_rates = get_transient( Constants::CURRENCY_RATES_TRANSIENT_NAME );

		if ( $currency_rates === false ) {
			$response = Api::get_instance()->get_currency_rates();

			if ( ! $response || is_wp_error( $response ) ) {
				return [];
			}

			$res = Api::get_instance()->process_response( $response );

			$code = $res['code'] ?? 0;

			if ( $code === Constants::OK_CODE ) {
				$currency_rates = $res['data'] ?? [];

				if ( is_array( $currency_rates ) ) {
					set_transient( Constants::CURRENCY_RATES_TRANSIENT_NAME, $currency_rates, Constants::UPDATE_CURRENCY_RATES_INTERVAL_DAYS * 24 * 3600 );
					return $currency_rates;
				}
			}
		}

		return is_array( $currency_rates ) ? $currency_rates : [];
	}
}
