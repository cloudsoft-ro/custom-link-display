/**
 * Admin logic for URL Conditional Content
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        var $rulesList = $('#ucc-rules-list');
        var $template  = $('#ucc-rule-template').html();

        // Initialize Sortable
        $rulesList.sortable({
            handle: '.ucc-col-drag',
            axis: 'y',
            update: function() {
                reindexRules();
            }
        });

        // Add Rule
        $('#ucc-add-rule').on('click', function() {
            var index = $rulesList.find('.ucc-rule-item').length;
            var uniqueId = 'ucc_' + Math.random().toString(36).substr(2, 9);
            var html = $template.replace(/{{index}}/g, index).replace(/{{id}}/g, uniqueId);
            
            // Remove "No rules" message if it exists
            $('.ucc-no-rules').remove();
            
            $rulesList.append(html);
            
            // Scroll to the new rule
            $('html, body').animate({
                scrollTop: $rulesList.find('.ucc-rule-item').last().offset().top - 100
            }, 500);
        });

        // Copy Shortcode
        $rulesList.on('click', '.ucc-shortcode-display', function() {
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
        $rulesList.on('click', '.ucc-remove-rule', function() {
            if (confirm('Are you sure you want to remove this rule?')) {
                $(this).closest('.ucc-rule-item').fadeOut(300, function() {
                    $(this).remove();
                    // Re-index remaining rules
                    reindexRules();
                });
            }
        });

        // Toggle HTML Textarea
        $rulesList.on('click', '.ucc-toggle-html', function() {
            $(this).closest('.ucc-rule-item').find('.ucc-rule-html').toggleClass('active');
            $(this).toggleClass('active');
        });

        /**
         * Re-index rules after removal to ensure POST data is consistent
         */
        function reindexRules() {
            $rulesList.find('.ucc-rule-item').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('input, select, textarea').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        var newName = name.replace(/rules\[\d+\]/, 'rules[' + index + ']');
                        $(this).attr('name', newName);
                    }
                });
            });
            
            if ($rulesList.find('.ucc-rule-item').length === 0) {
                $rulesList.append('<p class="ucc-no-rules">No rules defined yet. Click "Add New Rule" to get started.</p>');
            }
        }
    });

})(jQuery);
