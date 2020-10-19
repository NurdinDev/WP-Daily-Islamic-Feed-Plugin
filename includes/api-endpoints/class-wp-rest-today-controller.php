<?php
class WP_REST_TODAY_CONTROLLER extends WP_REST_Controller
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
	 * @var      string    $version    The version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $daily_islamic_feed       The name of this plugin.
	 */
	public function __construct($daily_islamic_feed, $version)
	{

		$this->plugin_name = $daily_islamic_feed;
		$this->version = $version;
	}
	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes()
	{
		$version   = '1';
		$namespace = 'dif/v' . $version;
		$base      = 'today';

		register_rest_route(
			$namespace,
			'/' . $base . '/(?P<day>([0-2][0-9]|(3)[0-1]))/(?P<month>((0)[0-9])|((1)[0-2]))/(?P<year>\d{4})',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array($this, 'get_items'),
					'permission_callback' => array($this, 'get_items_permissions_check'),
					'args'                => array(
						'context' => array(
							'default' => 'view',
						),
					),
				),
			)
		);
	}

	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_items($request)
	{

		$items            = array();
		$data             = array();
		$params           = $request->get_params();
		$date             = $params['year'] . $params['month'] . $params['day'];

		$hadith = null;
		$ayah = null;
		$name = null;
		$post = null;

		$options = get_option('dif_options');

		// Get posts by date.

		$schedule_term = $this->get_schedule_name_by_day($date);

		// if found schedule term for this day.
		if (!empty($schedule_term)) {
			foreach ($schedule_term as $term) {

				// get hadith under term.
				$hadith = $this->list_posts_by_term(Daily_Islamic_Feed_Post_Types::$HADITH, $term, 1);
				if (empty($hadith)) {

					// get random one in case no spicific hadith in this day.
					$hadith = $this->get_random_post(Daily_Islamic_Feed_Post_Types::$HADITH, $options[Daily_Islamic_Feed_Admin_Options::$HADITH['per_page']]);
				}

				// get ayah under term.
				$ayah = $this->list_posts_by_term(Daily_Islamic_Feed_Post_Types::$AYAH, $term, 1);
				if (empty($ayah)) {

					// get random one in case no spicific ayah in this day.
					$ayah = $this->get_random_post(Daily_Islamic_Feed_Post_Types::$AYAH, $options[Daily_Islamic_Feed_Admin_Options::$AYAH['per_page']]);
				}

				// get ayah under term.
				$post = $this->list_posts_by_term('post', $term, 1);
				if (empty($post)) {

					// get random one in case no spicific post in this day.
					$post = $this->get_random_post('post', $options[Daily_Islamic_Feed_Admin_Options::$POST['per_page']]);
				}

				// get ayah under term.
				$name = $this->list_posts_by_term(Daily_Islamic_Feed_Post_Types::$NAMES, $term, 1);
				if (empty($name)) {

					// get random one in case no spicific name in this day.
					$name = $this->get_random_post('post', $options[Daily_Islamic_Feed_Admin_Options::$POST['per_page']]);
				}
			}
		} else {
			$ayah   = $this->get_random_post(Daily_Islamic_Feed_Post_Types::$AYAH, $options[Daily_Islamic_Feed_Admin_Options::$AYAH['per_page']]);
			$hadith = $this->get_random_post(Daily_Islamic_Feed_Post_Types::$HADITH, $options[Daily_Islamic_Feed_Admin_Options::$HADITH['per_page']]);
			$name   = $this->get_random_post(Daily_Islamic_Feed_Post_Types::$NAMES, $options[Daily_Islamic_Feed_Admin_Options::$NAMES['per_page']]);
			$post   = $this->get_random_post('post', $options[Daily_Islamic_Feed_Admin_Options::$POST['per_page']]);
		}


		if (is_sticky($post)) {
			array_push($items, ...$post, ...$ayah, ...$hadith, ...$name);
		} else {
			array_push($items, ...$ayah, ...$hadith, ...$name, ...$post);
		}

		foreach ($items as $item) {
			$itemdata = $this->prepare_item_for_response($item, $request);
			$data[]   = $this->prepare_response_for_collection($itemdata);
		}

		return new WP_REST_Response($data, 200);
	}



	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_items_permissions_check($request)
	{
		return true; // to make readable by all.
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed           $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function prepare_item_for_response($item, $request)
	{
		return array(
			'id'             => (int) $item->ID,
			'date'           => apply_filters('the_date', $item->post_date),
			'date_gmt'       => apply_filters('the_date', $item->post_date_gmt),
			'modified'       => apply_filters('the_modified', $item->post_modified),
			'modified_gmt'   => apply_filters('the_modified', $item->post_modified_gmt),
			'slug'           => $item->post_name,
			'status'         => $item->post_status,
			'type'           => $item->post_type,
			'link'           => get_the_permalink($item),
			'title'          => array('rendered' => apply_filters('the_title', $item->post_title)),
			'content'        => array('rendered' => apply_filters('the_content', $item->post_content)),
			'excerpt'        => array('rendered' => apply_filters('the_excerpt', $item->post_excerpt)),
			'author'         => (int) $item->post_author,
			'featured_image' => array(
				'thumbnail' => get_the_post_thumbnail_url($item, 'thumbnail'),
				'medium'    => get_the_post_thumbnail_url($item, 'medium'),
				'large'     => get_the_post_thumbnail_url($item, 'large'),
			),
			'sticky'         => is_sticky($item->ID),
		);
	}


	/**
	 * Get post by date
	 *
	 * @return {}
	 */
	private function get_schedule_name_by_day($date)
	{
		global $wpdb;

		$query = <<<SQL
									SELECT t.term_id, t.name
									FROM $wpdb->terms t
										INNER JOIN $wpdb->termmeta tm_start ON tm_start.term_id = t.term_id
										AND tm_start.meta_key = 'start_date'
										INNER JOIN $wpdb->termmeta tm_end ON tm_end.term_id = t.term_id
										AND tm_end.meta_key = 'end_date'
									WHERE (
												tm_end.meta_value IS NULL
												AND STR_TO_DATE(tm_start.meta_value, '%Y%m%d') = STR_TO_DATE($date, '%Y%m%d')
										)
										OR (
												STR_TO_DATE(tm_start.meta_value, '%Y%m%d') <= STR_TO_DATE($date, '%Y%m%d')
												AND STR_TO_DATE(tm_end.meta_value, '%Y%m%d') >= STR_TO_DATE($date, '%Y%m%d')
										);
								SQL;

		// execute sql query.
		return array_keys((array) $wpdb->get_results($query, 'OBJECT_K'));
	}


	/**
	 * Get posts and group by taxonomy terms.
	 *
	 * @param string  $posts Post type to get.
	 * @param string  $terms Taxonomy to group by.
	 * @param integer $count How many post to show per taxonomy term.
	 */
	private function list_posts_by_term($posts, $terms, $count = -1)
	{
		$tax_terms = get_terms($terms, 'orderby=name');
		$args      = array(
			'posts_per_page' => $count,
			$terms           => $tax_terms->slug,
			'post_type'      => $posts,
		);

		return get_posts($args);
	}


	/**
	 * Get post of day
	 *
	 * @param string  $type Post type to get.
	 * @param integer $count How many post to show per taxonomy term.
	 *
	 * @return {}
	 */
	private function get_random_post($type = 'post', $count = 1)
	{
		$cache      = $this->plugin_name . '_' . $type;
		$post_cache = wp_cache_get($cache);
		$post_random_item = null;
		if (empty($post_cache)) {
			$post_query       = new WP_Query(
				array(
					'posts_per_page'      => $count,
					'post_type'           => $type,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'orderby'             => 'rand',
				)
			);
			$post_random_item = $post_query->get_posts();
			wp_cache_set($cache, $post_random_item);
		} else {
			$post_random_item = $post_cache;
		}

		return $post_random_item;
	}

	/**
	 * Get categories IDs
	 *
	 * @return array
	 */
	private function qjapp_get_category_id()
	{
		$excluded_categories = array('Block', 'Template', 'Uncategorized');
		$cat                 = $excluded_categories;
		$ids                 = array();
		foreach ($cat as &$value) {
			array_push($ids, get_cat_ID($value));
		}
		return $ids;
	}
}
