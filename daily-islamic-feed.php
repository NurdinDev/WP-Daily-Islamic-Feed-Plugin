<?php

/**
 * Plugin Name:     Daily Islamic Feed
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     daily-islamic-feed
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
define('DAILY_ISLAMIC_FEED_VERSION', '1.0.0');
define('DAILY_ISLAMIC_FEED_DOMAIN', 'daily-islamic-feed');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-daily-islamic-feed-activator.php
 */
function activate_islamic_feed()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-daily-islamic-feed-activator.php';
	Daily_Islamic_Feed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-daily-islamic-feed-deactivator.php
 */
function deactivate_islamic_feed()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-daily-islamic-feed-deactivator.php';
	Daily_Islamic_Feed_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_islamic_feed');
register_deactivation_hook(__FILE__, 'deactivate_islamic_feed');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-daily-islamic-feed.php';

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
