<?php
/**
 * Admin settings page template.
 *
 * @package URLConditionalContent
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap ucc-admin-wrap">
    <div class="ucc-header">
        <div class="ucc-logo-area">
            <h1>
                <?php echo esc_html(get_admin_page_title()); ?>
            </h1>
            <p class="description">
                <?php esc_html_e('Display custom HTML snippets conditionally based on specific URLs.', 'url-conditional-content'); ?>
            </p>
        </div>
        <div class="ucc-actions">
            <button type="button" class="button button-primary" id="ucc-add-rule">
                <?php esc_html_e('Add New Rule', 'url-conditional-content'); ?>
            </button>
        </div>
    </div>

    <?php settings_errors('ucc_messages'); ?>

    <form method="post" action="">
        <?php wp_nonce_field('ucc_save_rules_action', 'ucc_save_rules_nonce'); ?>

        <div class="ucc-rules-container">
            <div class="ucc-rules-header">
                <div class="ucc-col-drag"></div>
                <div class="ucc-col-status">
                    <?php esc_html_e('Status', 'url-conditional-content'); ?>
                </div>
                <div class="ucc-col-url">
                    <?php esc_html_e('Target URL / Path', 'url-conditional-content'); ?>
                </div>
                <div class="ucc-col-match">
                    <?php esc_html_e('Match Type', 'url-conditional-content'); ?>
                </div>
                <div class="ucc-col-location">
                    <?php esc_html_e('Placement', 'url-conditional-content'); ?>
                </div>
                <div class="ucc-col-shortcode">
                    <?php esc_html_e('Shortcode', 'url-conditional-content'); ?>
                </div>
                <div class="ucc-col-expiry">
                    <?php esc_html_e('Expires', 'url-conditional-content'); ?>
                </div>
                <div class="ucc-col-actions">
                    <?php esc_html_e('Actions', 'url-conditional-content'); ?>
                </div>
            </div>

            <div id="ucc-rules-list">
                <?php if (!empty($rules)): ?>
                <?php foreach ($rules as $index => $rule): ?>
                <div class="ucc-rule-item" data-index="<?php echo esc_attr($index); ?>">
                    <div class="ucc-rule-main">
                        <div class="ucc-col-drag">
                            <span class="dashicons dashicons-move"></span>
                        </div>
                        <div class="ucc-col-status">
                            <label class="ucc-switch">
                                <input type="checkbox" name="rules[<?php echo esc_attr($index); ?>][active]" <?php
                                    checked(true, $rule['active']); ?>>
                                <span class="ucc-slider round"></span>
                            </label>
                        </div>
                        <div class="ucc-col-url">
                            <input type="text" name="rules[<?php echo esc_attr($index); ?>][url]"
                                value="<?php echo esc_url($rule['url']); ?>" placeholder="/some-page?param=value">
                        </div>
                        <div class="ucc-col-match">
                            <select name="rules[<?php echo esc_attr($index); ?>][match_type]">
                                <option value="exact" <?php selected('exact' , $rule['match_type']); ?>>
                                    <?php esc_html_e('Exact Match', 'url-conditional-content'); ?>
                                </option>
                                <option value="contains" <?php selected('contains' , $rule['match_type']); ?>>
                                    <?php esc_html_e('Contains', 'url-conditional-content'); ?>
                                </option>
                                <option value="regex" <?php selected('regex', $rule['match_type']); ?>>
                                    <?php esc_html_e('Regex Match', 'url-conditional-content'); ?>
                                </option>
                            </select>
                        </div>
                        <div class="ucc-col-location">
                            <select name="rules[<?php echo esc_attr($index); ?>][location]">
                                <option value="header" <?php selected('header' , $rule['location']); ?>>
                                    <?php esc_html_e('Header', 'url-conditional-content'); ?>
                                </option>
                                <option value="footer" <?php selected('footer' , $rule['location']); ?>>
                                    <?php esc_html_e('Footer', 'url-conditional-content'); ?>
                                </option>
                                <option value="before_content" <?php selected('before_content' , $rule['location']);
                                    ?>>
                                    <?php esc_html_e('Before Content', 'url-conditional-content'); ?>
                                </option>
                                <option value="after_content" <?php selected('after_content', $rule['location']); ?>>
                                    <?php esc_html_e('After Content', 'url-conditional-content'); ?>
                                </option>
                                <option value="shortcode" <?php selected('shortcode', $rule['location']); ?>>
                                    <?php esc_html_e('Shortcode Only', 'url-conditional-content'); ?>
                                </option>
                            </select>
                        </div>
                        <div class="ucc-col-shortcode">
                            <input type="text" class="ucc-shortcode-display" value='[ucc_content id="<?php echo esc_attr($rule['id']); ?>"]' readonly onclick="this.select();">
                        </div>
                        <div class="ucc-col-expiry">
                            <input type="date" name="rules[<?php echo esc_attr($index); ?>][expiry_date]"
                                value="<?php echo !empty($rule['expiry_date']) ? esc_attr($rule['expiry_date']) : ''; ?>">
                        </div>
                        <div class="ucc-col-actions">
                            <button type="button" class="ucc-toggle-html"
                                title="<?php esc_attr_e('Edit HTML', 'url-conditional-content'); ?>"><span
                                    class="dashicons dashicons-code-standards"></span></button>
                            <button type="button" class="ucc-remove-rule"
                                title="<?php esc_attr_e('Remove Rule', 'url-conditional-content'); ?>"><span
                                    class="dashicons dashicons-trash"></span></button>
                        </div>
                    </div>
                    <div class="ucc-rule-html">
                        <textarea name="rules[<?php echo esc_attr($index); ?>][html]"
                            placeholder="<?php esc_attr_e('Paste your custom HTML here...', 'url-conditional-content'); ?>"><?php echo esc_textarea($rule['html']); ?></textarea>
                    </div>
                    <input type="hidden" name="rules[<?php echo esc_attr($index); ?>][id]"
                        value="<?php echo esc_attr($rule['id']); ?>">
                </div>
                <?php
    endforeach; ?>
                <?php
else: ?>
                <p class="ucc-no-rules">
                    <?php esc_html_e('No rules defined yet. Click "Add New Rule" to get started.', 'url-conditional-content'); ?>
                </p>
                <?php
endif; ?>
            </div>
        </div>

        <div class="ucc-submit-area">
            <input type="submit" name="ucc_save_rules" class="button button-primary button-large"
                value="<?php esc_attr_e('Save All Rules', 'url-conditional-content'); ?>">
        </div>
    </form>
</div>

<!-- Template for new rule (Hidden) -->
<script type="text/template" id="ucc-rule-template">
    <div class="ucc-rule-item" data-index="{{index}}">
        <div class="ucc-rule-main">
            <div class="ucc-col-drag">
                <span class="dashicons dashicons-move"></span>
            </div>
            <div class="ucc-col-status">
                <label class="ucc-switch">
                    <input type="checkbox" name="rules[{{index}}][active]" checked>
                    <span class="ucc-slider round"></span>
                </label>
            </div>
            <div class="ucc-col-url">
                <input type="text" name="rules[{{index}}][url]" value="" placeholder="/some-page?param=value">
            </div>
            <div class="ucc-col-match">
                <select name="rules[{{index}}][match_type]">
                    <option value="exact"><?php esc_html_e('Exact Match', 'url-conditional-content'); ?></option>
                    <option value="contains"><?php esc_html_e('Contains', 'url-conditional-content'); ?></option>
                    <option value="regex"><?php esc_html_e('Regex Match', 'url-conditional-content'); ?></option>
                </select>
            </div>
            <div class="ucc-col-location">
                <select name="rules[{{index}}][location]">
                    <option value="header"><?php esc_html_e('Header', 'url-conditional-content'); ?></option>
                    <option value="footer"><?php esc_html_e('Footer', 'url-conditional-content'); ?></option>
                    <option value="before_content"><?php esc_html_e('Before Content', 'url-conditional-content'); ?></option>
                    <option value="after_content"><?php esc_html_e('After Content', 'url-conditional-content'); ?></option>
                    <option value="shortcode"><?php esc_html_e('Shortcode Only', 'url-conditional-content'); ?></option>
                </select>
            </div>
            <div class="ucc-col-shortcode">
                <input type="text" class="ucc-shortcode-display" value='[ucc_content id="{{id}}"]' readonly>
            </div>
            <div class="ucc-col-expiry">
                <input type="date" name="rules[{{index}}][expiry_date]" value="">
            </div>
            <div class="ucc-col-actions">
                <button type="button" class="ucc-toggle-html" title="<?php esc_attr_e('Edit HTML', 'url-conditional-content'); ?>"><span class="dashicons dashicons-code-standards"></span></button>
                <button type="button" class="ucc-remove-rule" title="<?php esc_attr_e('Remove Rule', 'url-conditional-content'); ?>"><span class="dashicons dashicons-trash"></span></button>
            </div>
        </div>
        <div class="ucc-rule-html">
            <textarea name="rules[{{index}}][html]" placeholder="<?php esc_attr_e('Paste your custom HTML here...', 'url-conditional-content'); ?>"></textarea>
        </div>
        <input type="hidden" name="rules[{{index}}][id]" value="">
    </div>
</script>