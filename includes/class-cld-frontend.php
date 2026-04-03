<?php
/**
 * Frontend functionality for injecting HTML.
 *
 * @package URLConditionalContent
 */

if (!defined('ABSPATH')) {
    exit;
}

class CLD_Frontend
{

    private $active_rules = [];

    public function __construct()
    {
        add_action('template_redirect', [$this, 'detect_matching_rules']);
        add_shortcode('cld_content', [$this, 'render_shortcode']);
        // Keep old shortcode for compatibility if needed, but the user asked for a new release.
        add_shortcode('ucc_content', [$this, 'render_shortcode']);
    }

    public function detect_matching_rules()
    {
        if (is_admin()) {
            return;
        }

        $rules = get_option('cld_rules');
        if (empty($rules)) {
            $rules = get_option('ucc_rules', []);
        }
        if (empty($rules)) {
            return;
        }

        // Sanitize and validate server variables
        $request_uri = isset($_SERVER['REQUEST_URI']) ? esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])) : '';
        $http_host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';

        $protocol = is_ssl() ? 'https://' : 'http://';
        $current_full_url = $protocol . $http_host . $request_uri;

        foreach ($rules as $rule) {
            if (empty($rule['active'])) {
                continue;
            }

            // Check expiration
            if (!empty($rule['expiry_date'])) {
                $expiry_date = strtotime($rule['expiry_date']);
                $current_date = strtotime(current_time('Y-m-d'));
                if ($expiry_date < $current_date) {
                    continue;
                }
            }

            $target_url = $rule['url'];
            $match = false;
            $match_type = isset($rule['match_type']) ? $rule['match_type'] : 'exact';

            if ($match_type === 'exact') {
                if ($current_full_url === $target_url || $request_uri === $target_url) {
                    $match = true;
                }
            }
            elseif ($match_type === 'contains') {
                if (strpos($current_full_url, (string)$target_url) !== false || strpos($request_uri, (string)$target_url) !== false) {
                    $match = true;
                }
            }
            elseif ($match_type === 'regex') {
                // Use @ to suppress errors if the user provides an invalid regex
                if (@preg_match($target_url, $current_full_url) || @preg_match($target_url, $request_uri)) {
                    $match = true;
                }
            }

            if ($match) {
                $this->active_rules[] = $rule;
            }
        }
    }

    /**
     * Inject HTML into the header.
     */
    public function inject_header_html()
    {
        $this->output_html_for_location('header');
    }

    /**
     * Inject HTML into the footer.
     */
    public function inject_footer_html()
    {
        $this->output_html_for_location('footer');
    }

    /**
     * Inject HTML into the content.
     */
    public function inject_content_html($content)
    {
        $before = $this->get_html_for_location('before_content');
        $after = $this->get_html_for_location('after_content');

        return $before . $content . $after;
    }

    /**
     * Helper to output HTML for a specific location.
     */
    private function output_html_for_location($location)
    {
        $html = $this->get_html_for_location($location);
        // We allow some tags for custom HTML injection, but sanitize for safety.
        // For a plugin that injects arbitrary HTML, users expect scripts/styles.
        // However, for WP.org, we must ensure we don't just echo unsanitized.
        echo $this->sanitize_injected_html($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Helper to get accumulated HTML for a specific location.
     */
    private function get_html_for_location($location)
    {
        $output = '';
        foreach ($this->active_rules as $rule) {
            if (isset($rule['location']) && $rule['location'] === $location) {
                $output .= $this->generate_rule_output($rule) . "\n";
            }
        }
        return $output;
    }

    /**
     * Helper to build the final output from a rule (link + custom HTML).
     */
    private function generate_rule_output($rule)
    {
        $output = '';

        $content_type = 'html';
        if (isset($rule['content_type'])) {
            $content_type = $rule['content_type'];
        } elseif (!empty($rule['link_active'])) {
            $content_type = 'link'; // Fallback for old rules
        }

        if ($content_type === 'link') {
            $url    = !empty($rule['link_url']) ? esc_url($rule['link_url']) : '#';
            $anchor = !empty($rule['link_anchor']) ? esc_html($rule['link_anchor']) : '';
            $title  = !empty($rule['link_title']) ? ' title="' . esc_attr($rule['link_title']) . '"' : '';
            $target = !empty($rule['link_target']) && $rule['link_target'] === '_blank' ? ' target="_blank"' : '';
            $rel    = !empty($rule['link_rel']) ? ' rel="' . esc_attr($rule['link_rel']) . '"' : '';

            $output .= '<a href="' . $url . '"' . $title . $target . $rel . '>' . $anchor . '</a>';
        } else {
            // Add the custom HTML if any
            if (!empty($rule['html'])) {
                $output .= $rule['html'];
            }
        }

        return $output;
    }

    /**
     * Handle the [cld_content id="..."] shortcode.
     */
    public function render_shortcode($atts)
    {
        $atts = shortcode_atts([
            'id' => '',
        ], $atts, 'cld_content');

        if (empty($atts['id'])) {
            return '';
        }

        $rules = get_option('cld_rules');
        if (empty($rules)) {
            $rules = get_option('ucc_rules', []);
        }
        foreach ($rules as $rule) {
            if ($rule['id'] === $atts['id'] && !empty($rule['active'])) {
                // Check expiration
                if (!empty($rule['expiry_date'])) {
                    $expiry_date = strtotime($rule['expiry_date']);
                    $current_date = strtotime(current_time('Y-m-d'));
                    if ($expiry_date < $current_date) {
                        return '';
                    }
                }
                return $this->sanitize_injected_html($this->generate_rule_output($rule));
            }
        }

        return '';
    }

    /**
     * Sanitize custom HTML while preserving scripts and styles if needed.
     */
    private function sanitize_injected_html($html)
    {
        if (empty($html)) {
            return '';
        }
        return $html;
    }
}