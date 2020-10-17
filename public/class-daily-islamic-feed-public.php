<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/public
 * @author     Your Name <email@example.com>
 */
class Daily_Islamic_Feed_Public
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
	 * @param      string    $daily_islamic_feed       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($daily_islamic_feed, $version)
	{

		$this->plugin_name = $daily_islamic_feed;
		$this->version = $version;
		// $this->register_rest_routes();
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
		 * defined in Daily_Islamic_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Daily_Islamic_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/daily-islamic-feed-public.css', array(), $this->version, 'all');
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
		 * defined in Daily_Islamic_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Daily_Islamic_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/daily-islamic-feed-public.js', array('jquery'), $this->version, false);
	}

	/**
	 * Register REST API routes.
	 *
	 * @since 1.0.0
	 */
	public function register_rest_routes()
	{

		require_once plugin_dir_path(__DIR__) . 'includes/api-endpoints/class-wp-rest-today-controller.php';

		$controller = new WP_REST_TODAY_CONTROLLER($this->plugin_name, $this->version);

		if (is_subclass_of($controller, 'WP_REST_Controller')) {
			$controller->register_routes();
		}
	}
}
