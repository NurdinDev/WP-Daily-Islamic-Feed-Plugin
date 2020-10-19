<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 * @author     Your Name <email@example.com>
 */
class Daily_Islamic_Feed
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Daily_Islamic_Feed_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('DAILY_ISLAMIC_FEED_VERSION')) {
			$this->version = DAILY_ISLAMIC_FEED_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		if (defined('PLUGIN_DOMAIN')) {
			$this->plugin_name = PLUGIN_DOMAIN;
		} else {
			$this->plugin_name = 'daily-islamic-feed';
		}

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_admin_options_hooks();
		$this->define_public_hooks();
		$this->register_post_types();
		$this->register_taxonomy();
		$this->register_fields();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Daily_Islamic_Feed_Loader. Orchestrates the hooks of the plugin.
	 * - Daily_Islamic_Feed_i18n. Defines internationalization functionality.
	 * - Daily_Islamic_Feed_Admin. Defines all hooks for the admin area.
	 * - Daily_Islamic_Feed_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-daily-islamic-feed-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-daily-islamic-feed-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-daily-islamic-feed-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the admin options area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-daily-islamic-feed-admin-options.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-daily-islamic-feed-public.php';

		$this->loader = new Daily_Islamic_Feed_Loader();


		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-daily-islamic-feed-post-types.php';

		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-daily-islamic-feed-taxonomies.php';

		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-daily-islamic-feed-custom-fields.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Daily_Islamic_Feed_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Daily_Islamic_Feed_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}
	/**
	 * Regsiter the custom posts we defined on Daily_Islamic_Feed_Post_Types
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_post_types()
	{

		$plugin_posts = new Daily_Islamic_Feed_Post_Types($this->get_plugin_name());

		$this->loader->add_action('init', $plugin_posts, 'register_post_types');

		// Disable Gutenberg editor from those post types.
		$this->loader->add_filter('use_block_editor_for_post_type', $plugin_posts, 'disable_gutenberg', 10, 2);
	}

	/**
	 * Regsiter taxonomy we defined on Daily_Islamic_Feed_Schedule
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_taxonomy()
	{
		$plugin_taxonomies = new Daily_Islamic_Feed_Taxonomies($this->get_plugin_name());
		$this->loader->add_action('init', $plugin_taxonomies, 'register_taxonomy');
	}

	/**
	 * Regsiter taxonomy we defined on Daily_Islamic_Feed_Custom_Fields
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_fields()
	{
		$plugin_fields = new Daily_Islamic_Feed_Custom_Fields($this->get_plugin_name(), $this->get_version());

		// add custom field for start and end date on schedule taxonomy


		$this->loader->add_action(Daily_Islamic_Feed_Taxonomies::$SCHEDULE . '_add_form_fields', $plugin_fields, 'schedule_add_field', 10, 2);
		$this->loader->add_action(Daily_Islamic_Feed_Taxonomies::$SCHEDULE . '_edit_form_fields', $plugin_fields, 'schedule_edit_field', 10);
		$this->loader->add_action('edited_' . Daily_Islamic_Feed_Taxonomies::$SCHEDULE, $plugin_fields, 'schedule_save_field');
		$this->loader->add_action('create_' . Daily_Islamic_Feed_Taxonomies::$SCHEDULE, $plugin_fields, 'schedule_save_field');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Daily_Islamic_Feed_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		$this->loader->add_action('admin_menu',  $plugin_admin, 'add_inspiration_menu');
		$this->loader->add_action('admin_menu',  $plugin_admin, 'add_inspiration_settings_submenu');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_options_hooks()
	{

		$plugin_admin = new Daily_Islamic_Feed_Admin_Options($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_init',  $plugin_admin, 'daily_islamic_feed_register_settings');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Daily_Islamic_Feed_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		$this->loader->add_action('rest_api_init', $plugin_public, 'register_rest_routes');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Daily_Islamic_Feed_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
