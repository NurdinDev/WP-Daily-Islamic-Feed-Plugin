<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/admin
 * @author     Your Name <email@example.com>
 */
class Daily_Islamic_Feed_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $daily_islamic_feed    The ID of this plugin.
	 */
	private $daily_islamic_feed;

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
	 * @param      string    $daily_islamic_feed       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($daily_islamic_feed, $version)
	{

		$this->daily_islamic_feed = $daily_islamic_feed;
		$this->version = $version;
		$this->admin_actions();
	}

	/**
	 * All admin actions.
	 *
	 * @since 1.0.0
	 */
	public function admin_actions()
	{

		// add inspiration menu and submenus
		add_action('admin_menu', array(&$this, 'add_inspiration_menu'));
		add_action('admin_menu', array(&$this, 'add_inspiration_submenu'));
	}

	/**
	 * Inspiration Menu
	 *
	 * @since 1.0.0
	 */
	public function add_inspiration_menu()
	{
		add_menu_page(
			__('Inspiration', $this->daily_islamic_feed),
			'Inspiration',
			'manage_options',
			'inspiration-menu-top-level',
			'',
			plugin_dir_url(__DIR__) . 'public/images/icon.png',
			6
		);
	}

	/**
	 * Inspiration submenu
	 *
	 * @since 1.0.0
	 */
	public function add_inspiration_submenu()
	{
		add_submenu_page('inspiration-menu-top-level', 'Settings', 'Settings', 'manage_options', 'inspiration-settings-page', 'qjapp_settings_function');
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
		 * defined in Daily_Islamic_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Daily_Islamic_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->daily_islamic_feed, plugin_dir_url(__FILE__) . 'css/daily-islamic-feed-admin.css', array(), $this->version, 'all');
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
		 * defined in Daily_Islamic_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Daily_Islamic_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->daily_islamic_feed, plugin_dir_url(__FILE__) . 'js/daily-islamic-feed-admin.js', array('jquery'), $this->version, false);
	}
}
