<?php
/**
 * Plugin Name: WooCommerce Sold Individually for Variations
 * Plugin URI: 
 * Description: This plugin allows you to apply the “Sold individually” WooCommerce product setting to the whole variable product (including its variations), thus not allowing the customer to buy more than one unit of the variable product, even if it’s a different variation. You can also set that a specific variation is “Sold individually”.
 * Version: 1.2
 * Author: PT Woo Plugins (by Webdados)
 * Author URI: https://ptwooplugins.com
 * Text Domain: woo-sold-individually-for-variations
 * Requires at least: 5.4
 * Requires PHP: 7.0
 * WC requires at least: 5.0
 * WC tested up to: 8.8
 * Requires Plugins: woocommerce
**/

/* WooCommerce CRUD ready */

namespace Webdados\WooSoldIndividuallyForVariations;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Localization */
add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_textdomain', 0 );
function load_textdomain() {
	load_plugin_textdomain( 'woo-sold-individually-for-variations' );
}

/* Init the main class */
add_action( 'plugins_loaded', __NAMESPACE__ . '\\init', 1 );
function init() {
	if ( class_exists( 'WooCommerce' ) && version_compare( WC_VERSION, '5.0', '>=' ) ) {
		require_once( dirname( __FILE__ ) . '/includes/class-woo-sold-individually-for-variations.php' );
		$GLOBALS['Woo_Sold_Individually_for_Variations'] = Woo_Sold_Individually_for_Variations();
	} else {
		add_action( 'admin_notices', __NAMESPACE__ . '\\admin_notices_woocommerce_not_active' );
	}
}

/* Get the main class instance */
function Woo_Sold_Individually_for_Variations() {
	return \Woo_Sold_Individually_for_Variations::instance(); 
}

function admin_notices_woocommerce_not_active() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( '<strong>WooCommerce Sold Individually for Variations</strong> is installed and active but <strong>WooCommerce (5.0 or above)</strong> is not.', 'woo-sold-individually-for-variations' ); ?></p>
	</div>
	<?php
}

/* HPOS Compatible - beta */
add_action( 'before_woocommerce_init', function() {
	if ( version_compare( WC_VERSION, '7.1', '>=' ) && class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
	}
} );

/* If you're reading this you must know what you're doing ;-) Greetings from sunny Portugal! */
