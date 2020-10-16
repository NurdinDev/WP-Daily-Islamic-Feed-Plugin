<?php

/**
 * Register Custom Schedule Taxonomy
 *
 * you can schedule posts by grouping them in a schedule taxonomy
 * by choosing the start and end date for each schedule
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
 * you can schedule posts by grouping them in a schedule taxonomy
 * by choosing the start and end date for each schedule
 *
 * @since      1.0.0
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 * @author     Your Name <email@example.com>
 */
class Daily_Islamic_Feed_Taxonomies
{

	/**
	 * Taxonomy name
	 *
	 * @since    1.0.0
	 */
	public static $SCHEDULE = 'schedule';


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
	 * Register Schedule taxonomy
	 *
	 * assign this taxonomy to Hadith and Ayet posts and crate "Daily" as a default term
	 *
	 * @return void
	 */
	public function register_taxonomy()
	{
		$labels = array(
			'name'          => __('Schedule', $this->plugin_name),
			'singular_name' => __('Schedule', $this->plugin_name),
			'all_items'     => __('All Schedule', $this->plugin_name),
			'edit_item'     => __('Edit Schedule', $this->plugin_name),
			'update_item'   => __('Update Schedule', $this->plugin_name),
			'add_new_item'  => __('Add New Schedule', $this->plugin_name),
			'new_item_name' => __('New Schedule Name', $this->plugin_name),
			'menu_name'     => __('Scheduling', $this->plugin_name),
		);

		register_taxonomy(
			self::$SCHEDULE,
			array('post', Daily_Islamic_Feed_Post_Types::$HADITH, Daily_Islamic_Feed_Post_Types::$AYAH),
			array(
				'hierarchical'          => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'show_in_rest'          => true,
				'query_var'             => true,
				'show_in_quick_edit'    => true,
				'update_count_callback' => '_update_post_term_count',
				'rewrite'               => array('slug' => 'schedule'),
				'default_term'          => 'Daily',
				'show_in_menu'          => true,
			)
		);
	}
}
