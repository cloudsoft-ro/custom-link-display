<?php
/**
 * Plugin Name: Custom Link Display
 * Plugin URI:  https://www.onu.ro/
 * Description: Display custom HTML snippets conditionally based on specific URLs and query parameters.
 * Version:     1.1.0
 * Author:      Constantin Onu
 * Author URI:  https://onu.ro
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-link-display
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.5
 * Requires PHP: 7.4
 *
 * @package CustomLinkDisplay
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 */
define('UCC_VERSION', '1.1.0');

/**
 * Path to the plugin directory.
 */
define('UCC_PATH', plugin_dir_path(__FILE__));

/**
 * URL to the plugin directory.
 */
define('UCC_URL', plugin_dir_url(__FILE__));

/**
 * The core plugin class.
 */
require_once UCC_PATH . 'includes/class-ucc-main.php';

/**
 * Begins execution of the plugin.
 */
function ucc_run_plugin()
{
	$plugin = new UCC_Main();
	$plugin->run();
}

/**
 * Activation Hook
 */
register_activation_hook(__FILE__, 'ucc_activate');
function ucc_activate()
{
	if (!get_option('ucc_rules')) {
		update_option('ucc_rules', []);
	}
}

/**
 * Deactivation Hook
 */
register_deactivation_hook(__FILE__, 'ucc_deactivate');
function ucc_deactivate()
{
// Cleanup if necessary
}

// Start the plugin
add_action('plugins_loaded', 'ucc_run_plugin');