<?php
/**
 * The core plugin class.
 *
 * @package URLConditionalContent
 */

if (!defined('ABSPATH')) {
    exit;
}

class UCC_Main
{

    protected $plugin_name;
    protected $version;

    public function __construct()
    {
        $this->plugin_name = 'url-conditional-content';
        $this->version = UCC_VERSION;

        $this->load_dependencies();
        $this->set_locale();
    }

    private function load_dependencies()
    {
        require_once UCC_PATH . 'includes/class-ucc-admin.php';
        require_once UCC_PATH . 'includes/class-ucc-frontend.php';
    }

    private function set_locale()
    {
    // WordPress.org handles translation loading automatically now.
    }

    public function run()
    {
        $admin = new UCC_Admin();
        $frontend = new UCC_Frontend();

        // Add Admin Hooks
        add_action('admin_menu', [$admin, 'add_plugin_admin_menu']);
        add_action('admin_enqueue_scripts', [$admin, 'enqueue_styles']);
        add_action('admin_enqueue_scripts', [$admin, 'enqueue_scripts']);
        add_action('admin_init', [$admin, 'register_settings']);

        // Frontend Hooks
        add_action('wp_head', [$frontend, 'inject_header_html']);
        add_action('wp_footer', [$frontend, 'inject_footer_html']);
        add_filter('the_content', [$frontend, 'inject_content_html']);
    }
}