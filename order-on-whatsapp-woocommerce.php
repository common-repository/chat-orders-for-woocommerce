<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://shehab24.github.io/portfolio/
 * @since             1.0.0
 * @package           Chat_Orders_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Chat Orders for Woocommerce
 * Plugin URI:        https://wordpress.org/plugins/chat-orders-for-woocommerce/
 * Description:       Using this plugin you can get orders via WhatsApp. Users can directly order your product via whatsapp 
 * Version:           1.0.1
 * Author:            Shehab Mahamud
 * Author URI:        https://shehab24.github.io/portfolio//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chat-orders-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC'))
{
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CHAT_ORDERS_FOR_WOOCOMMERCE_VERSION', '1.0.1');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-order-on-whatsapp-woocommerce-activator.php
 */
function cofwc_activate_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-order-on-whatsapp-woocommerce-activator.php';
	Chat_Orders_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-order-on-whatsapp-woocommerce-deactivator.php
 */
function cofwc_deactivate_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-order-on-whatsapp-woocommerce-deactivator.php';
	Chat_Orders_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'cofwc_activate_woocommerce');
register_deactivation_hook(__FILE__, 'cofwc_deactivate_woocommerce');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-order-on-whatsapp-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

add_action('admin_init', 'cofwc_check_woocommerce_active');

if (!function_exists('cofwc_check_woocommerce_active'))
{
	function cofwc_check_woocommerce_active()
	{
		return class_exists('WooCommerce');
	}
}



add_action('plugins_loaded', 'cofwc_check_woocommerce_status');

function cofwc_check_woocommerce_status()
{
	if (cofwc_check_woocommerce_active() == true)
	{
		cofwc_run_woocommerce();

	} else
	{
		echo '<div class="error"><p>Chat orders on Whatsapp  requires WooCommerce to be installed and active. Please activate WooCommerce.</p></div>';
	}
}


function cofwc_run_woocommerce()
{

	$plugin = new Chat_Orders_For_Woocommerce();
	$plugin->run();

}

