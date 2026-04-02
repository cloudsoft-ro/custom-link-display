<?php
/**
 * Admin-specific functionality.
 *
 * @package URLConditionalContent
 */

if (!defined('ABSPATH')) {
    exit;
}

class UCC_Admin
{

    public function enqueue_styles($hook)
    {
        if ('toplevel_page_ucc-settings' !== $hook) {
            return;
        }

        wp_enqueue_style('ucc-admin-css', UCC_URL . 'assets/admin-style.css', [], UCC_VERSION, 'all');
    }

    public function enqueue_scripts($hook)
    {
        if ('toplevel_page_ucc-settings' !== $hook) {
            return;
        }

        wp_enqueue_script('ucc-admin-js', UCC_URL . 'assets/admin-script.js', ['jquery', 'jquery-ui-sortable'], UCC_VERSION, true);

        wp_localize_script('ucc-admin-js', 'uccData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ucc_admin_nonce'),
        ]);
    }

    public function add_plugin_admin_menu()
    {
        add_menu_page(
            __('URL Conditional Content', 'url-conditional-content'),
            __('URL Content', 'url-conditional-content'),
            'manage_options',
            'ucc-settings',
        [$this, 'display_settings_page'],
            'dashicons-external',
            100
        );
    }

    public function register_settings()
    {
        if (isset($_POST['ucc_save_rules'])) {
            $this->save_rules();
        }
    }

    /**
     * Save rules to the database.
     */
    private function save_rules()
    {
        if (!isset($_POST['ucc_save_rules_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ucc_save_rules_nonce']), 'ucc_save_rules_action')) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        $raw_rules = isset($_POST['rules']) ? wp_unslash($_POST['rules']) : []; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $sanitized_rules = [];

        if (is_array($raw_rules)) {
            foreach ($raw_rules as $rule) {
                if (!is_array($rule) || (empty($rule['url']) && empty($rule['html']))) {
                    continue;
                }

                $url = !empty($rule['url']) ? $rule['url'] : '';
                $match_type = !empty($rule['match_type']) ? sanitize_text_field($rule['match_type']) : 'exact';

                if ($match_type !== 'regex' && !empty($url)) {
                    $parsed_url = wp_parse_url($url);
                    $url = (isset($parsed_url['path']) ? $parsed_url['path'] : '') . (isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '');
                }

                $sanitized_rules[] = [
                    'id'          => !empty($rule['id']) ? sanitize_text_field($rule['id']) : uniqid('ucc_'),
                    'url'         => $match_type === 'regex' ? $url : esc_url_raw($url),
                    'match_type'  => $match_type,
                    'location'    => sanitize_text_field($rule['location']),
                    'html'        => $rule['html'], // Kept for custom injection, handled on output.
                    'active'      => isset($rule['active']) ? 1 : 0,
                    'expiry_date' => !empty($rule['expiry_date']) ? sanitize_text_field($rule['expiry_date']) : '',
                ];
            }
        }

        update_option('ucc_rules', $sanitized_rules);

        add_settings_error('ucc_messages', 'ucc_message', __('Settings Saved', 'url-conditional-content'), 'updated');
    }

    public function display_settings_page()
    {
        $rules = get_option('ucc_rules', []);
        require_once UCC_PATH . 'templates/admin-page.php';
    }
}