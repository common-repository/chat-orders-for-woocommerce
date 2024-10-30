<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://shehab24.github.io/portfolio/
 * @since      1.0.0
 *
 * @package    Chat_Orders_For_Woocommerce
 * @subpackage Chat_Orders_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Chat_Orders_For_Woocommerce
 * @subpackage Chat_Orders_For_Woocommerce/admin
 * @author     Shehab Mahamud <mdshehab204@gmail.com>
 */
class Chat_Orders_For_Woocommerce_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/order-on-whatsapp-woocommerce-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/order-on-whatsapp-woocommerce-admin.js', array('jquery'), $this->version, false);

	}

	public function cofwc_add_custom_submenu_to_woocommerce()
	{
		add_menu_page(
			__('Order on Whatsapp', 'chat-orders-for-woocommerce'),
			__('Order on Whatsapp', 'chat-orders-for-woocommerce'),
			'manage_woocommerce',
			'order-on-whatsapp',
			array($this, 'cofwc_display_order_submenu_callback'),
			'dashicons-whatsapp' // Icon URL or name
		);
	}

	public function cofwc_display_order_submenu_callback()
	{
		// Add your submenu content here



		if (isset($_POST['whatsapp_number']))
		{
			// Verify nonce   
			if (isset($_POST['order_whatsapp_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['order_whatsapp_nonce'])), 'order_whatsapp_nonce'))
			{
				// Sanitize and save the form data
				$whatsapp_number = sanitize_text_field($_POST['whatsapp_number']);
				$button_text = isset($_POST['button_text']) ? sanitize_text_field($_POST['button_text']) : "Order on Whatsapp";
				$show_in_product_page = isset($_POST['show_in_product_page']) ? 1 : 0;
				$new_tab = isset($_POST['new_tab']) ? 1 : 0;
				$hide_price = isset($_POST['hide_price']) ? 1 : 0;
				$hide_add_cart_btn = isset($_POST['hide_add_cart_btn']) ? 1 : 0;

				// Save the data into the WordPress database
				update_option('cofwc_whatsapp_number', $whatsapp_number);
				update_option('cofwc_button_text', $button_text);
				update_option('cofwc_show_in_product_page', $show_in_product_page);
				update_option('cofwc_new_tab', $new_tab);
				update_option('cofwc_hide_price', $hide_price);
				update_option('cofwc_hide_add_cart_btn', $hide_add_cart_btn);

				echo '<div class="updated"><p>Settings saved.</p></div>';
			}
		}
		$whatsapp_number = get_option('cofwc_whatsapp_number');
		$button_text = get_option('cofwc_button_text');
		$show_in_product_page = get_option('cofwc_show_in_product_page');
		$new_tab = get_option('cofwc_new_tab');
		$hide_price = get_option('cofwc_hide_price');
		$hide_add_cart_btn = get_option('cofwc_hide_add_cart_btn');
		?>

		<div class="wrap">
			<h2>WhatsApp Settings</h2>
			<form class="whatsapp_order_form" method="post">
				<div class="form_control">
					<label for="number">Your Whatsapp Number</label>
					<div class="widefat">
						<input class="widefat" type="number" name="whatsapp_number" id="number"
							placeholder="Enter Whatsapp Number with Country Code"
							value="<?php echo esc_attr(get_option('cofwc_whatsapp_number')); ?>" required>
						<small>Enter Number with country code</small>
					</div>


				</div>
				<div class="form_control">
					<label for="button_text">Button Text</label>
					<input class="widefat" type="text" name="button_text" id="button_text" placeholder="Enter Your Button Text"
						value="<?php echo esc_attr(get_option('cofwc_button_text')); ?>">
				</div>
				<div class="form_control">
					<label for="show_in_product_page">Show button in Product page?</label>
					<div>
						<input class="widefat" type="checkbox" name="show_in_product_page" id="show_in_product_page" <?php checked(get_option('cofwc_show_in_product_page'), 1); ?>>
					</div>
				</div>
				<div class="form_control">
					<label for="new_tab">Open in new tab?</label>
					<div>
						<input class="widefat" type="checkbox" name="new_tab" id="new_tab" <?php checked(get_option('cofwc_new_tab'), 1); ?>>
					</div>
				</div>
				<div class="form_control">
					<label for="hide_price">Hide Price in Product Single Page?</label>
					<div>
						<input class="widefat" type="checkbox" name="hide_price" id="hide_price" <?php checked(get_option('cofwc_hide_price'), 1); ?>>
					</div>
				</div>
				<div class="form_control">
					<label for="hide_add_cart_btn">Hide "Add to Cart" Button in Product Single Page?</label>
					<div>
						<input class="widefat" type="checkbox" name="hide_add_cart_btn" id="hide_add_cart_btn" <?php checked(get_option('cofwc_hide_add_cart_btn'), 1); ?>>
					</div>
				</div>

				<!-- Include other form controls here -->

				<?php
				wp_nonce_field('order_whatsapp_nonce', 'order_whatsapp_nonce');
				submit_button('Save Settings');
				?>
			</form>
		</div>
		<?php
	}

}
