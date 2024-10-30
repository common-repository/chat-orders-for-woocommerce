<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://shehab24.github.io/portfolio/
 * @since      1.0.0
 *
 * @package    Chat_Orders_For_Woocommerce
 * @subpackage Chat_Orders_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Chat_Orders_For_Woocommerce
 * @subpackage Chat_Orders_For_Woocommerce/includes
 * @author     Shehab Mahamud <mdshehab204@gmail.com>
 */
class Chat_Orders_For_Woocommerce_i18n
{


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'order-on-whatsapp-woocommerce',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);

	}



}
