<?php
/**
 * Admin settings page template.
 *
 * @package CustomLinkDisplay
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap cld-admin-wrap">
    <div class="cld-header">
        <div class="cld-logo-area">
            <h1>
                <?php echo esc_html(get_admin_page_title()); ?>
            </h1>
            <p class="description">
                <?php esc_html_e('Display custom HTML snippets conditionally based on specific URLs.', 'custom-link-display'); ?>
            </p>
        </div>
        <div class="cld-actions">
            <button type="button" class="button button-primary" id="cld-add-rule">
                <?php esc_html_e('Add New Rule', 'custom-link-display'); ?>
            </button>
        </div>
    </div>

    <?php settings_errors('cld_messages'); ?>

    <form method="post" action="">
        <?php wp_nonce_field('cld_save_rules_action', 'cld_save_rules_nonce'); ?>

        <div class="cld-rules-container">
            <div class="cld-rules-header">
                <div class="cld-col-drag"></div>
                <div class="cld-col-status">
                    <?php esc_html_e('Status', 'custom-link-display'); ?>
                </div>
                <div class="cld-col-url">
                    <?php esc_html_e('Target URL / Path', 'custom-link-display'); ?>
                </div>
                <div class="cld-col-match">
                    <?php esc_html_e('Match Type', 'custom-link-display'); ?>
                </div>
                <div class="cld-col-location">
                    <?php esc_html_e('Placement', 'custom-link-display'); ?>
                </div>
                <div class="cld-col-shortcode">
                    <?php esc_html_e('Shortcode', 'custom-link-display'); ?>
                </div>
                <div class="cld-col-expiry">
                    <?php esc_html_e('Expires', 'custom-link-display'); ?>
                </div>
                <div class="cld-col-actions">
                    <?php esc_html_e('Actions', 'custom-link-display'); ?>
                </div>
            </div>

            <div id="cld-rules-list">
                <?php if (!empty($rules)): ?>
                <?php foreach ($rules as $index => $rule): ?>
                <div class="cld-rule-item" data-index="<?php echo esc_attr($index); ?>">
                    <div class="cld-rule-main">
                        <div class="cld-col-drag">
                            <span class="dashicons dashicons-move"></span>
                        </div>
                        <div class="cld-col-status">
                            <label class="cld-switch">
                                <input type="checkbox" name="rules[<?php echo esc_attr($index); ?>][active]" <?php
                                    checked(true, $rule['active']); ?>>
                                <span class="cld-slider round"></span>
                            </label>
                        </div>
                        <div class="cld-col-url">
                            <input type="text" name="rules[<?php echo esc_attr($index); ?>][url]"
                                value="<?php echo esc_url($rule['url']); ?>" placeholder="/some-page?param=value">
                        </div>
                        <div class="cld-col-match">
                            <select name="rules[<?php echo esc_attr($index); ?>][match_type]">
                                <option value="exact" <?php selected('exact' , $rule['match_type']); ?>>
                                    <?php esc_html_e('Exact Match', 'custom-link-display'); ?>
                                </option>
                                <option value="contains" <?php selected('contains' , $rule['match_type']); ?>>
                                    <?php esc_html_e('Contains', 'custom-link-display'); ?>
                                </option>
                                <option value="regex" <?php selected('regex', $rule['match_type']); ?>>
                                    <?php esc_html_e('Regex Match', 'custom-link-display'); ?>
                                </option>
                            </select>
                        </div>
                        <div class="cld-col-location">
                            <select name="rules[<?php echo esc_attr($index); ?>][location]">
                                <option value="header" <?php selected('header' , $rule['location']); ?>>
                                    <?php esc_html_e('Header', 'custom-link-display'); ?>
                                </option>
                                <option value="footer" <?php selected('footer' , $rule['location']); ?>>
                                    <?php esc_html_e('Footer', 'custom-link-display'); ?>
                                </option>
                                <option value="before_content" <?php selected('before_content' , $rule['location']);
                                    ?>>
                                    <?php esc_html_e('Before Content', 'custom-link-display'); ?>
                                </option>
                                <option value="after_content" <?php selected('after_content', $rule['location']); ?>>
                                    <?php esc_html_e('After Content', 'custom-link-display'); ?>
                                </option>
                                <option value="shortcode" <?php selected('shortcode', $rule['location']); ?>>
                                    <?php esc_html_e('Shortcode Only', 'custom-link-display'); ?>
                                </option>
                            </select>
                        </div>
                        <div class="cld-col-shortcode">
                            <input type="text" class="cld-shortcode-display" value='[cld_content id="<?php echo esc_attr($rule['id']); ?>"]' readonly onclick="this.select();">
                        </div>
                        <div class="cld-col-expiry">
                            <input type="date" name="rules[<?php echo esc_attr($index); ?>][expiry_date]"
                                value="<?php echo !empty($rule['expiry_date']) ? esc_attr($rule['expiry_date']) : ''; ?>">
                        </div>
                        <div class="cld-col-actions">
                            <button type="button" class="cld-toggle-content"
                                title="<?php esc_attr_e('Edit Content', 'custom-link-display'); ?>"><span
                                    class="dashicons dashicons-edit"></span></button>
                            <button type="button" class="cld-remove-rule"
                                title="<?php esc_attr_e('Remove Rule', 'custom-link-display'); ?>"><span
                                    class="dashicons dashicons-trash"></span></button>
                        </div>
                    </div>
                    <div class="cld-rule-configs">
                        <div class="cld-content-type-selector">
                            <label>
                                <input type="radio" name="rules[<?php echo esc_attr($index); ?>][content_type]" value="html" class="cld-type-radio" <?php checked(!isset($rule['content_type']) || $rule['content_type'] === 'html'); ?>>
                                <?php esc_html_e('Custom HTML', 'custom-link-display'); ?>
                            </label>
                            <label>
                                <input type="radio" name="rules[<?php echo esc_attr($index); ?>][content_type]" value="link" class="cld-type-radio" <?php checked(isset($rule['content_type']) && $rule['content_type'] === 'link'); ?>>
                                <?php esc_html_e('Link Configurator', 'custom-link-display'); ?>
                            </label>
                        </div>
                        
                        <div class="cld-rule-html" style="<?php echo (isset($rule['content_type']) && $rule['content_type'] === 'link') ? 'display:none;' : ''; ?>">
                            <textarea name="rules[<?php echo esc_attr($index); ?>][html]"
                                placeholder="<?php esc_attr_e('Paste your custom HTML here...', 'custom-link-display'); ?>"><?php echo esc_textarea($rule['html'] ?? ''); ?></textarea>
                        </div>
                        <div class="cld-rule-link-config" style="<?php echo (!isset($rule['content_type']) || $rule['content_type'] === 'html') ? 'display:none;' : ''; ?>">
                            <div class="cld-link-fields-grid">
                                <div class="cld-link-field">
                                    <label><?php esc_html_e('Anchor Text', 'custom-link-display'); ?></label>
                                    <input type="text" name="rules[<?php echo esc_attr($index); ?>][link_anchor]" value="<?php echo esc_attr($rule['link_anchor'] ?? ''); ?>" placeholder="<?php esc_attr_e('Click Here', 'custom-link-display'); ?>">
                                </div>
                                <div class="cld-link-field">
                                    <label><?php esc_html_e('URL', 'custom-link-display'); ?></label>
                                    <input type="text" name="rules[<?php echo esc_attr($index); ?>][link_url]" value="<?php echo esc_url($rule['link_url'] ?? ''); ?>" placeholder="https://...">
                                </div>
                                <div class="cld-link-field">
                                    <label><?php esc_html_e('Title', 'custom-link-display'); ?></label>
                                    <input type="text" name="rules[<?php echo esc_attr($index); ?>][link_title]" value="<?php echo esc_attr($rule['link_title'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link Title', 'custom-link-display'); ?>">
                                </div>
                                <div class="cld-link-field">
                                    <label><?php esc_html_e('Target', 'custom-link-display'); ?></label>
                                    <select name="rules[<?php echo esc_attr($index); ?>][link_target]">
                                        <option value="_self" <?php selected('_self', $rule['link_target'] ?? ''); ?>><?php esc_html_e('Same Window (_self)', 'custom-link-display'); ?></option>
                                        <option value="_blank" <?php selected('_blank', $rule['link_target'] ?? ''); ?>><?php esc_html_e('New Window (_blank)', 'custom-link-display'); ?></option>
                                    </select>
                                </div>
                                <div class="cld-link-field">
                                    <label><?php esc_html_e('Rel Attribute', 'custom-link-display'); ?></label>
                                    <select name="rules[<?php echo esc_attr($index); ?>][link_rel]">
                                        <option value="" <?php selected('', $rule['link_rel'] ?? ''); ?>><?php esc_html_e('None (Dofollow)', 'custom-link-display'); ?></option>
                                        <option value="nofollow" <?php selected('nofollow', $rule['link_rel'] ?? ''); ?>>nofollow</option>
                                        <option value="sponsored" <?php selected('sponsored', $rule['link_rel'] ?? ''); ?>>sponsored</option>
                                        <option value="ugc" <?php selected('ugc', $rule['link_rel'] ?? ''); ?>>ugc</option>
                                        <option value="noopener noreferrer" <?php selected('noopener noreferrer', $rule['link_rel'] ?? ''); ?>>noopener noreferrer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rules[<?php echo esc_attr($index); ?>][id]"
                        value="<?php echo esc_attr($rule['id']); ?>">
                </div>
                <?php
    endforeach; ?>
                <?php
else: ?>
                <p class="cld-no-rules">
                    <?php esc_html_e('No rules defined yet. Click "Add New Rule" to get started.', 'custom-link-display'); ?>
                </p>
                <?php
endif; ?>
            </div>
        </div>

        <div class="cld-submit-area">
            <input type="submit" name="cld_save_rules" class="button button-primary button-large"
                value="<?php esc_attr_e('Save All Rules', 'custom-link-display'); ?>">
        </div>
    </form>
</div>

<!-- Template for new rule (Hidden) -->
<script type="text/template" id="cld-rule-template">
    <div class="cld-rule-item" data-index="{{index}}">
        <div class="cld-rule-main">
            <div class="cld-col-drag">
                <span class="dashicons dashicons-move"></span>
            </div>
            <div class="cld-col-status">
                <label class="cld-switch">
                    <input type="checkbox" name="rules[{{index}}][active]" checked>
                    <span class="cld-slider round"></span>
                </label>
            </div>
            <div class="cld-col-url">
                <input type="text" name="rules[{{index}}][url]" value="" placeholder="/some-page?param=value">
            </div>
            <div class="cld-col-match">
                <select name="rules[{{index}}][match_type]">
                    <option value="exact"><?php esc_html_e('Exact Match', 'custom-link-display'); ?></option>
                    <option value="contains"><?php esc_html_e('Contains', 'custom-link-display'); ?></option>
                    <option value="regex"><?php esc_html_e('Regex Match', 'custom-link-display'); ?></option>
                </select>
            </div>
            <div class="cld-col-location">
                <select name="rules[{{index}}][location]">
                    <option value="header"><?php esc_html_e('Header', 'custom-link-display'); ?></option>
                    <option value="footer"><?php esc_html_e('Footer', 'custom-link-display'); ?></option>
                    <option value="before_content"><?php esc_html_e('Before Content', 'custom-link-display'); ?></option>
                    <option value="after_content"><?php esc_html_e('After Content', 'custom-link-display'); ?></option>
                    <option value="shortcode"><?php esc_html_e('Shortcode Only', 'custom-link-display'); ?></option>
                </select>
            </div>
            <div class="cld-col-shortcode">
                <input type="text" class="cld-shortcode-display" value='[cld_content id="{{id}}"]' readonly>
            </div>
            <div class="cld-col-expiry">
                <input type="date" name="rules[{{index}}][expiry_date]" value="">
            </div>
            <div class="cld-col-actions">
                <button type="button" class="cld-toggle-content" title="<?php esc_attr_e('Edit Content', 'custom-link-display'); ?>"><span class="dashicons dashicons-edit"></span></button>
                <button type="button" class="cld-remove-rule" title="<?php esc_attr_e('Remove Rule', 'custom-link-display'); ?>"><span class="dashicons dashicons-trash"></span></button>
            </div>
        </div>
        <div class="cld-rule-configs">
            <div class="cld-content-type-selector">
                <label>
                    <input type="radio" name="rules[{{index}}][content_type]" value="html" class="cld-type-radio" checked>
                    <?php esc_html_e('Custom HTML', 'custom-link-display'); ?>
                </label>
                <label>
                    <input type="radio" name="rules[{{index}}][content_type]" value="link" class="cld-type-radio">
                    <?php esc_html_e('Link Configurator', 'custom-link-display'); ?>
                </label>
            </div>
            
            <div class="cld-rule-html">
                <textarea name="rules[{{index}}][html]" placeholder="<?php esc_attr_e('Paste your custom HTML here...', 'custom-link-display'); ?>"></textarea>
            </div>
            <div class="cld-rule-link-config" style="display:none;">
                <div class="cld-link-fields-grid">
                    <div class="cld-link-field">
                        <label><?php esc_html_e('Anchor Text', 'custom-link-display'); ?></label>
                        <input type="text" name="rules[{{index}}][link_anchor]" value="" placeholder="<?php esc_attr_e('Click Here', 'custom-link-display'); ?>">
                    </div>
                    <div class="cld-link-field">
                        <label><?php esc_html_e('URL', 'custom-link-display'); ?></label>
                        <input type="text" name="rules[{{index}}][link_url]" value="" placeholder="https://...">
                    </div>
                    <div class="cld-link-field">
                        <label><?php esc_html_e('Title', 'custom-link-display'); ?></label>
                        <input type="text" name="rules[{{index}}][link_title]" value="" placeholder="<?php esc_attr_e('Link Title', 'custom-link-display'); ?>">
                    </div>
                    <div class="cld-link-field">
                        <label><?php esc_html_e('Target', 'custom-link-display'); ?></label>
                        <select name="rules[{{index}}][link_target]">
                            <option value="_self"><?php esc_html_e('Same Window (_self)', 'custom-link-display'); ?></option>
                            <option value="_blank"><?php esc_html_e('New Window (_blank)', 'custom-link-display'); ?></option>
                        </select>
                    </div>
                    <div class="cld-link-field">
                        <label><?php esc_html_e('Rel Attribute', 'custom-link-display'); ?></label>
                        <select name="rules[{{index}}][link_rel]">
                            <option value=""><?php esc_html_e('None (Dofollow)', 'custom-link-display'); ?></option>
                            <option value="nofollow">nofollow</option>
                            <option value="sponsored">sponsored</option>
                            <option value="ugc">ugc</option>
                            <option value="noopener noreferrer">noopener noreferrer</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="rules[{{index}}][id]" value="{{id}}">
    </div>
</script>