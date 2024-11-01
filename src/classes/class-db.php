<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

class DB extends Singleton {

	/**
	 * @return void
	 */
	public function init() {
		$this->create_table_failed_orders();
	}

	/**
	 * @return void
	 */
	private function create_table_failed_orders() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $wpdb->prefix . Constants::FAILED_ORDERS_TABLE;

		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) ) ) === $table_name ) {
			return;
		}

		$query = "create table $table_name (
					order_id      		bigint unsigned not null PRIMARY KEY,
					donation_sum 		double unsigned not null,
					currency        	char(3) not null,
					total_order_amount	double unsigned not null,
					is_friendly_order 	boolean default true,
					site_url			text    not null
					) $charset_collate ENGINE=InnoDB;";

		//phpcs:ignore
		$wpdb->query( $query );
	}
}

