/**
 * Admin logic for Custom Link Display
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        var $rulesList = $('#cld-rules-list');
        var $template  = $('#cld-rule-template').html();

        if (!$rulesList.length) return;

        // Initialize Sortable
        $rulesList.sortable({
            handle: '.cld-col-drag',
            axis: 'y',
            update: function() {
                reindexRules();
            }
        });

        // Add Rule
        $('#cld-add-rule').on('click', function() {
            var index = $rulesList.find('.cld-rule-item').length;
            var uniqueId = 'cld_' + Math.random().toString(36).substr(2, 9);
            var html = $template.replace(/{{index}}/g, index).replace(/{{id}}/g, uniqueId);
            
            // Remove "No rules" message if it exists
            $('.cld-no-rules').remove();
            
            $rulesList.append(html);
            
            // Scroll to the new rule
            $('html, body').animate({
                scrollTop: $rulesList.find('.cld-rule-item').last().offset().top - 100
            }, 500);
        });

        // Copy Shortcode
        $rulesList.on('click', '.cld-shortcode-display', function() {
            $(this).select();
            document.execCommand('copy');
            
            var $this = $(this);
            var originalValue = $this.val();
            $this.val('Copied!');
            setTimeout(function() {
                $this.val(originalValue);
            }, 1000);
        });

        // Remove Rule
        $rulesList.on('click', '.cld-remove-rule', function() {
            if (confirm('Are you sure you want to remove this rule?')) {
                $(this).closest('.cld-rule-item').fadeOut(300, function() {
                    $(this).remove();
                    // Re-index remaining rules
                    reindexRules();
                });
            }
        });

        // Toggle HTML Textarea
        $rulesList.on('click', '.cld-toggle-html', function() {
            var $item = $(this).closest('.cld-rule-item');
            $item.find('.cld-rule-html').toggleClass('active');
            $item.find('.cld-rule-link-config').removeClass('active');
            $item.find('.cld-toggle-link').removeClass('active');
            $(this).toggleClass('active');
        });

        // Toggle Link Configurator
        $rulesList.on('click', '.cld-toggle-link', function() {
            var $item = $(this).closest('.cld-rule-item');
            $item.find('.cld-rule-link-config').toggleClass('active');
            $item.find('.cld-rule-html').removeClass('active');
            $item.find('.cld-toggle-html').removeClass('active');
            $(this).toggleClass('active');
        });

        /**
         * Re-index rules after removal to ensure POST data is consistent
         */
        function reindexRules() {
            $rulesList.find('.cld-rule-item').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('input, select, textarea').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        var newName = name.replace(/rules\[\d+\]/, 'rules[' + index + ']');
                        $(this).attr('name', newName);
                    }
                });
            });
            
            if ($rulesList.find('.cld-rule-item').length === 0) {
                $rulesList.append('<p class="cld-no-rules">No rules defined yet. Click "Add New Rule" to get started.</p>');
            }
        }
    });

})(jQuery);
