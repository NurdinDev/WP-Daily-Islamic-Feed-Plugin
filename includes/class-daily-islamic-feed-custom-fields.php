<?php

/**
 * Register Custom Fields
 *
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 */

/**
 * Register Custom Fields.
 *
 *
 * @since      1.0.0
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/includes
 * @author     Your Name <email@example.com>
 */
class Daily_Islamic_Feed_Custom_Fields
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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 */
	public function __construct($daily_islamic_feed)
	{

		$this->plugin_name = $daily_islamic_feed;
	}

	/**
	 * Create schedule Field
	 * @return void
	 */
	public function schedule_add_field()
	{
?>
		<div class="form-field">
			<label for="taxImage"><?php _e('Image', 'yourtextdomain'); ?></label>

			<input type="text" name="taxImage" id="taxImage" value="">
		</div>
	<?php
	}

	/**
	 * Edit schedule Field
	 * @return void
	 */
	function schedule_edit_field($term)
	{

		// put the term ID into a variable
		$t_id = $term->term_id;

		$term_image = get_term_meta($t_id, 'image', true);
	?>
		<tr class="form-field">
			<th><label for="taxImage"><?php _e('Image', 'yourtextdomain'); ?></label></th>

			<td>
				<input type="text" name="taxImage" id="taxImage" value="<?php echo esc_attr($term_image) ? esc_attr($term_image) : ''; ?>">
			</td>
		</tr>
<?php
	}


	/**
	 * Saving Field
	 */
	function schedule_save_field($term_id)
	{

		if (isset($_POST['taxImage'])) {
			$term_image = $_POST['taxImage'];
			if ($term_image) {
				update_term_meta($term_id, 'image', $term_image);
			}
		}
	}
}
