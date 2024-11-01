<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

use WP_REST_Request;

class Rest_Helper extends Singleton {

	/**
	 * @param string $param
	 * @param WP_REST_Request $request
	 * @param string $key
	 * @return string
	 */
	public function sanitize_text_field( $param, $request, $key ) {
		return sanitize_text_field( $param );
	}

	/**
	 * @param string $param
	 * @param WP_REST_Request $request
	 * @param string $key
	 * @return bool
	 */
	public function validate_sanitized_text_field( $param, $request, $key ) {
		$args = $request->get_attributes();
		$args = $args['args'][ $key ] ?? false;

		if ( ! is_array( $args ) || ! $args ) {
			return true;
		}

		$param = sanitize_text_field( $param );

		$min_length = $args['min_length'] ?? false;
		$max_length = $args['max_length'] ?? false;

		if ( $min_length !== false ) {
			$min_length = (int) $min_length;
			if ( mb_strlen( $param ) < $min_length ) {
				return false;
			}
		}

		if ( $max_length !== false ) {
			$max_length = (int) $max_length;
			if ( mb_strlen( $param ) > $max_length ) {
				return false;
			}
		}

		return true;
	}
}
