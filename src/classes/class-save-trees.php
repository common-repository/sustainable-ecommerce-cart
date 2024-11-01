<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

use Exception;
use Throwable;
use WC_Cart;
use WP_Error;
use WP_Post;
use WP_Query;

class Save_Trees extends Singleton {
	/**
	 * @return void
	 */
	public function init() {
		add_action( 'init', [ $this, 'auto_create_save_trees_product' ] );
		add_action( 'pre_get_posts', [ $this, 'hide_save_trees_product' ] );

		$helper = Helper::get_instance();

		if ( $helper->widget_is_enabled() && $helper->site_is_active() ) {
			add_action( 'woocommerce_loaded', [ $this, 'init_save_trees' ] );
		}
	}

	/**
	 * @param $query
	 *
	 * @return void
	 */
	public function hide_save_trees_product( $query ) {
		if ( ! $query instanceof WP_Query ) {
			return;
		}

		$product = $this->get_save_trees_product();

		if ( $product ) {
			$query->set( 'post__not_in', [ $product->ID ] );
		}
	}

	/**
	 * @return void
	 */
	public function auto_create_save_trees_product() {
		if ( ! $this->save_trees_product_exists() ) {
			$this->create_save_trees_product();
		}
	}

	/**
	 * @return void
	 */
	public function init_save_trees() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		add_action( 'wp_ajax_netzero_sm_save_trees', [ $this, 'ajax_handle_save_trees' ] );
		add_action( 'wp_ajax_nopriv_netzero_sm_save_trees', [ $this, 'ajax_handle_save_trees' ] );

		$mini_cart_action = 'woocommerce_widget_shopping_cart_before_buttons';
		$cart_action      = 'woocommerce_proceed_to_checkout';

		if ( Helper::get_instance()->get_widget_place() === Constants::WIDGET_PLACE_B ) {
			$mini_cart_action = 'woocommerce_mini_cart_contents';
			if ( ! wp_is_mobile() ) {
				$cart_action = 'woocommerce_after_cart_table';
			}
		}

		add_action( $mini_cart_action, [ $this, 'render_save_trees_mini_cart' ] );
		add_action( 'woocommerce_review_order_before_payment', [ $this, 'render_save_trees_checkout' ] );
		add_action( $cart_action, [ $this, 'render_save_trees_cart' ] );

		add_filter( 'woocommerce_product_class', [ $this, 'woocommerce_product_class' ], 10, 2 );
		add_action( 'woocommerce_before_calculate_totals', [ $this, 'set_save_trees_fee' ], 1, 1 );
		add_filter( 'woocommerce_cart_item_price', [ $this, 'cart_item_price' ], 10, 3 );

		add_filter( 'the_title', [ $this, 'change_product_title' ], 10, 2 );
		add_filter( 'woocommerce_cart_item_permalink', [ $this, 'cart_item_permalink' ], 10, 3 );
		add_action( 'wp_head', [ $this, 'widget_popup' ] );
	}

	/**
	 * @param string $permalink
	 * @param array $cart_item
	 * @param string $cart_item_key
	 *
	 * @return string
	 */
	public function cart_item_permalink( $permalink, $cart_item, $cart_item_key ) {
		if ( is_array( $cart_item ) && isset( $cart_item['data'] ) ) {
			if ( $cart_item['data'] instanceof WC_Product_Save_Trees ) {
				$permalink = '';
			}
		}

		return $permalink;
	}

	/**
	 * @param string $title
	 * @param  integer $id
	 *
	 * @return string
	 */
	public function change_product_title( $title, $id ) {
		$product = wc_get_product( $id );

		if ( $product instanceof WC_Product_Save_Trees ) {
			$title = esc_html__( 'Sustainability - Certified Carbon Offset', 'rgbc_netzero_sm' );
		}

		return $title;
	}

	/**
	 * @param string $price
	 * @param array $cart_item
	 * @param string $cart_item_key
	 *
	 * @return string
	 */
	public function cart_item_price( $price, $cart_item, $cart_item_key ) {
		if ( ! is_array( $cart_item ) || ! isset( $cart_item['data'] ) || ! $cart_item['data'] instanceof WC_Product_Save_Trees ) {
			return $price;
		}

		return wc_price( $this->get_save_trees_fee() );
	}

	/**
	 * @param string $classname
	 * @param string $product_type
	 *
	 * @return string
	 */
	public function woocommerce_product_class( $classname, $product_type ) {
		if ( $product_type === Constants::SAVE_TRESS_PRODUCT_TYPE ) {
			$classname = '\Rgbcode\Plugins\Netzero_SM\Classes\WC_Product_Save_Trees';
		}

		return $classname;
	}

	/**
	 * @return void
	 */
	public function render_save_trees_cart() {
		$widget_enabled_on_cart = get_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_CART );

		if ( ! $widget_enabled_on_cart ) {
			return;
		}

		$is_enabled = $this->save_tree_product_exists();
		$fee        = $this->get_save_trees_fee();

		$classes[] = 'rgbc-content-wrapper_cart';

		$classes = array_merge( $classes, $this->get_widget_classes() );

		load_template(
			RGBC_NETZERO_SM_DIR . '/src/templates/front/save-trees.php',
			false,
			[
				'is_enabled' => $is_enabled,
				'fee'        => $fee,
				'classes'    => $classes,
			]
		);
	}

	/**
	 * @return void
	 */
	public function render_save_trees_mini_cart() {
		$widget_enabled_on_mini_cart = get_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_MINI_CART );

		if ( ! $widget_enabled_on_mini_cart ) {
			return;
		}

		$is_enabled = $this->save_tree_product_exists();
		$fee        = $this->get_save_trees_fee();

		load_template(
			RGBC_NETZERO_SM_DIR . '/src/templates/front/save-trees.php',
			false,
			[
				'is_enabled' => $is_enabled,
				'fee'        => $fee,
			]
		);
	}

	/**
	 * @return void
	 */
	public function render_save_trees_checkout() {

		if ( is_ajax() ) {
			return;
		}

		$widget_enabled_on_checkout = get_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_CHECKOUT );

		if ( ! $widget_enabled_on_checkout ) {
			return;
		}

		$is_enabled = $this->save_tree_product_exists();

		$fee = $this->get_save_trees_fee();

		$classes[] = 'rgbc-content-wrapper_checkout';

		$classes = array_merge( $classes, $this->get_widget_classes() );

		load_template(
			RGBC_NETZERO_SM_DIR . '/src/templates/front/save-trees.php',
			false,
			[
				'is_enabled'  => $is_enabled,
				'fee'         => $fee,
				'is_checkout' => true,
				'classes'     => $classes,
			]
		);
	}

	/**
	 * @return void
	 */
	public function enqueue_scripts() {
		$css_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/front/front.min.*.css' );
		$css_file_path = $css_file_path ? $css_file_path[0] : false;

		if ( $css_file_path ) {
			$css_file_url = RGBC_NETZERO_SM_URL . '/build/front/' . basename( $css_file_path );
			wp_enqueue_style( 'rgbc_netzero_sm_front_css', $css_file_url, [], RGBC_NETZERO_SM_VER );
		}

		$js_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/widget/widget.min.*.js' );
		$js_file_path = $js_file_path ? $js_file_path[0] : false;

		if ( $js_file_path ) {
			$js_file_uri = RGBC_NETZERO_SM_URL . '/build/widget/' . basename( $js_file_path );
			wp_enqueue_script( 'rgbc_netzero_sm_widget_js', $js_file_uri, null, RGBC_NETZERO_SM_VER, true );

			wp_localize_script(
				'rgbc_netzero_sm_widget_js',
				'rgbc_netzero_sm_widget',
				[
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( Constants::FRONT_NONCE_ACTION_DEFAULT ),
				]
			);
		}
	}

	/**
	 * @return void
	 */
	public function ajax_handle_save_trees() {
		$nonce = sanitize_text_field( $_POST['nonce'] ?? '' );

		if ( ! wp_verify_nonce( $nonce, Constants::FRONT_NONCE_ACTION_DEFAULT ) ) {
			wp_send_json_error( null, Constants::UNAUTHORIZED_CODE );
		}

		$cart = WC()->cart;

		if ( ! $cart instanceof WC_Cart ) {
			wp_send_json_error( null, Constants::SERVER_ERROR_CODE );
		}

		$save_trees = sanitize_text_field( $_POST['save_trees'] ?? '' );

		if ( $save_trees === 'true' ) {
			$save_trees_product = $this->get_save_trees_product();
			if ( ! $save_trees_product ) {
				wp_send_json_error( null, Constants::SERVER_ERROR_CODE );
			}

			try {
				if ( $this->save_tree_product_exists() ) {
					wp_send_json_success();
				}

				$product_key = $cart->add_to_cart( $save_trees_product->ID );

				if ( $product_key === false ) {
					throw new Exception( esc_html__( 'Add to cart error', 'rgbc_netzero_sm' ) );
				}

				$cart_items = $cart->get_cart();

				if ( ! array_key_exists( $product_key, $cart_items ) ) {
					throw new Exception( esc_html__( 'No product in cart', 'rgbc_netzero_sm' ) );
				}

				$cart_items_on_widget_activated_moment = [];

				foreach ( $cart_items as $k => $v ) {
					$cart_items_on_widget_activated_moment[ $k ] = $v;
				}

				if ( $cart_items_on_widget_activated_moment ) {
					Helper::get_instance()->set_cart_items_on_widget_activated_moment( $cart_items_on_widget_activated_moment );
				}
			} catch ( Throwable $e ) {
				wp_send_json_error( null, Constants::SERVER_ERROR_CODE );
			}

			wp_send_json_success();
		}

		foreach ( $cart->get_cart() as $k => $v ) {
			if ( $v['data'] instanceof WC_Product_Save_Trees ) {
				$cart->remove_cart_item( $k );
				break;
			}
		}

		wp_send_json_success();
	}

	/**
	 * @param WC_Cart $cart
	 *
	 * @return void
	 */
	public function set_save_trees_fee( $cart ) {
		if ( ! $cart instanceof WC_Cart ) {
			return;
		}

		foreach ( $cart->cart_contents as $cart_item_key => $value ) {
			$product = $value['data'];

			if ( ! $product instanceof WC_Product_Save_Trees ) {
				continue;
			}

			$save_trees_fee = $this->get_save_trees_fee();

			if ( $save_trees_fee > 0 ) {
				$product->set_price( $save_trees_fee );
				break;
			}

			$cart->remove_cart_item( $cart_item_key );
			Helper::get_instance()->set_cart_items_on_widget_activated_moment( [] );
			break;
		}
	}

	/**
	 * @return bool
	 */
	private function create_save_trees_product() {
		try {
			$product = new WC_Product_Save_Trees();
			$product->set_virtual( true );
			$product->set_name( Constants::SAVE_TREES_PRODUCT_NAME );
			$product->set_slug( Constants::SAVE_TREES_PRODUCT_SLUG );
			$product->set_tax_status( 'none' );
			$product->set_regular_price( 1 );
			$product->set_sold_individually( false );
			$product->set_catalog_visibility( 'hidden' );
			$product->set_post_password( wp_generate_password( 32, true, true ) );

			$product_id = $product->save();
			if ( $product_id ) {
				$attach_id = $this->attach_product_image( $product_id );
				if ( is_numeric( $attach_id ) ) {
					set_post_thumbnail( $product_id, $attach_id );
				}
			}

			return (bool) $product_id;
		} catch ( Throwable $e ) {
			return false;
		}
	}

	/**
	 * @param integer $post_id
	 *
	 * @return false|int|WP_Error
	 */
	public function attach_product_image( $post_id ) {
		$upload_dir = wp_upload_dir();
		$source     = RGBC_NETZERO_SM_DIR . '/src/assets/images/tree.png';
		$filename   = $upload_dir['basedir'] . '/rgbc-netzero-sm-tree.png';

		if ( ! file_exists( $source ) ) {
			return false;
		}

		if ( ! file_exists( $filename ) ) {
			copy( $source, $filename );
		}

		if ( ! file_exists( $filename ) ) {
			return false;
		}

		$filetype   = wp_check_filetype( basename( $filename ), null );
		$attachment = [
			'guid'           => $upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		];

		$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
		if ( is_wp_error( $attach_id ) ) {
			return false;
		}

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once ABSPATH . 'wp-admin/includes/image.php';

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );

		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}

	/**
	 * @return array
	 */
	private function get_cart() {
		$cart = WC()->cart;

		if ( ! $cart instanceof WC_Cart ) {
			return [];
		}

		return $cart->get_cart();
	}

	/**
	 * @return bool
	 */
	private function save_trees_product_exists() {
		return (bool) $this->get_save_trees_product();
	}

	/**
	 * @return false|int|WP_Post
	 */
	public function get_save_trees_product() {
		remove_action( 'pre_get_posts', [ $this, 'hide_save_trees_product' ] );

		$products = get_posts(
			[
				'name'        => Constants::SAVE_TREES_PRODUCT_SLUG,
				'post_type'   => 'product',
				'post_status' => 'publish',
				'numberposts' => 1,
			]
		);

		add_action( 'pre_get_posts', [ $this, 'hide_save_trees_product' ] );

		return $products ? $products[0] : false;
	}

	/**
	 * @return bool
	 */
	public function save_tree_product_exists() {
		foreach ( $this->get_cart() as $v ) {
			if ( $v['data'] instanceof WC_Product_Save_Trees ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @return void
	 */
	public function widget_popup() {
		load_template(
			RGBC_NETZERO_SM_DIR . '/src/templates/front/save-trees-popup.php',
			true
		);
	}

	/**
	 * @return float
	 */
	private function get_save_trees_fee() {
		return Netzero_Calc::get_instance()->calc_fee( $this->get_cart() );
	}

	/**
	 * @return array
	 */
	private function get_widget_classes() {
		$classes = [];

		$is_short_version = Helper::get_instance()->get_widget_place() === Constants::WIDGET_PLACE_A;
		$is_long_version  = Helper::get_instance()->get_widget_place() === Constants::WIDGET_PLACE_B;

		if ( $is_short_version ) {
			$classes[] = 'rgbc-widget-container_short-version';
		}

		if ( $is_long_version ) {
			$classes[] = 'rgbc-widget-container_long-version';
		}

		return $classes;
	}
}
