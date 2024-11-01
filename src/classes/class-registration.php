<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Registration extends Singleton {

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function sanitize_registration_fields( $data ) {
		$data = ! is_array( $data ) ? [] : $data;

		$reg_data['first_name'] = sanitize_text_field( $data['first_name'] ?? '' );
		$reg_data['last_name']  = sanitize_text_field( $data['last_name'] ?? '' );
		$reg_data['email']      = sanitize_email( $data['email'] ?? '' );
		$reg_data['terms']      = isset( $data['terms'] );

		return $reg_data;
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function validate_registration_fields( $data ) {
		$data = is_array( $data ) ? $data : [];

		$errors = [];

		$first_name = sanitize_text_field( $data['first_name'] ?? '' );
		$last_name  = sanitize_text_field( $data['last_name'] ?? '' );
		$email      = sanitize_email( $data['email'] ?? '' );
		$terms      = $data['terms'] ?? false;

		if ( ! $first_name ) {
			$errors['first_name'] = Helper::get_instance()->get_message( Constants::MSG_FIRST_NAME_ERROR );
		}
		if ( ! $last_name ) {
			$errors['last_name'] = Helper::get_instance()->get_message( Constants::MSG_LAST_NAME_ERROR );
		}
		if ( ! $email || ! is_email( $email ) ) {
			$errors['email'] = Helper::get_instance()->get_message( Constants::MSG_EMAIL_ERROR );
		}
		if ( ! $terms ) {
			$errors['terms'] = Helper::get_instance()->get_message( Constants::MSG_ACCEPT_TERMS_REQUIRED );
		}

		return $errors;
	}
}
