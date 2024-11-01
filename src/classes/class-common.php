<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Common extends Singleton {

	/**
	 * @return void
	 */
	public function notice_woocommerce_not_activated() {
		$class   = 'notice notice-error';
		$message = esc_html__( 'Woocommerce is required for Netzero SM plugin to work correctly.', 'rgbc_netzero_sm' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

}
