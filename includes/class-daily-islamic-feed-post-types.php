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
	 * @var      string    $daily_islamic_feed    The ID of this plugin.
	 */
	private $daily_islamic_feed;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $daily_islamic_feed       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($daily_islamic_feed)
	{

		$this->daily_islamic_feed = $daily_islamic_feed;
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
				'name'                  => __('Ayah', $this->daily_islamic_feed),
				'singular_name'         => __('Ayah', $this->daily_islamic_feed),
				'add_new'               => __('Add New Ayah', $this->daily_islamic_feed),
				'add_new_item'          => __('Add New Ayah', $this->daily_islamic_feed),
				'new_item'              => __('New Ayah', $this->daily_islamic_feed),
				'edit_item'             => __('Edit Ayah', $this->daily_islamic_feed),
				'view_item'             => __('View Ayah', $this->daily_islamic_feed),
				'all_items'             => __('Ayat', $this->daily_islamic_feed),
				'featured_image'        => __('Ayah Cover Image', $this->daily_islamic_feed),
				'set_featured_image'    => __('Set Cover Image', $this->daily_islamic_feed),
				'remove_featured_image' => __('Remove Cover Image', $this->daily_islamic_feed),
				'use_featured_image'    => __('Use Cover Image', $this->daily_islamic_feed),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'support'      => array('title', 'editor', 'thumbnail'),
			'show_in_menu' => 'inspiration-menu-top-level',
			'taxonomies'   => array('category', 'post_tag', 'schedule')
		));

		// Hadit Post Type.
		register_post_type(self::$HADITH, array(
			'labels'       => array(
				'name'                  => __('Hadith', $this->daily_islamic_feed),
				'singular_name'         => __('Hadith', $this->daily_islamic_feed),
				'add_new'               => __('Add New Hadith', $this->daily_islamic_feed),
				'add_new_item'          => __('Add New Hadith', $this->daily_islamic_feed),
				'new_item'              => __('New Hadith', $this->daily_islamic_feed),
				'edit_item'             => __('Edit Hadith', $this->daily_islamic_feed),
				'view_item'             => __('View Hadith', $this->daily_islamic_feed),
				'all_items'             => __('Hadith', $this->daily_islamic_feed),
				'featured_image'        => __('Hadith Cover Image', $this->daily_islamic_feed),
				'set_featured_image'    => __('Set Cover Image', $this->daily_islamic_feed),
				'remove_featured_image' => __('Remove Cover Image', $this->daily_islamic_feed),
				'use_featured_image'    => __('Use Cover Image', $this->daily_islamic_feed)
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'support'      => array('title', 'editor', 'thumbnail'),
			'show_in_menu' => 'inspiration-menu-top-level',
			'taxonomies'   => array('category', 'post_tag', 'schedule'),
		));


		// Names Of Allah Post Types.
		register_post_type(self::$NAMES, array(
			'labels'       => array(
				'name'                  => __('Names of Allah', $this->daily_islamic_feed),
				'singular_name'         => __('Name of Allah', $this->daily_islamic_feed),
				'add_new'               => __('Add New Name', $this->daily_islamic_feed),
				'add_new_item'          => __('Add New Name', $this->daily_islamic_feed),
				'new_item'              => __('New Name', $this->daily_islamic_feed),
				'edit_item'             => __('Edit Name', $this->daily_islamic_feed),
				'view_item'             => __('View Name', $this->daily_islamic_feed),
				'all_items'             => __('Names of Allah', $this->daily_islamic_feed),
				'featured_image'        => __('Name Cover Image', $this->daily_islamic_feed),
				'set_featured_image'    => __('Set Cover Image', $this->daily_islamic_feed),
				'remove_featured_image' => __('Remove Cover Image', $this->daily_islamic_feed),
				'use_featured_image'    => __('Use Cover Image', $this->daily_islamic_feed),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'support'      => array('title', 'editor', 'thumbnail'),
			'show_in_menu' => 'inspiration-menu-top-level'
		));
	}
}
