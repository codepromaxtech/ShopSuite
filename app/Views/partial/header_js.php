<?php
/**
 * @var array $config
 */
?>

<script type="text/javascript">
    // Live clock
    var clock_tick = function clock_tick() {
        setInterval('update_clock();', 1000);
    }

    var update_clock = function update_clock() {
        var clockElement = document.getElementById('liveclock');
        if (!clockElement) return;
        
        // Check if moment.js is loaded
        if (typeof moment !== 'undefined') {
            clockElement.innerHTML = moment().format("<?= dateformat_momentjs($config['dateformat'] . ' ' . $config['timeformat']) ?>");
        } else {
            // Fallback to regular Date if moment.js not loaded
            var now = new Date();
            clockElement.innerHTML = now.toLocaleString();
        }
    }

    // Start the clock after ensuring libraries are loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', clock_tick);
    } else {
        clock_tick();
    }

    // Configure Bootstrap Notify if available
    if (typeof $.notifyDefaults === 'function') {
        $.notifyDefaults({
            placement: {
                align: "<?= esc($config['notify_horizontal_position'], 'js') ?>",
                from: "<?= esc($config['notify_vertical_position'], 'js') ?>"
            }
        });
    }

    var cookie_name = "<?= esc(config('Cookie')->prefix, 'js') . esc(config('Security')->cookieName, 'js') ?>";

    var csrf_token = function() {
        return Cookies.get(cookie_name);
    };

    var csrf_form_base = function() {
        return {
            <?= esc(config('Security')->tokenName, 'js') ?>: function() {
                return csrf_token()
            }
        }
    };

    var setup_csrf_token = function() {
        $('input[name="<?= esc(config('Security')->tokenName, 'js') ?>"]').val(csrf_token());
    };

    var ajax = $.ajax;

    $.ajax = function() {
        var args = arguments[0];
        if (args['type'] && args['type'].toLowerCase() == 'post' && csrf_token()) {
            if (typeof args['data'] === 'string') {
                args['data'] += '&' + $.param(csrf_form_base());
            } else {
                args['data'] = $.extend(args['data'], csrf_form_base());
            }
        }

        return ajax.apply(this, arguments);
    };

    $(document).ajaxComplete(setup_csrf_token);
    $(document).ready(function() {
        $("#logout").click(function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= base_url('home/logout'); ?>",
                data: {
                    "<?= esc(config('Security')->tokenName, 'js'); ?>": csrf_token()
                },
                success: function() {
                    window.location.href = '<?= base_url(); ?>';
                },
                method: "POST"
            });
        });
    });

    var submit = $.fn.submit;

    $.fn.submit = function() {
        setup_csrf_token();
        submit.apply(this, arguments);
    };
</script>
