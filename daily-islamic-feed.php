<?php

/**
 * Plugin Name:     Daily Islamic Feed
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     difeed
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Daily_Islamic_Feed
 */

// Your code starts here.

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('DIFEED_VERSION', '1.0.0');
define('DIFEED_PLUGIN_DOMAIN', 'difeed');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-difeed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_islamic_feed()
{

	$plugin = new Daily_Islamic_Feed();
	$plugin->run();
}
run_islamic_feed();
