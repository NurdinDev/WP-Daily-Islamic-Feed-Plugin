<?php

/**
 * Register Custom Post Types
 *
 * Add extra posts types for Islamic feed contains Hadith, Ayat, and Name-of-Allah posts
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 */

/**
 * Register Custom Post Types.
 *
 * Add extra posts types for Islamic feed contains Hadith, Ayat, and Name-of-Allah posts
 *
 * @since      1.0.0
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 * @author     Your Name <email@example.com>
 */
class Daily_Islamic_Feed_Post_Types
{

	/**
	 * Static custom posts names
	 *
	 * @var string
	 */
	public static $AYAH = 'ayah';
	public static $HADITH = 'hadith';
	public static $NAMES = 'names-of-allah';


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $daily_islamic_feed       The name of this plugin.
	 */
	public function __construct($daily_islamic_feed)
	{

		$this->plugin_name = $daily_islamic_feed;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */

	function register_post_types()
	{

		// Ayah post type.
		register_post_type(self::$AYAH, array(
			'labels'       => array(
				'name'                  => __('Ayah', $this->plugin_name, 'daily-islamic-feed'),
				'singular_name'         => __('Ayah', $this->plugin_name, 'daily-islamic-feed'),
				'add_new'               => __('Add New Ayah', $this->plugin_name, 'daily-islamic-feed'),
				'add_new_item'          => __('Add New Ayah', $this->plugin_name, 'daily-islamic-feed'),
				'new_item'              => __('New Ayah', $this->plugin_name, 'daily-islamic-feed'),
				'edit_item'             => __('Edit Ayah', $this->plugin_name, 'daily-islamic-feed'),
				'view_item'             => __('View Ayah', $this->plugin_name, 'daily-islamic-feed'),
				'all_items'             => __('Ayat', $this->plugin_name, 'daily-islamic-feed'),
				'featured_image'        => __('Ayah Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'set_featured_image'    => __('Set Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'remove_featured_image' => __('Remove Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'use_featured_image'    => __('Use Cover Image', $this->plugin_name, 'daily-islamic-feed'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'support'      => array('title', 'thumbnail', 'custom-fields'),
			'show_in_menu' => 'inspiration-menu-top-level',
			'taxonomies'   => array('category', 'post_tag', 'schedule')
		));

		// Hadit Post Type.
		register_post_type(self::$HADITH, array(
			'labels'       => array(
				'name'                  => __('Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'singular_name'         => __('Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'add_new'               => __('Add New Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'add_new_item'          => __('Add New Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'new_item'              => __('New Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'edit_item'             => __('Edit Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'view_item'             => __('View Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'all_items'             => __('Hadith', $this->plugin_name, 'daily-islamic-feed'),
				'featured_image'        => __('Hadith Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'set_featured_image'    => __('Set Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'remove_featured_image' => __('Remove Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'use_featured_image'    => __('Use Cover Image', $this->plugin_name, 'daily-islamic-feed')
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'support'      => array('title', 'thumbnail'),
			'show_in_menu' => 'inspiration-menu-top-level',
			'taxonomies'   => array('category', 'post_tag', 'schedule'),
		));


		// Names Of Allah Post Types.
		register_post_type(self::$NAMES, array(
			'labels'       => array(
				'name'                  => __('Names of Allah', $this->plugin_name, 'daily-islamic-feed'),
				'singular_name'         => __('Name of Allah', $this->plugin_name, 'daily-islamic-feed'),
				'add_new'               => __('Add New Name', $this->plugin_name, 'daily-islamic-feed'),
				'add_new_item'          => __('Add New Name', $this->plugin_name, 'daily-islamic-feed'),
				'new_item'              => __('New Name', $this->plugin_name, 'daily-islamic-feed'),
				'edit_item'             => __('Edit Name', $this->plugin_name, 'daily-islamic-feed'),
				'view_item'             => __('View Name', $this->plugin_name, 'daily-islamic-feed'),
				'all_items'             => __('Names of Allah', $this->plugin_name, 'daily-islamic-feed'),
				'featured_image'        => __('Name Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'set_featured_image'    => __('Set Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'remove_featured_image' => __('Remove Cover Image', $this->plugin_name, 'daily-islamic-feed'),
				'use_featured_image'    => __('Use Cover Image', $this->plugin_name, 'daily-islamic-feed'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'support'      => array('title', 'thumbnail'),
			'show_in_menu' => 'inspiration-menu-top-level'
		));
	}


	function disable_gutenberg( $current_status, $post_type ) {

		// Disabled post types
		$disabled_post_types = array( self::$NAMES, self::$HADITH, self::$AYAH );

		// Change $can_edit to false for any post types in the disabled post types array
		if ( in_array( $post_type, $disabled_post_types, true ) ) {
			$current_status = false;
		}

		return $current_status;
	}
}
