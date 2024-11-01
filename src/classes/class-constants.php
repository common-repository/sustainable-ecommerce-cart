<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Constants {
	const REST_API_SERVER_URL                  = 'https://carbonsm.com/wp-json/netzero/v1';
	const SITE_URL                             = 'https://www.netzerosm.com';
	const API_REQUEST_TIMEOUT_SECONDS          = 30;
	const ADMIN_NONCE                          = 'rgbc_netzero_sm_admin';
	const SITE_SECRET_KEY_OPTION_NAME          = 'rgbc_netzero_sm_secret_key';
	const PLUGIN_ACTIVATION_TIME_OPTION_NAME   = 'rgbc_netzero_sm_plugin_activation_date';
	const JWT_OPTION_NAME                      = 'rgbc_netzero_sm_jwt';
	const DELETED_NETZERO_PRODUCTS_OPTION_NAME = 'rgbc_netzero_sm_deleted_netzero_products';
	const SECRET_KEYS_LENGTH                   = 32;
	const CURRENCY_RATES_TRANSIENT_NAME        = 'rgbc_netzero_sm_currency_rates';
	const UPDATE_CURRENCY_RATES_INTERVAL_DAYS  = 7;
	const UPDATE_ORDERS_STAT_INTERVAL_MIN      = 15;
	const ORDERS_STAT_TRANSIENT_NAME           = 'rgbc_netzero_sm_orders_stat';
	const SITE_IS_SUSPENDED_TRANSIENT_NAME     = 'rgbc_netzero_sm_site_is_suspended_transient';

	const ACTION_REGISTRATION = 'registration';
	const ACTION_MAIN         = 'main';
	const ACTION_WELCOME      = 'welcome';
	const ACTION_SETTINGS     = 'settings';
	const ACTION_DESIGN       = 'design';
	const ACTION_ACCOUNT      = 'account';
	const ACTION_JOURNEY      = 'journey';
	const ACTION_START        = 'start';

	const MSG_FIRST_NAME_ERROR         = 'msg_first_name_error';
	const MSG_LAST_NAME_ERROR          = 'msg_last_name_error';
	const MSG_EMAIL_ERROR              = 'msg_email_error';
	const MSG_ACCEPT_TERMS_REQUIRED    = 'msg_accept_terms_required';
	const MSG_CONNECTION_SERVER_ERROR  = 'msg_connection_server_error';
	const MSG_ERROR_PLEASE_CONTACT_US  = 'msg_registration_data_validation_error';
	const MSG_INVALID_EMAIL_SECRET_KEY = 'msg_invalid_email_secret_key';
	const MSG_SUCCESSFULLY_UPDATED     = 'msg_successfully_updated';

	const FIELDS_ERRORS  = 'fields_errors';
	const FLASH_MESSAGES = 'flash_messages';
	const FIELDS_VALUES  = 'fields_values';

	const FLASH_MESSAGE_TYPE_ERROR   = 'error';
	const FLASH_MESSAGE_TYPE_SUCCESS = 'success';

	const OK_CODE                         = 200;
	const VALIDATION_ERROR_CODE           = 400;
	const WEBSITE_NOT_VERIFIED_ERROR_CODE = 423;
	const SITE_IS_SUSPENDED_ERROR_CODE    = 424;
	const TOKEN_ERROR_CODE                = 426;
	const CLIENT_ERROR_CODE               = 428;
	const SERVER_ERROR_CODE               = 510;
	const UNAUTHORIZED_CODE               = 401;

	const PLUGIN_CAPABILITY = 'administrator';

	const SETTINGS_SLUG = 'rgbc_netzero_sm';

	const SAVE_TREES_PRODUCT_NAME = 'Sustainability - Certified Carbon Offset';
	const SAVE_TRESS_PRODUCT_TYPE = 'netzero_sm_save_trees';
	const SAVE_TREES_PRODUCT_SLUG = 'rgbc_netzero_sm_save_trees';

	const FRONT_NONCE_ACTION_DEFAULT = 'rgbc_netzero_sm_front_nonce';

	const OPTION_WIDGET_IS_ENABLED              = 'rgbc_netzero_sm_widget_is_enabled';
	const OPTION_SITE_IS_SUSPENDED              = 'rgbc_netzero_sm_site_is_suspended';
	const OPTION_EMAIL_IS_VERIFIED              = 'rgbc_netzero_sm_email_is_verified';
	const OPTION_WIDGET_IS_ENABLED_ON_CART      = 'rgbc_netzero_sm_widget_is_enabled_on_cart';
	const OPTION_WIDGET_IS_ENABLED_ON_MINI_CART = 'rgbc_netzero_sm_widget_is_enabled_on_mini_cart';
	const OPTION_WIDGET_IS_ENABLED_ON_CHECKOUT  = 'rgbc_netzero_sm_widget_is_enabled_on_checkout';

	const OPTION_WIDGET_PLACE = 'rgbc_netzero_sm_widget_place';

	const OPTION_UNITS_IS_METRIC = 'rgbc_netzero_sm_units_is_metric';

	const OPTION_BATCH_INSERT_ORDERS = 'rgbc_netzero_sm_failed_orders';

	const WIDGET_PLACE_A      = 'widget_place_a';
	const WIDGET_PLACE_B      = 'widget_place_b';
	const OPTION_WIDGET_COLOR = 'rgbc_netzero_sm_widget_color';
	const WIDGET_COLOR_WHITE  = '';
	const WIDGET_COLOR_DARK   = 'dark';
	const WIDGET_COLOR_GREEN  = 'green';
	const WIDGET_COLOR_GRAY   = 'gray';

	const BASE_CURRENCY = 'USD';

	const COOKIE_CART_ITEMS_ON_WIDGET_ACTIVATED_MOMENT = 'rgbc_netzero_sm_cart_items_on_widget_activated_moment';

	const FAILED_ORDERS_TABLE = 'rgbc_netzero_sm_failed_orders';

	const SEND_FAILED_ORDERS_TRANSIENT_KEY = 'rgbc_netzero_sm_transient_failed_orders';

	const EMAIL = 'support@netzerosm.com';
	const PHONE = '+972 53 831 1137';

	const IS_WC_PRODUCT_SAVE_TREES_ORDER_ITEM_KEY = 'is_wc_product_save_trees';
}
