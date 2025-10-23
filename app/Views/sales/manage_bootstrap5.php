<?php
/**
 * Modern Bootstrap 5 Sales Management View with Full Functionality
 * @var string $controller_name
 * @var string $table_headers
 * @var array $filters
 * @var array $selected_filters
 * @var array $config
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.sales'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        // When any filter is clicked and the dropdown window is closed
        $('#filters').on('hidden.bs.select', function(e) {
            table_support.refresh();
        });

        // Load the preset datarange picker
        <?= view('partial/daterangepicker') ?>

        $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            table_support.refresh();
        });

        <?= view('partial/bootstrap_tables_locale') ?>

        table_support.query_params = function() {
            return {
                "start_date": start_date,
                "end_date": end_date,
                "filters": $("#filters").val()
            }
        };

        table_support.init({
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'sale_id',
            onLoadSuccess: function(response) {
                if ($("#table tbody tr").length > 1) {
                    $("#payment_summary").html(response.payment_summary);
                    $("#table tbody tr:last td:first").html("");
                    $("#table tbody tr:last").css('font-weight', 'bold');
                }
            },
            queryParams: function() {
                return $.extend(arguments[0], table_support.query_params());
            },
            columns: {
                'invoice': {
                    align: 'center'
                }
            }
        });
    });
</script>

<?= view('partial/print_receipt', ['print_after_sale' => false, 'selected_printer' => 'takings_printer']) ?>

<!-- Title Bar -->
<div id="title_bar" class="mb-3 d-flex justify-content-between align-items-center print_hide">
    <h2 class="mb-0 fw-bold">
        <i class="bi bi-cart-check"></i>
        <?= lang('Module.sales') ?>
    </h2>
    <div>
        <button onclick="javascript:printdoc()" class="btn btn-info me-2">
            <i class="bi bi-printer me-2"></i><?= lang('Common.print') ?>
        </button>
        <?= anchor("sales", '<i class="bi bi-cart-plus me-2"></i>' . lang('Sales.register'), ['class' => 'btn btn-success', 'id' => 'show_sales_button']) ?>
    </div>
</div>

<!-- Toolbar with Filters -->
<div id="toolbar" class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <button id="delete" class="btn btn-danger print_hide">
                <i class="bi bi-trash me-2"></i><?= lang('Common.delete') ?>
            </button>
            
            <?= form_input(['name' => 'daterangepicker', 'class' => 'form-control', 'id' => 'daterangepicker', 'style' => 'max-width: 250px']) ?>
            
            <?= form_multiselect('filters[]', $filters, $selected_filters, [
                'id'                        => 'filters',
                'data-none-selected-text'   => lang('Common.none_selected_text'),
                'class'                     => 'selectpicker show-menu-arrow',
                'data-selected-text-format' => 'count > 1',
                'data-style'                => 'btn-default',
                'data-width'                => 'fit'
            ]) ?>
        </div>
    </div>
</div>

<!-- Sales Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div id="table_holder" class="table-responsive">
            <table id="table"></table>
        </div>
    </div>
</div>

<!-- Payment Summary -->
<div id="payment_summary" class="mt-3"></div>


<?= view('layouts/bootstrap5_footer') ?>
