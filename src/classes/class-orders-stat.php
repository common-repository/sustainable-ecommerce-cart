<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

use stdClass;

class Orders_Stat extends Singleton {

	/**
	 * @param integer $from
	 * @param integer $to
	 *
	 * @return array
	 */
	public function get_stats( $from = 0, $to = 0 ) {
		$from = (int) $from;
		$to   = (int) $to;

		$transient_key = md5( Constants::ORDERS_STAT_TRANSIENT_NAME . $from . $to );

		$orders_stat = get_transient( $transient_key );

		if ( $orders_stat === false || Helper::get_instance()->is_dev_mode() ) {
			$orders_stat = $this->calc_stats( $from, $to );
			set_transient( $transient_key, $orders_stat, Constants::UPDATE_ORDERS_STAT_INTERVAL_MIN * 60 );
		}

		return is_array( $orders_stat ) ? $orders_stat : [];
	}

	/**
	 * @return array
	 */
	public function get_month_stat() {
		$plugin_activation_time = Helper::get_instance()->get_plugin_activation_time();

		$from = strtotime( '-1 month' );

		if ( $from < $plugin_activation_time ) {
			$from = $plugin_activation_time;
		}

		return $this->get_stats( $from );
	}

	/**
	 * @return array
	 */
	public function get_this_month_stat() {
		$from = strtotime( 'first day of this month' );

		$plugin_activation_time = Helper::get_instance()->get_plugin_activation_time();

		if ( $from < $plugin_activation_time ) {
			$from = $plugin_activation_time;
		}

		return $this->get_stats( $from );
	}

	/**
	 * @return array
	 */
	public function get_last_month_stat() {
		$from = strtotime( 'first day of last month' );
		$to   = strtotime( 'last day of last month' );

		$plugin_activation_time = Helper::get_instance()->get_plugin_activation_time();

		//plugin activated at this month, do not calculate
		if ( $plugin_activation_time > $to ) {
			return [];
		}

		if ( $from < $plugin_activation_time ) {
			$from = $plugin_activation_time;
		}

		$stats = $this->get_stats( $from, $to );

		return $stats;
	}

	/**
	 * @return array
	 */
	public function get_this_year_stat() {
		$from = strtotime( 'first day of january this year' );

		$plugin_activation_time = Helper::get_instance()->get_plugin_activation_time();

		if ( $from < $plugin_activation_time ) {
			$from = $plugin_activation_time;
		}

		return $this->get_stats( $from );
	}

	/**
	 * @return array
	 */
	public function get_stats_since_install_plugin() {
		$plugin_activation_time = Helper::get_instance()->get_plugin_activation_time();

		return $this->get_stats( $plugin_activation_time );
	}

	/**
	 * @param integer $from
	 * @param integer $to
	 *
	 * @return array|object|stdClass[]|null
	 */
	private function donation_stats( $from = 0, $to = 0 ) {
		global $wpdb;

		$where = [];

		$from = (int) $from;
		$to   = (int) $to;

		if ( $from ) {
			$where[] = [
				'query'  => 'posts.post_date >= %s',
				'values' => [ gmdate( 'Y-m-d H:i:s', $from ) ],
			];
		}

		if ( $to ) {
			$where[] = [
				'query'  => 'posts.post_date <= %s',
				'values' => [ gmdate( 'Y-m-d H:i:s', $to ) ],
			];
		}

		$where_query = implode( ' AND ', array_column( $where, 'query' ) );

		if ( $where_query ) {
			$where_query = "AND ( $where_query )";
		}

		$where_values = call_user_func_array(
			'array_merge',
			array_column( $where, 'values' )
		);

		//product type for sub query
		array_unshift( $where_values, Constants::SAVE_TRESS_PRODUCT_TYPE );

		$deleted_products = get_option( Constants::DELETED_NETZERO_PRODUCTS_OPTION_NAME, [] );

		// phpcs:disable
		$or_deleted_products = '';

		if ( is_array( $deleted_products ) && $deleted_products ) {
			$placeholders = [];

			foreach ( $deleted_products as $deleted_product ) {
				$placeholders[] = '%d';
			}
			$placeholders        = implode( ',', $placeholders );
			$or_deleted_products = $wpdb->prepare(
				"OR wc_meta.meta_value IN ($placeholders)",
				$deleted_products
			);
		}

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT SUM(wc_meta2.meta_value) as donations_sum, COUNT(DISTINCT posts.ID) as total_orders, pm.meta_value as currency
				FROM {$wpdb->prefix}posts as posts
				         INNER JOIN {$wpdb->prefix}woocommerce_order_items as wc_items ON posts.ID = wc_items.order_id
				         INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta as wc_meta ON wc_meta.order_item_id = wc_items.order_item_id
				         INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta as wc_meta2 ON wc_meta2.order_item_id = wc_items.order_item_id
						 INNER JOIN {$wpdb->prefix}postmeta as pm ON pm.post_id = posts.ID
				WHERE posts.post_type = 'shop_order'
				  AND posts.post_status = 'wc-completed'
				  AND wc_meta.meta_key = '_product_id'
				  AND wc_meta2.meta_key = '_line_total'
				  AND pm.meta_key = '_order_currency'
				  AND ( wc_meta.meta_value IN (SELECT DISTINCT ID
	                 FROM {$wpdb->prefix}posts
	                          INNER JOIN {$wpdb->prefix}term_relationships wtr on wtr.object_id = wp_posts.ID
	                          INNER JOIN {$wpdb->prefix}term_taxonomy wtt on wtr.term_taxonomy_id = wtt.term_taxonomy_id
	                          INNER JOIN {$wpdb->prefix}terms wt on wtt.term_id = wt.term_id
				     WHERE wt.slug = %s ) $or_deleted_products
				     )
	                 $where_query
	                 GROUP BY currency;",
				$where_values
			),
			ARRAY_A
		);
		// phpcs:disable
	}

	/**
	 * @param integer $from
	 * @param integer $to
	 *
	 * @return integer
	 */
	private function get_total_orders( $from = 0, $to = 0 ) {
		global $wpdb;

		$where = [];

		$from = (int) $from;
		$to   = (int) $to;

		if ( $from ) {
			$where[] = [
				'query'  => 'posts.post_date >= %s',
				'values' => [ gmdate( 'Y-m-d H:i:s', $from ) ],
			];
		}

		if ( $to ) {
			$where[] = [
				'query'  => 'posts.post_date <= %s',
				'values' => [ gmdate( 'Y-m-d H:i:s', $to ) ],
			];
		}

		$where_query = implode( ' AND ', array_column( $where, 'query' ) );

		if ( $where_query ) {
			$where_query = "AND $where_query";
		}

		$where_values = call_user_func_array( 'array_merge', array_column( $where, 'values' ) );

		// phpcs:disable
		return (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT( DISTINCT posts.ID ) as count
				FROM {$wpdb->prefix}posts as posts
					WHERE posts.post_type = 'shop_order'
 					AND posts.post_status = 'wc-completed'
	                 $where_query",
				$where_values
			)
		);
		// phpcs:enable
	}

	/**
	 * @param integer $from
	 * @param integer $to
	 *
	 * @return array
	 */
	public function calc_stats( $from = 0, $to = 0 ) {
		$from = (int) $from;
		$to   = (int) $to;

		$donation_stats = $this->donation_stats( $from, $to );
		$all_orders     = $this->get_total_orders( $from, $to );

		$friendly_orders       = 0;
		$donations_sum         = 0;
		$carbon_reduced_in_kg  = 0;
		$carbon_neutral_orders = 0;

		if ( is_array( $donation_stats ) ) {
			foreach ( $donation_stats as $donation_stats_by_currency ) {
				if ( ! is_array( $donation_stats_by_currency ) ) {
					continue;
				}

				$currency                  = strtoupper( trim( $donation_stats_by_currency['currency'] ?? '' ) );
				$friendly_orders          += (int) ( $donation_stats_by_currency['total_orders'] ?? 0 );
				$donations_sum_by_currency = (float) ( $donation_stats_by_currency['donations_sum'] ?? 0 );

				if ( $currency !== Constants::BASE_CURRENCY && $currency ) {
					$currency_rates = Currency_Rates::get_instance()->get_currency_rates();
					$currency_rate  = $currency_rates[ $currency ] ?? null;
					if ( is_numeric( $currency_rate ) && $currency_rate > 0 ) {
						$donations_sum += $donations_sum_by_currency / $currency_rate;
					}
				} else {
					$donations_sum += $donations_sum_by_currency;
				}
			}

			$donations_sum = round( $donations_sum, 2, PHP_ROUND_HALF_EVEN );

			$carbon_reduced_in_kg = round( $donations_sum / 100 * 1000, 0, PHP_ROUND_HALF_EVEN );

			if ( $all_orders > 0 ) {
				$carbon_neutral_orders = round( $friendly_orders * 100 / $all_orders, 1, PHP_ROUND_HALF_EVEN );
			}
		}

		$carbon_reduced_imperial = round( $carbon_reduced_in_kg * 2.20462262, 0, PHP_ROUND_HALF_EVEN );

		$trees_absorbing         = round( $carbon_reduced_in_kg / 21, 0, PHP_ROUND_HALF_EVEN );
		$liters_of_fuel          = round( $carbon_reduced_in_kg / 2.3, 0, PHP_ROUND_HALF_EVEN );
		$liters_of_fuel_imperial = round( $liters_of_fuel * 0.264172052, 0, PHP_ROUND_HALF_EVEN );
		$hours_of_flight         = round( $carbon_reduced_in_kg / 250, 0, PHP_ROUND_HALF_EVEN );

		return [
			'friendly_orders'         => $friendly_orders,
			'donations_sum'           => $donations_sum,
			'carbon_reduced'          => $carbon_reduced_in_kg,
			'carbon_reduced_imperial' => $carbon_reduced_imperial,
			'carbon_neutral_orders'   => $carbon_neutral_orders,

			'trees_absorbing'         => $trees_absorbing,
			'liters_of_fuel'          => $liters_of_fuel,
			'liters_of_fuel_imperial' => $liters_of_fuel_imperial,
			'hours_of_flight'         => $hours_of_flight,
		];
	}
}
