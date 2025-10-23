/**
 * Legacy Support - Complete Compatibility Layer
 * Ensures all old manage_tables.js functionality works
 */

// ===================================================================
// DIALOG SUPPORT (from old manage_tables.js)
// ===================================================================

(function(dialog_support, $) {
    var btn_id, dialog_ref;

    var hide = function() {
        dialog_ref && dialog_ref.close();
    };

    var clicked_id = function() {
        return btn_id;
    };

    var submit = function(button_id) {
        return function(dlog_ref) {
            const form = $('form', dlog_ref.$modalBody).first();
            const validator = form.data('validator');
            const submitted = validator && validator.formSubmitted;

            btn_id = button_id;
            dialog_ref = dlog_ref;

            if (button_id == 'submit' && (!submitted && btn_id != "btnNew")) {
                form.submit();
                validator.valid() && $('#submit').prop('disabled', true).css('opacity', 0.5);
            }
            return false;
        }
    };

    var button_class = {
        'submit': 'btn-primary',
        'delete': 'btn-danger'
    };

    var init = function(selector) {
        var buttons = function(event) {
            var buttons = [];
            var dialog_class = 'modal-dlg';
            $.each($(this).attr('class').split(/\s+/), function(classIndex, className) {
                var width_class = className.split("modal-dlg-");
                if (width_class && width_class.length > 1) {
                    dialog_class = className;
                }
            });

            var has_new_btn = "btnNew" in $(this).data();
            $.each($(this).data(), function(name, value) {
                var btn_class = name.split("btn");
                if (btn_class && btn_class.length > 1) {
                    var btn_name = btn_class[1].toLowerCase();
                    var is_submit = btn_name == 'submit';
                    var is_new = btn_name === 'new';
                    var is_enter = has_new_btn ? is_new : is_submit;
                    buttons.push({
                        id: btn_name,
                        label: value,
                        cssClass: button_class[btn_name],
                        hotkey: is_enter ? 13 : undefined,
                        action: submit(btn_name)
                    });
                }
            });

            !buttons.length && buttons.push({
                id: 'close',
                label: lang && lang.line ? lang.line('common_close') : 'Close',
                cssClass: 'btn-primary',
                action: function(dialog_ref) {
                    dialog_ref.close();
                }
            });
            
            return {
                buttons: buttons.sort(function(a, b) {
                    return ($(b).text()) < ($(a).text()) ? -1 : 1;
                }),
                cssClass: dialog_class
            };
        };

        $(selector).each(function(index, $element) {
            return $(selector).off('click').on('click', function(event) {
                var $link = $(event.target);
                $link = !$link.is("a, button") ? $link.parents("a, button") : $link;
                
                BootstrapDialog.show($.extend({
                    title: $link.attr('title'),
                    message: (function() {
                        var node = $('<div></div>');
                        $.get($link.attr('href') || $link.data('href'), function(data) {
                            node.html(data);
                        });
                        return node;
                    })
                }, buttons.call(this, event)));

                return false;
            });
        });
    };

    $.extend(dialog_support, {
        init: init,
        submit: submit,
        hide: hide,
        clicked_id: clicked_id
    });

})(window.dialog_support = window.dialog_support || {}, jQuery);

// ===================================================================
// FORM SUPPORT (from old manage_tables.js)
// ===================================================================

(function(form_support, $) {

    form_support.error = {
        errorClass: "has-error",
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        highlight: function(e) {
            $(e).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(e) {
            $(e).closest('.form-group').removeClass('has-error');
        }
    };

    form_support.handler = $.extend({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                success: function(response) {
                    if (typeof showNotification === 'function') {
                        showNotification(response.message, response.success ? 'success' : 'error');
                    } else {
                        $.notify(response.message, {
                            type: response.success ? 'success' : 'danger'
                        });
                    }
                },
                dataType: 'json'
            });
        },
        rules: {},
        messages: {}
    }, form_support.error);

})(window.form_support = window.form_support || {}, jQuery);

console.log('✨ Legacy Support Loaded - dialog_support & form_support available');
