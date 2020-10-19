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

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Daily_Islamic_Feed
 * @subpackage Daily_Islamic_Feed/admin
 * @author     Your Name <email@example.com>
 */
class Daily_Islamic_Feed_Admin_Options
{

	public static $POST = array(
		'per_page' => 'dif_posts_per_page'
	);

	public static $HADITH = array(
		'per_page' => 'dif_hadith_per_page',
		'bg_gradient_one' => 'dif_hadith_bg_gradient_one',
		'bg_gradient_two' => 'dif_hadith_bg_gradient_two',
	);

	public static $AYAH = array(
		'per_page' => 'dif_ayah_per_page',
		'bg_gradient_one' => 'dif_ayah_bg_gradient_one',
		'bg_gradient_two' => 'dif_ayah_bg_gradient_two',
	);

	public static $NAMES = array(
		'per_page' => 'dif_name_per_page',
		'bg_gradient_one' => 'dif_name_bg_gradient_one',
		'bg_gradient_two' => 'dif_name_bg_gradient_two',
	);




	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $daily_islamic_feed    The ID of this plugin.
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
	 * @param      string    $daily_islamic_feed       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($daily_islamic_feed, $version)
	{

		$this->plugin_name = $daily_islamic_feed;
		$this->version = $version;
	}

	/**
	 * Register settings option.
	 *
	 * @return void
	 */
	function daily_islamic_feed_register_settings()
	{
		register_setting($this->plugin_name, 'dif_options');

		// Posts settings.
		add_settings_section('post_settings', 'Post Settings', array($this, 'post_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$POST['per_page'], 'Posts Per Page',  array($this, 'dif_per_page_input'), $this->plugin_name, 'post_settings',   array(
			'label_for'         => self::$POST['per_page']
		));


		// Hadith
		add_settings_section('hadith_settings', 'Hadith Settings', array($this, 'hadith_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$HADITH['per_page'], 'Hadith Per Page',  array($this, 'dif_per_page_input'), $this->plugin_name, 'hadith_settings',   array(
			'label_for'         => self::$HADITH['per_page']
		));
		add_settings_field(self::$HADITH['bg_gradient_one'], 'First Gradient Color',  array($this, 'hadith_bg_gradient_one'), $this->plugin_name, 'hadith_settings');
		add_settings_field(self::$HADITH['bg_gradient_two'], 'Second Gradient Color',  array($this, 'hadith_bg_gradient_two'), $this->plugin_name, 'hadith_settings');


		// Ayah
		add_settings_section('ayah_settings', 'Ayah Settings', array($this, 'ayah_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$AYAH['per_page'], 'Ayah Per Page',  array($this, 'dif_per_page_input'), $this->plugin_name, 'ayah_settings',   array(
			'label_for'         => self::$AYAH['per_page']
		));
		add_settings_field(self::$AYAH['bg_gradient_one'], 'First Gradient Color',  array($this, 'ayah_bg_gradient_one'), $this->plugin_name, 'ayah_settings');
		add_settings_field(self::$AYAH['bg_gradient_two'], 'Second Gradient Color',  array($this, 'ayah_bg_gradient_two'), $this->plugin_name, 'ayah_settings');


		// Name Of Allah
		add_settings_section('name_settings', 'Name Settings', array($this, 'name_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$NAMES['per_page'], 'Name Per Page',  array($this, 'dif_per_page_input'), $this->plugin_name, 'name_settings',   array(
			'label_for'         => self::$NAMES['per_page']
		));
		add_settings_field(self::$NAMES['bg_gradient_one'], 'First Gradient Color',  array($this, 'name_bg_gradient_one'), $this->plugin_name, 'name_settings');
		add_settings_field(self::$NAMES['bg_gradient_two'], 'Second Gradient Color',  array($this, 'name_bg_gradient_two'), $this->plugin_name, 'name_settings');
	}


	function post_settings_section_text()
	{
		echo '<p>Here you can set all the options for Posts</p>';
	}



	function hadith_settings_section_text()
	{
		echo '<p>Here you can set all the options for Hadith post type</p>';
	}



	function ayah_settings_section_text()
	{
		echo '<p>Here you can set all the options for Ayah post type</p>';
	}



	function name_settings_section_text()
	{
		echo '<p>Here you can set all the options for Names Of Allah post type</p>';
	}


	function dif_per_page_input($args)
	{
		$options = get_option('dif_options');
		$value = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '1';
?>
		<input type='number' id="<?php echo esc_attr($args['label_for']); ?>" name="dif_options[<?php echo esc_attr($args['label_for']); ?>]" min='1' value='<?php echo $value ?>' />
<?php
	}

	function hadith_bg_gradient_one()
	{
		echo 'Content here';
	}
	function hadith_bg_gradient_two()
	{
		echo 'Content here';
	}

	function ayah_bg_gradient_one()
	{
		echo 'Content here';
	}
	function ayah_bg_gradient_two()
	{
		echo 'Content here';
	}

	function name_bg_gradient_one()
	{
		echo 'Content here';
	}
	function name_bg_gradient_two()
	{
		echo 'Content here';
	}
}
