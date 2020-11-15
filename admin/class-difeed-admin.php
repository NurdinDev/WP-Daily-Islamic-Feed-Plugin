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
class DIFeed_Admin
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
	 * Inspiration Menu
	 *
	 * @since 1.0.0
	 */
	public function add_inspiration_menu()
	{
		add_menu_page(
			__('Inspiration', $this->plugin_name, 'difeed'),
			'Inspiration',
			'manage_options',
			'inspiration-menu-top-level',
			'',
			plugin_dir_url(__DIR__) . 'public/images/icon.png',
			6
		);
	}

	/**
	 * Register the administration menu for this plugin into the Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_inspiration_settings_submenu()
	{

		/*
	     * Add a settings page for this plugin to the Settings menu.
	     */

		add_submenu_page('inspiration-menu-top-level', 'Settings', 'Settings', 'manage_options', $this->plugin_name, array($this, 'display_settings_page'));
	}


	/**
	 * Render the setting page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_settings_page()
	{
		include_once('partials/difeed-settings.php');
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
		 * defined in DIFeed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DIFeed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name . 'daterangepicker.css', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css', array(), $this->version, 'all');

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/difeed-admin.css', array(), $this->version, 'all');
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
		 * defined in DIFeed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DIFeed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		wp_enqueue_script($this->plugin_name . 'moment.min.js', 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js', array(), $this->version, true);
		wp_enqueue_script($this->plugin_name . 'daterangepicker.min.js', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', array(), $this->version, true);


		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/difeed-admin.js', array('jquery'), $this->version, false);
	}

	public function admin_options()
	{
		$options = new DIFeed_Admin_Options($this->plugin_name, $this->version);
		return $options->difeed_register_settings();
	}

	function codemirror_enqueue_scripts($hook)
	{
		$cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
		wp_localize_script('jquery', 'cm_settings', $cm_settings);

		wp_enqueue_script('wp-theme-plugin-editor');
		wp_enqueue_style('wp-codemirror');
	}
}
