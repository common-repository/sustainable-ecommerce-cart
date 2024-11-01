<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use Automattic\WooCommerce\Admin\Overrides\Order;
use WC_Order;
use WC_Order_Item_Product;

class Orders_Listener extends Singleton {

	/**
	 * @return void
	 */
	public function init() {
		$helper = Helper::get_instance();
		if ( $helper->widget_is_enabled() && $helper->site_is_active() ) {
			add_action( 'woocommerce_order_status_completed', [ $this, 'on_order_status_completed' ], 10, 2 );
			add_action( 'woocommerce_new_order', [ $this, 'new_order' ], 10, 2 );
		}
	}

	/**
	 * @param integer $order_id
	 * @param Order $order
	 *
	 * @return void
	 */
	public function on_order_status_completed( $order_id, $order ) {
		$save_trees_fee = 0;

		if ( ! $order instanceof Order ) {
			return;
		}

		$items = $order->get_items();

		$is_friendly_order = false;

		foreach ( $items as $item ) {

			if ( ! $item instanceof WC_Order_Item_Product ) {
				continue;
			}

			if ( ! $item->get_meta( Constants::IS_WC_PRODUCT_SAVE_TREES_ORDER_ITEM_KEY ) ) {
				continue;
			}

			$is_friendly_order = true;
			$save_trees_fee    = (float) $item->get_total();
			break;
		}

		$response = Api::get_instance()->create_order( $order, $save_trees_fee, $is_friendly_order );

		$order_data = [
			'order_id'           => $order->get_id(),
			'donation_sum'       => $save_trees_fee,
			'currency'           => $order->get_currency(),
			'total_order_amount' => $order->get_subtotal(),
			'is_friendly_order'  => $is_friendly_order,
			'site_url'           => get_site_url(),
		];

		if ( ! $response || is_wp_error( $response ) ) {
			Failed_Orders::get_instance()->create_order(
				$order_data
			);

			return;
		}

		$res = Api::get_instance()->process_response( $response );

		$code = $res['code'] ?? 0;

		if ( $code !== Constants::OK_CODE ) {
			Failed_Orders::get_instance()->create_order(
				$order_data
			);
		}
	}

	/**
	 * @param integer $order_id
	 * @param WC_Order $order
	 *
	 * @return void
	 */
	public function new_order( $order_id, $order ) {
		if ( ! $order instanceof WC_Order ) {
			return;
		}

		$items = $order->get_items();

		foreach ( $items as $item ) {

			if ( ! $item instanceof WC_Order_Item_Product ) {
				continue;
			}

			$product = $item->get_product();

			if ( ! $product instanceof WC_Product_Save_Trees ) {
				continue;
			}

			$item->add_meta_data( Constants::IS_WC_PRODUCT_SAVE_TREES_ORDER_ITEM_KEY, true );

			$order->save();
			break;
		}

		Helper::get_instance()->set_cart_items_on_widget_activated_moment( [] );
	}
}
