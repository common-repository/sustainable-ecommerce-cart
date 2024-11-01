<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use WC_Cart;
use WC_Countries;
use WC_Product;

class Netzero_Calc extends Singleton {

	private $weight_unit     = '';
	private $dimensions_unit = '';

	const ECO_WORDS = [ 'eco' ];

	protected function __construct() {
		parent::__construct();

		$this->set_weight_unit( get_option( 'woocommerce_weight_unit', '' ) );
		$this->set_dimensions_unit( get_option( 'woocommerce_dimension_unit', '' ) );
	}

	/**
	 * @param array $cart
	 *
	 * @return float
	 */
	public function calc_fee( $cart ) {
		$fee = 0;

		Helper::get_instance()->reset_cart_items_on_widget_activation_moment();

		$cart_items_on_widget_activated_moment = Helper::get_instance()->get_cart_items_on_widget_activated_moment();

		if ( ! is_array( $cart ) || ! $cart ) {
			return $fee;
		}

		foreach ( $cart as $k => $cart_item ) {
			$product = $cart_item['data'] ?? false;

			if ( $product instanceof WC_Product_Save_Trees || ! $product instanceof WC_Product ) {
				continue;
			}

			/**
			 * Do not recalculate donate for new products after widget activated
			 */
			if ( Save_Trees::get_instance()->save_tree_product_exists() &&
				$cart_items_on_widget_activated_moment &&
				! array_key_exists(
					$k,
					$cart_items_on_widget_activated_moment
				)
			) {
				continue;
			}

			$cart_item_on_widget_activated_moment = $cart_items_on_widget_activated_moment[ $k ] ?? null;

			/**
			 * We should not recalculate the donation upwards after the widget is activated,
			 * so we replace the quantity with the one that was at the time the widget was activated
			 */
			$quantity = $cart_item['quantity'] ?? 0;

			if ( $cart_item_on_widget_activated_moment ) {
				$now_cart_item_quantity    = $quantity;
				$stored_cart_item_quantity = $cart_item_on_widget_activated_moment['quantity'] ?? 0;

				if ( $now_cart_item_quantity > $stored_cart_item_quantity ) {
					$quantity = $stored_cart_item_quantity;
				}
			}

			$shipping_factor_cart = $cart_items_on_widget_activated_moment ? $cart_items_on_widget_activated_moment : $cart;

			$product_factor  = $this->get_product_factor( $product );
			$weight_factor   = $this->get_weight_factor( $product );
			$volume_factor   = $this->get_volume_factor( $product );
			$material_factor = $this->get_material_factor( $product );
			$shipping_factor = $this->get_shipping_factor( $shipping_factor_cart );

			$wc_cart = WC()->cart;

			if ( ! $wc_cart instanceof WC_Cart ) {
				break;
			}

			$fee += ( (float) wc_get_price_excluding_tax( $product, [ 'qty' => $quantity ] ) * 0.02 * $product_factor * $weight_factor * $volume_factor * $material_factor ) * $shipping_factor;
		}

		$decimals = wc_get_price_decimals();

		if ( $decimals <= 0 && $fee < 1 ) {
			$fee = ceil( $fee );
		} else {
			$fee = round( $fee, $decimals, PHP_ROUND_HALF_EVEN );
		}

		return $fee;
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return float
	 */
	private function get_product_factor( $product ) {
		if ( $this->is_virtual( $product ) ) {
			return 0.5;
		}

		return 1.1;
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return float
	 */
	private function get_weight_factor( $product ) {
		if ( ! $product instanceof WC_Product || $this->is_virtual( $product ) ) {
			return 1;
		}

		$weight_unit = $this->get_weight_unit();
		$weight      = $this->weight_unit_to_kg( $product->get_weight(), $weight_unit );

		if ( $weight <= 0 ) {
			return 1;
		}

		if ( $weight <= 0.1 ) {
			return 1.1;
		}

		return 1.2;
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return float
	 */
	private function get_volume_factor( $product ) {
		if ( ! $product instanceof WC_Product || $this->is_virtual( $product ) ) {
			return 1;
		}

		$length = $product->get_length();
		$width  = $product->get_width();
		$height = $product->get_height();

		$cubic_meters = (float) $this->dimensions_to_cubic_meters( $length, $width, $height, $this->get_dimensions_unit() );

		if ( $cubic_meters <= 0.1 ) {
			return 1;
		}

		if ( $cubic_meters <= 0.2 ) {
			return 1.1;
		}

		return 1.2;
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return float
	 */
	private function get_material_factor( $product ) {
		if ( ! $product instanceof WC_Product || $this->is_virtual( $product ) ) {
			return 1;
		}

		if ( $this->has_eco_words( $product ) ) {
			return 1;
		}

		return 1.05;
	}

	/**
	 * @param array $cart
	 *
	 * @return int
	 */
	private function get_shipping_factor( $cart ) {
		if ( ! is_array( $cart ) ) {
			return 1;
		}

		foreach ( $cart as $cart_item ) {
			$product = null;

			if ( is_array( $cart_item ) ) {
				$product = wc_get_product( $cart_item['product_id'] ?? 0 );
			}

			if ( $product instanceof WC_Product_Save_Trees || ! $product instanceof WC_Product ) {
				continue;
			}

			if ( ! $this->is_virtual( $product ) ) {
				$allowed_countries = get_option( 'woocommerce_allowed_countries' );

				$specific_allowed_countries = get_option( 'woocommerce_specific_allowed_countries', [] );
				$specific_allowed_countries = is_array( $specific_allowed_countries ) ? $specific_allowed_countries : [];

				$all_except_countries = get_option( 'woocommerce_all_except_countries' );
				$all_except_countries = is_array( $all_except_countries ) ? $all_except_countries : [];

				$countries_obj = new WC_Countries();
				$countries     = $countries_obj->__get( 'countries' );
				$countries     = is_array( $countries ) ? $countries : [];

				$deliverable_countries_cnt_after_excluded = count( $countries ) - count( $all_except_countries );

				if ( $allowed_countries === 'all' ) {
					return 1.2;
				}

				if ( $allowed_countries === 'specific' ) {
					if ( count( $specific_allowed_countries ) > 1 ) {
						return 1.2;
					}

					return 1.1;
				}

				if ( $allowed_countries === 'all_except' ) {
					if ( $deliverable_countries_cnt_after_excluded > 1 ) {
						return 1.2;
					}

					return 1.1;
				}
			}
		}

		return 1;
	}

	/**
	 * @param float $weight
	 * @param string $unit
	 *
	 * @return float
	 */
	private function weight_unit_to_kg( $weight, $unit ) {
		$unit   = (string) $unit;
		$weight = (float) $weight;

		switch ( $unit ) {
			case 'g':
				return $weight / 1000;
			case 'lbs':
				return $weight / 2.205;
			case 'oz':
				return $weight / 35.274;
			default:
				return $weight;
		}
	}

	/**
	 * @param float $dimension
	 * @param string $unit
	 *
	 * @return float
	 */
	private function dimensions_unit_to_cm( $dimension, $unit ) {
		$unit      = (string) $unit;
		$dimension = (float) $dimension;

		switch ( $unit ) {
			case 'm':
				return $dimension * 100;
			case 'mm':
				return $dimension / 10;
			case 'in':
				return $dimension * 2.54;
			case 'yd':
				return $dimension * 91.44;
			default:
				return $dimension;
		}
	}

	/**
	 * @param float $length
	 * @param float $width
	 * @param float $height
	 * @param string $unit
	 *
	 * @return float|int
	 */
	private function dimensions_to_cubic_meters( $length, $width, $height, $unit ) {
		$unit = (string) $unit;

		$length = $this->dimensions_unit_to_cm( (float) $length, $unit );
		$width  = $this->dimensions_unit_to_cm( (float) $width, $unit );
		$height = $this->dimensions_unit_to_cm( (float) $height, $unit );

		return $length * $width * $height / 1000000;
	}

	/**
	 * @param string $weight_unit
	 *
	 * @return void
	 */
	private function set_weight_unit( $weight_unit ) {
		$this->weight_unit = $weight_unit;
	}

	/**
	 * @return string
	 */
	private function get_weight_unit() {
		return $this->weight_unit;
	}

	/**
	 * @param string $dimensions_unit
	 *
	 * @return void
	 */
	private function set_dimensions_unit( $dimensions_unit ) {
		$this->dimensions_unit = $dimensions_unit;
	}

	/**
	 * @return string
	 */
	private function get_dimensions_unit() {
		return $this->dimensions_unit;
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return bool
	 */
	private function is_virtual( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return false;
		}

		return $product->is_virtual() || $product->is_downloadable();
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return false
	 */
	private function has_eco_words( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return false;
		}

		$product_id = $product->get_id();

		global $wpdb;

		$eco_words = self::ECO_WORDS;

		if ( ! is_array( $eco_words ) || ! $eco_words ) {
			return false;
		}

		$where_post_id_query = $wpdb->prepare( 'WHERE posts.ID = %d', $product_id );

		foreach ( $eco_words as $word ) {
			$where_eco_words[] = [
				'query'  => 'posts.post_title LIKE %s',
				'values' => [ "%$word%" ],
			];

			$where_eco_words[] = [
				'query'  => 'meta.meta_value LIKE %s',
				'values' => [ "%$word%" ],
			];
		}

		$where_eco_words_query = implode( ' OR ', array_column( $where_eco_words, 'query' ) );

		if ( $where_eco_words_query ) {
			$where_eco_words_query = " AND ( $where_eco_words_query )";
		}

		$where_eco_values = call_user_func_array(
			'array_merge',
			array_column( $where_eco_words, 'values' )
		);

		//phpcs:disable
		return (bool) $wpdb->get_row(
			$wpdb->prepare(
				"SELECT DISTINCT ID FROM {$wpdb->prefix}posts posts
    				LEFT JOIN {$wpdb->prefix}postmeta meta ON posts.ID = meta.post_id $where_post_id_query
    				$where_eco_words_query",
				$where_eco_values
			)
		);
		//phpcs:enable
	}
}
