/**
 * Theme Settings - Admin JavaScript
 */

jQuery(document).ready(function($) {
    
    // Color Picker
    $('.dst-color-picker').wpColorPicker();
    
    // Image Upload
    $('.dst-image-upload').each(function() {
        var $container = $(this);
        var $input = $container.find('input[type="hidden"]');
        var $preview = $container.find('.dst-image-preview');
        var $uploadBtn = $container.find('.dst-upload-btn');
        var $removeBtn = $container.find('.dst-remove-btn');
        
        // Upload
        $uploadBtn.on('click', function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'انتخاب تصویر',
                button: { text: 'انتخاب' },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $input.val(attachment.url);
                $preview.html('<img src="' + attachment.url + '" alt="">');
                $removeBtn.show();
            });
            
            frame.open();
        });
        
        // Remove
        $removeBtn.on('click', function(e) {
            e.preventDefault();
            $input.val('');
            $preview.html('');
            $(this).hide();
        });
    });
    
    // Code Editor Enhancement
    $('textarea.code').each(function() {
        var $textarea = $(this);
        
        // Tab key support
        $textarea.on('keydown', function(e) {
            if (e.keyCode === 9) { // Tab
                e.preventDefault();
                var start = this.selectionStart;
                var end = this.selectionEnd;
                var value = $(this).val();
                
                $(this).val(value.substring(0, start) + '    ' + value.substring(end));
                this.selectionStart = this.selectionEnd = start + 4;
            }
        });
    });
    
    // Confirm before leaving with unsaved changes
    var formChanged = false;
    
    $('.dst-theme-settings-wrap form').on('change', 'input, select, textarea', function() {
        formChanged = true;
    });
    
    $('.dst-theme-settings-wrap form').on('submit', function() {
        formChanged = false;
    });
    
    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'تغییرات ذخیره نشده‌ای دارید. آیا مطمئن هستید؟';
        }
    });
    
});
