<?php

/**
 * Register Custom Fields.
 *
 *
 * @since      1.0.0
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 * @author     Your Name <email@example.com>
 */
class DIFeed_Custom_Fields
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
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version       The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Create schedule Field
	 * @return void
	 */
	public function schedule_add_field()
	{
?>

		<div class="form-field term-daterange-wrap">
			<label for="daterange">Date Range</label>
			<input type="text" name="daterange" id="daterange" />
		</div>
	<?php
	}

	public function date_add_slashes($str)
	{
		return substr($str, 0, 2) . "/" . substr($str, 2, 2) . "/" . substr($str, 4, 4);
	}

	/**
	 * Edit schedule Field
	 * @return void
	 */
	function schedule_edit_field($term)
	{

		// put the term ID into a variable
		$t_id = $term->term_id;

		$term_start_date = get_term_meta($t_id, 'start_date', true);
		$term_end_date = get_term_meta($t_id, 'end_date', true);

		if (empty($term_end_date)) {
			$term_end_date = $term_start_date;
		}
		$formated_date = $term_start_date ? $this->date_add_slashes($term_start_date) . " - " . $this->date_add_slashes($term_end_date) : '';
	?>


		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="daterange">Date Range</label>
			</th>
			<td>
				<input type="text" name="daterange" value="<?php echo $formated_date  ? $formated_date : ''; ?>">
			</td>
		</tr>

<?php
	}


	/**
	 * Saving Field
	 */
	function schedule_save_field($term_id)
	{

		if (isset($_POST['daterange'])) {
			$term_date_range = $_POST['daterange'];
			if ($term_date_range) {
				$term_date_range = str_replace("/", "", $term_date_range);
				$dateObj = explode(" - ", $term_date_range);
				update_term_meta($term_id, 'start_date', $dateObj[0]);
				update_term_meta($term_id, 'end_date', $dateObj[1]);
			}
		}
	}
}
