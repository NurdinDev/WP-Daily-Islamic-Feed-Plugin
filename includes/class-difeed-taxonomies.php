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
class DIFeed_Taxonomies
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
	 * @param      string    $plugin_name       The name of this plugin.
	 */
	public function __construct($plugin_name)
	{

		$this->plugin_name = $plugin_name;
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
			'name'          => __('Schedule', $this->plugin_name, 'difeed'),
			'singular_name' => __('Schedule', $this->plugin_name, 'difeed'),
			'all_items'     => __('All Schedule', $this->plugin_name, 'difeed'),
			'edit_item'     => __('Edit Schedule', $this->plugin_name, 'difeed'),
			'update_item'   => __('Update Schedule', $this->plugin_name, 'difeed'),
			'add_new_item'  => __('Add New Schedule', $this->plugin_name, 'difeed'),
			'new_item_name' => __('New Schedule Name', $this->plugin_name, 'difeed'),
			'menu_name'     => __('Scheduling', $this->plugin_name, 'difeed'),
		);

		register_taxonomy(
			self::$SCHEDULE,
			array('post', DIFeed_Post_Types::$HADITH, DIFeed_Post_Types::$AYAH),
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
