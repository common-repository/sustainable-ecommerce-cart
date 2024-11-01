<?php
/**
 * Plugin Name:  Sustainable eCommerce Cart
 * Plugin URI:   https://netzerosm.com
 * Description:  Sustainable shopping experience for eCommerce stores
 * Version:      1.2
 * Author:       netzeroSM
 * Author URI:   https://netzerosm.com
 * Text Domain:  rgbc_netzero_sm
 * Domain Path:  /languages/
 * Requires PHP: 7.0
 */

namespace Rgbcode\Plugins\Netzero_SM;

use Rgbcode\Plugins\Netzero_SM\Classes\Common;
use Rgbcode\Plugins\Netzero_SM\Classes\DB;
use Rgbcode\Plugins\Netzero_SM\Classes\Failed_Orders;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;
use Rgbcode\Plugins\Netzero_SM\Classes\Orders_Listener;
use Rgbcode\Plugins\Netzero_SM\Classes\Plugin_Control;
use Rgbcode\Plugins\Netzero_SM\Classes\Plugin_Details;
use Rgbcode\Plugins\Netzero_SM\Classes\Save_Trees;
use Rgbcode\Plugins\Netzero_SM\Classes\Settings;
use Rgbcode\Plugins\Netzero_SM\Classes\Rest_Routes;
use Rgbcode\Plugins\Netzero_SM\Classes\Wp_Admin;

define( 'RGBC_NETZERO_SM_VER', '1.2' );
define( 'RGBC_NETZERO_SM_DIR', __DIR__ );
define( 'RGBC_NETZERO_SM_URL', plugin_dir_url( __FILE__ ) );

$autoload_file = RGBC_NETZERO_SM_DIR . '/vendor/autoload.php';

if ( file_exists( $autoload_file ) ) {
	require_once $autoload_file;
}

require_once RGBC_NETZERO_SM_DIR . '/plugin-autoload.php';

if ( ! Helper::get_instance()->is_woocommerce_activated() ) {
	add_action( 'admin_notices', [ Common::get_instance(), 'notice_woocommerce_not_activated' ] );
	return;
}

$dev_file = RGBC_NETZERO_SM_DIR . '/dev.php';

if ( file_exists( $dev_file ) ) {
	require_once $dev_file;
}

load_plugin_textdomain( 'rgbc_netzero_sm', false, basename( dirname( __FILE__ ) ) . '/languages' );

register_activation_hook( __FILE__, [ Plugin_Control::get_instance(), 'on_activate' ] );
register_deactivation_hook( __FILE__, [ Plugin_Control::get_instance(), 'on_deactivate' ] );

add_action( 'admin_init', [ Helper::get_instance(), 'update_site_suspended_status' ] );

DB::get_instance()->init();
Settings::get_instance()->init();
Rest_Routes::get_instance()->init();
Save_Trees::get_instance()->init();
Orders_Listener::get_instance()->init();
Wp_Admin::get_instance()->init();
Failed_Orders::get_instance()->init();
Plugin_Details::get_instance()->init();
