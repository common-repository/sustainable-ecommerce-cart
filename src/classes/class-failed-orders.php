<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use mysqli_result;

class Failed_Orders extends Singleton {
	public function init() {
		add_action( 'admin_init', [ $this, 'send_failed_orders' ] );
	}

	/**
	 * @return void
	 */
	public function send_failed_orders() {
		$res = get_transient( Constants::SEND_FAILED_ORDERS_TRANSIENT_KEY );

		if ( $res !== false && ! Helper::get_instance()->is_dev_mode() ) {
			return;
		}

		set_transient( Constants::SEND_FAILED_ORDERS_TRANSIENT_KEY, true, 60 * 5 );

		$total_orders = $this->get_total_orders();
		$per_page     = 250;

		if ( ! $total_orders ) {
			return;
		}

		$orders = $this->get_orders(
			[
				'page'     => 1,
				'per_page' => $per_page,
			]
		);

		if ( ! $orders ) {
			return;
		}

		$res = Api::get_instance()->batch_insert_orders( $orders );

		if ( is_wp_error( $res ) || ! $res ) {
			return;
		}

		$res = Api::get_instance()->process_response( $res );

		if ( $res['errors'] ) {
			return;
		}

		$ids = array_column( $orders, 'order_id' );

		$this->delete_orders(
			[
				'ids' => $ids,
			]
		);
	}

	/**
	 * @param array $order_data
	 *
	 * @return boolean
	 */
	public function create_order( $order_data ) {
		$order_id           = (int) ( $order_data['order_id'] ?? 0 );
		$donation_sum       = (float) ( $order_data['donation_sum'] ?? 0 );
		$currency           = $order_data['currency'] ?? '';
		$total_order_amount = (float) ( $order_data['total_order_amount'] ?? 0 );
		$is_friendly_order  = (bool) ( $order_data['is_friendly_order'] ?? true );
		$site_url           = $order_data['site_url'] ?? '';

		if ( ! $order_id || ! $currency || ! $total_order_amount || ! $site_url ) {
			return false;
		}

		$order_data = [
			'order_id'           => $order_id,
			'donation_sum'       => $donation_sum,
			'currency'           => $currency,
			'total_order_amount' => $total_order_amount,
			'is_friendly_order'  => $is_friendly_order,
			'site_url'           => $site_url,
		];

		global $wpdb;

		$table = "$wpdb->prefix" . Constants::FAILED_ORDERS_TABLE;

		$format = [
			'%d',
			'%f',
			'%s',
			'%f',
			'%d',
			'%s',
		];

		$where_format = [ '%d' ];

		$res = $wpdb->update(
			$table,
			$order_data,
			[
				'order_id' => $order_data['order_id'],
			],
			$format,
			$where_format
		);

		if ( $res === false || $res < 1 ) {
			$res = $wpdb->insert(
				$table,
				$order_data,
				$format
			);
		}

		return (bool) $res;
	}

	/**
	 * @return int
	 */
	public function get_total_orders() {
		global $wpdb;

		$table = "$wpdb->prefix" . Constants::FAILED_ORDERS_TABLE;

		//phpcs:ignore
		return (int) $wpdb->get_var( "SELECT COUNT(order_id) FROM $table" );
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	public function get_orders( $args ) {
		$page     = (int) ( $args['page'] ?? 0 );
		$per_page = (int) ( $args['per_page'] ?? 0 );

		if ( ! $page || ! $per_page ) {
			return [];
		}

		$offset = ( $page - 1 ) * $per_page;

		global $wpdb;

		$table = "$wpdb->prefix" . Constants::FAILED_ORDERS_TABLE;

		// phpcs:disable
		$res = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $table LIMIT %d, %d",
				[ $offset, $per_page ]
			),
			ARRAY_A
		);

		if ( ! is_array( $res ) ) {
			return [];
		}

		return $res;
	}

	/**
	 * @param array $args
	 *
	 * @return bool|int|mysqli_result|resource|null
	 */
	public function delete_orders( $args ) {
		if ( ! is_array( $args ) ) {
			return false;
		}

		$ids = $args['ids'] ?? [];

		if ( ! is_array( $ids ) ) {
			return false;
		}

		$ids_placeholders = array_fill( 0, count( $ids ), '%d' );
		$ids_placeholders = implode( ',', $ids_placeholders );

		global $wpdb;

		$table = "$wpdb->prefix" . Constants::FAILED_ORDERS_TABLE;

		return $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $table WHERE order_id IN($ids_placeholders)",
				$ids
			)
		);
	}

}

