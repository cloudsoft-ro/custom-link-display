<?php
/**
 * Plugin Name: Custom Link Display
 * Plugin URI:  https://www.onu.ro/
 * Description: Display custom HTML snippets conditionally based on specific URLs and query parameters.
 * Version:     1.3.0
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
define('CLD_VERSION', '1.3.0');

/**
 * Path to the plugin directory.
 */
define('CLD_PATH', plugin_dir_path(__FILE__));

/**
 * URL to the plugin directory.
 */
define('CLD_URL', plugin_dir_url(__FILE__));

/**
 * The core plugin class.
 */
require_once CLD_PATH . 'includes/class-cld-main.php';

/**
 * Begins execution of the plugin.
 */
function cld_run_plugin()
{
	$plugin = new CLD_Main();
	$plugin->run();
}

/**
 * Activation Hook
 */
register_activation_hook(__FILE__, 'cld_activate');
function cld_activate()
{
	$cld_rules = get_option('cld_rules');
	if (!$cld_rules || empty($cld_rules)) {
		$old_rules = get_option('ucc_rules');
		if (!empty($old_rules)) {
			update_option('cld_rules', $old_rules);
		} else {
			update_option('cld_rules', []);
		}
	}
}

/**
 * Deactivation Hook
 */
register_deactivation_hook(__FILE__, 'cld_deactivate');
function cld_deactivate()
{
// Cleanup if necessary
}

// Start the plugin
add_action('plugins_loaded', 'cld_run_plugin');