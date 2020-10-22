<?php


class DIFEED_REST_TODAY_CONTROLLER extends WP_REST_Controller
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The date that send with request.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $date The date that send with request.
	 */
	private $date;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @since    1.0.0
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->date = '';
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes()
	{
		$version = '1';
		$namespace = $this->plugin_name . '/v' . $version;
		$base = 'today';

		register_rest_route(
			$namespace,
			'/' . $base . '/(?P<day>([0-2][0-9]|(3)[0-1]))/(?P<month>((0)[0-9])|((1)[0-2]))/(?P<year>\d{4})',
			array(
				array(
					'methods' => WP_REST_Server::READABLE,
					'callback' => array($this, 'get_items'),
					'permission_callback' => array($this, 'get_items_permissions_check'),
					'args' => array(
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

		$items = array();
		$data = array();
		$params = $request->get_params();
		$this->date = $params['day'] . $params['month'] . $params['year'];

		$hadith = null;
		$ayah = null;
		$name = null;
		$post = null;

		$options = get_option('difeed_options');

		// Get posts by date.

		$schedule_term = $this->get_schedule_name_by_day($this->date);
		$hadith_per_page = $options[DIFeed_Admin_Options::$HADITH['per_page']];
		$ayah_per_page = $options[DIFeed_Admin_Options::$AYAH['per_page']];
		$post_per_page = $options[DIFeed_Admin_Options::$POST['per_page']];
		$name_per_page = $options[DIFeed_Admin_Options::$NAMES['per_page']];

		// if found schedule term for this day.
		if (!empty($schedule_term)) {
			foreach ($schedule_term as $term) {
				// get hadith under term.
				$hadith = $this->list_posts_by_term(DIFeed_Post_Types::$HADITH, $term, $hadith_per_page);
				// get ayah under term.
				$ayah = $this->list_posts_by_term(DIFeed_Post_Types::$AYAH, $term, $ayah_per_page);
				// get ayah under term.
				$post = $this->list_posts_by_term('post', $term, $post_per_page);
				// get ayah under term.
				$name = $this->list_posts_by_term(DIFeed_Post_Types::$NAMES, $term, $name_per_page);
			}
		}

		// fetch randomly if type is empty.
		if (empty($ayah)) {
			$ayah = $this->get_random_post(DIFeed_Post_Types::$AYAH, $ayah_per_page);
		}
		if (empty($hadith)) {
			$hadith = $this->get_random_post(DIFeed_Post_Types::$HADITH, $hadith_per_page);
		}
		if (empty($name)) {
			$name = $this->get_random_post(DIFeed_Post_Types::$NAMES, $name_per_page);
		}
		if (empty($post)) {
			$post = $this->get_random_post('post', $post_per_page);
		}


		if (is_sticky($post)) {
			array_push($items, ...$post, ...$ayah, ...$hadith, ...$name);
		} else {
			array_push($items, ...$ayah, ...$hadith, ...$name, ...$post);
		}

		foreach ($items as $item) {
			$itemdata = $this->prepare_item_for_response($item, $request);
			$data[] = $this->prepare_response_for_collection($itemdata);
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
	 * @param mixed $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function prepare_item_for_response($item, $request)
	{

		return array(
			'id' => (int)$item->ID,
			'date' => apply_filters('the_date', $item->post_date),
			'date_gmt' => apply_filters('the_date', $item->post_date_gmt),
			'modified' => apply_filters('the_modified', $item->post_modified),
			'modified_gmt' => apply_filters('the_modified', $item->post_modified_gmt),
			'slug' => $item->post_name,
			'status' => $item->post_status,
			'type' => $item->post_type,
			'link' => get_the_permalink($item),
			'title' => array('rendered' => apply_filters('the_title', $item->post_title)),
			'content' => array('rendered' => apply_filters('the_content', $item->post_content)),
			'en_content' => get_post_meta($item->ID, 'en_content', true),
			'source_url' => get_post_meta($item->ID, 'source_url'),
			'excerpt' => array('rendered' => apply_filters('the_excerpt', $item->post_excerpt)),
			'author' => (int)$item->post_author,
			'featured_image' => array(
				'thumbnail' => get_the_post_thumbnail_url($item, 'thumbnail'),
				'medium' => get_the_post_thumbnail_url($item, 'medium'),
				'large' => get_the_post_thumbnail_url($item, 'large'),
			),
			'sticky' => is_sticky($item->ID),
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
		$query = "SELECT t.slug
	FROM $wpdb->terms t
		INNER JOIN $wpdb->termmeta tm_start ON tm_start.term_id = t.term_id
		AND tm_start.meta_key = 'start_date'
		INNER JOIN $wpdb->termmeta tm_end ON tm_end.term_id = t.term_id
		AND tm_end.meta_key = 'end_date'
	WHERE (
				tm_end.meta_value IS NULL
				AND STR_TO_DATE(tm_start.meta_value, '%d%m%Y') = STR_TO_DATE('$date', '%d%m%Y')
		)
		OR (
				STR_TO_DATE(tm_start.meta_value, '%d%m%Y') <= STR_TO_DATE('$date', '%d%m%Y')
				AND STR_TO_DATE(tm_end.meta_value, '%d%m%Y') >= STR_TO_DATE('$date', '%d%m%Y')
		)";

		// execute sql query.
		return array_keys((array)$wpdb->get_results($query, 'OBJECT_K'));
	}


	/**
	 * Get posts and group by taxonomy terms.
	 *
	 * @param string $posts Post type to get.
	 * @param string $term Taxonomy to group by.
	 * @param integer $count How many post to show per taxonomy term.
	 */
	private function list_posts_by_term($posts, $term, $count = 1)
	{
		$args = array(
			'posts_per_page' => isset($count) ? $count : 1,
			'tax_query' => array(
				array(
					'taxonomy' => DIFeed_Taxonomies::$SCHEDULE,
					'field' => 'slug',
					'terms' => $term
				)
			),
			'post_type' => $posts,
		);

		return get_posts($args);
	}


	/**
	 * Get post of day
	 *
	 * @param string $type Po st type to get.
	 * @param integer $count How many post to show per taxonomy term.
	 *
	 * @return {}
	 */
	private function get_random_post($type = 'post', $count = 1)
	{
		$cache = $this->plugin_name . '_' . str_replace('-', '_', $type) . '_' . $this->date;
		$post_random_item = $post_query = get_transient($cache);
		if (false === $post_random_item) {
			$post_query = new WP_Query(
				array(
					'posts_per_page' => isset($count) ? $count : 1,
					'post_type' => $type,
					'post_status' => 'publish',
					'ignore_sticky_posts' => true,
					'orderby' => 'rand',
				)
			);
			$post_random_item = $post_query->get_posts();

			// Put the results in a transient. Expire after 24 hours.
			set_transient($cache, $post_random_item, 24 * HOUR_IN_SECONDS);
		}

		return $post_random_item;
	}
}
