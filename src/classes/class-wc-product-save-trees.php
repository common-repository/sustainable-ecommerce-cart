<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use WC_Product;

/**
 * Advanced Product Type
 */
class WC_Product_Save_Trees extends WC_Product {

	/**
	 * @inheritDoc
	 */
	public function get_type() {
		return Constants::SAVE_TRESS_PRODUCT_TYPE;
	}

	/**
	 * @inheritDoc
	 */
	public function get_name( $context = 'view' ) {
		return esc_html__( 'Sustainability - Certified Carbon Offset', 'rgbc_netzero_sm' );
	}
}
