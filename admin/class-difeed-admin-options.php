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
class DIFeed_Admin_Options
{

	public static $POST = array(
		'per_page' => 'difeed_posts_per_page',
		'style' => 'diffed_post_style'
	);

	public static $HADITH = array(
		'per_page' => 'difeed_hadith_per_page',
		'style' => 'diffed_hadith_style'
	);

	public static $AYAH = array(
		'per_page' => 'difeed_ayah_per_page',
		'style' => 'diffed_ayah_style'
	);

	public static $NAMES = array(
		'per_page' => 'difeed_name_per_page',
		'style' => 'diffed_names_style'
	);




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
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register settings option.
	 *
	 * @return void
	 */
	function difeed_register_settings()
	{
		register_setting($this->plugin_name, 'difeed_options');

		// Posts settings.
		add_settings_section('post_settings', 'Post Settings', array($this, 'post_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$POST['per_page'], 'Posts Per Page',  array($this, 'difeed_per_page_input'), $this->plugin_name, 'post_settings',   array(
			'label_for'         => self::$POST['per_page']
		));
		add_settings_field(self::$POST['style'], 'Card Style',  array($this, 'post_style'), $this->plugin_name, 'post_settings', array(
			'label_for' => self::$POST['style']
		));


		// Hadith
		add_settings_section('hadith_settings', 'Hadith Settings', array($this, 'hadith_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$HADITH['per_page'], 'Hadith Per Page',  array($this, 'difeed_per_page_input'), $this->plugin_name, 'hadith_settings',   array(
			'label_for'         => self::$HADITH['per_page']
		));
		add_settings_field(self::$HADITH['style'], 'Card Style',  array($this, 'hadith_style'), $this->plugin_name, 'hadith_settings', array(
			'label_for' => self::$HADITH['style']
		));


		// Ayah
		add_settings_section('ayah_settings', 'Ayah Settings', array($this, 'ayah_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$AYAH['per_page'], 'Ayah Per Page',  array($this, 'difeed_per_page_input'), $this->plugin_name, 'ayah_settings',   array(
			'label_for'         => self::$AYAH['per_page']
		));
		add_settings_field(self::$AYAH['style'], 'Card Style',  array($this, 'ayah_style'), $this->plugin_name, 'ayah_settings', array(
			'label_for' => self::$AYAH['style']
		));


		// Name Of Allah
		add_settings_section('names_settings', 'Names Of Allah Settings', array($this, 'name_settings_section_text'), $this->plugin_name);
		add_settings_field(self::$NAMES['per_page'], 'Name Per Page',  array($this, 'difeed_per_page_input'), $this->plugin_name, 'names_settings',   array(
			'label_for'         => self::$NAMES['per_page']
		));
		add_settings_field(self::$NAMES['style'], 'Card Style',  array($this, 'names_style'), $this->plugin_name, 'names_settings', array(
			'label_for' => self::$NAMES['style']
		));
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


	function difeed_per_page_input($args)
	{
		$options = get_option('difeed_options');
		$value = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '1';
?>
		<input type='number' id="<?php echo esc_attr($args['label_for']); ?>" name="difeed_options[<?php echo esc_attr($args['label_for']); ?>]" min='1' value='<?php echo $value ?>' />
<?php
	}

	function post_style($args)
	{
		$options = get_option('difeed_options');
		$value = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
		echo '<textarea class="fancy-textarea">' . esc_textarea($value) . '</textarea>';
	}
	function hadith_style($args)
	{
		$options = get_option('difeed_options');
		$value = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
		echo '<textarea class="fancy-textarea">' . esc_textarea($value) . '</textarea>';
	}

	function ayah_style($args)
	{
		echo 'Content here';
	}
	function names_style($args)
	{
		echo 'Content here';
	}
}
