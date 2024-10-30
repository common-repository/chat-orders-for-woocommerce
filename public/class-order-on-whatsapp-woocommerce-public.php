<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://shehab24.github.io/portfolio/
 * @since      1.0.0
 *
 * @package    Chat_Orders_For_Woocommerce
 * @subpackage Chat_Orders_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Chat_Orders_For_Woocommerce
 * @subpackage Chat_Orders_For_Woocommerce/public
 * @author     Shehab Mahamud <mdshehab204@gmail.com>
 */
class Chat_Orders_For_Woocommerce_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chat_Orders_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chat_Orders_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/order-on-whatsapp-woocommerce-public.css', array(), $this->version, 'all');
		$hide_price = get_option('cofwc_hide_price');
		$hide_add_cart_btn = get_option('cofwc_hide_add_cart_btn');
		$inline_css = '';

		if ($hide_add_cart_btn == 1)
		{
			$inline_css .= '.single-product .single_add_to_cart_button { display: none !important; }';
		}
		if ($hide_price == 1)
		{
			$inline_css .= '.single-product .price { display: none !important; }';
		}

		// Check if there are any inline styles to add
		if (!empty ($inline_css))
		{
			wp_add_inline_style($this->plugin_name, $inline_css);
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chat_Orders_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chat_Orders_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/order-on-whatsapp-woocommerce-public.js', array('jquery'), $this->version, false);

	}

	public function cofwc_show_whatsapp_btn_single_product_page()
	{
		global $product;
		$whatsapp_number = get_option('cofwc_whatsapp_number');
		$button_text = get_option('cofwc_button_text');
		$show_in_product_page = get_option('cofwc_show_in_product_page');
		$new_tab = get_option('cofwc_new_tab');


		$product_url = get_permalink($product->get_id());
		$product_title = $product->get_title();
		$product_price = $product->get_price();

		if ($whatsapp_number == true):
			if ($show_in_product_page == 1):

				?>
				<a target="<?php echo esc_attr(($new_tab) ? "_blank" : "_self"); ?>"
					href="https://api.whatsapp.com/send/?phone=<?php echo esc_attr($whatsapp_number); ?>&text=I want to Buy%0aProduct Title :<?php echo esc_attr($product_title); ?>%0aProduct url :<?php echo esc_url($product_url); ?>%0aProduct Price :<?php echo esc_attr($product_price); ?>%0aProduct Quantity: 1 %0a&type=phone_number&app_absent=1"
					class="wh_ancor_tag"><button class="whatsapp_button"> <img
							src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/whatsapp.png'); ?>" alt="">
						<?php echo esc_html(($button_text != "") ? $button_text : "Order on Whatsapp"); ?>
					</button>

				</a>
				<?php
			endif;
		endif;
	}

	public function cofwc_remove_add_to_cart_button()
	{
		$hide_price = get_option('cofwc_hide_price');
		$hide_add_cart_btn = get_option('cofwc_hide_add_cart_btn');
		if ($hide_add_cart_btn == 1)
		{
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
			wp_add_inline_style('cofwc-inline-one', '.single-product .single_add_to_cart_button { display: none !important; }');


		}
		if ($hide_price == 1):
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
			wp_add_inline_style('cofwc-inline-two', '.single-product .price { display: none !important; }');

		endif;
	}

	function cofwc_hide_product_price_css()
	{
		$hide_price = get_option('cofwc_hide_price');
		if (is_singular('product'))
		{
			if ($hide_price == 1):
				wp_add_inline_style('cofwc-inline-price', '
				.single-product .price,
				.wc-block-components-product-price.wc-block-grid__product-price {
					display: none !important;
				}
			');
			endif;
		}
	}

	public function cofwc_hide_product_prices_single_product($price_html)
	{
		$hide_price = get_option('cofwc_hide_price');
		if ($hide_price == 1):
			if (is_singular('product'))
			{
				// Replace the price HTML with an empty string to hide it
				$price_html = '';
			}
			return $price_html;
		else:
			return $price_html;
		endif;
	}



}
