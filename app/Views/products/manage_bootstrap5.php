<?php
/**
 * Modern Bootstrap 5 Items Management View with Full Functionality
 * @var string $controller_name
 * @var string $table_headers
 * @var array $filters
 * @var array $stock_locations
 * @var int $stock_location
 * @var array $config
 */

use App\Models\Employee;
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.items'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#generate_barcodes').click(function() {
            window.open(
                'index.php/items/generateBarcodes/' + table_support.selected_ids().join(':'),
                '_blank'
            );
        });

        // When any filter is clicked and the dropdown window is closed
        $('#filters').on('hidden.bs.select', function(e) {
            table_support.refresh();
        });

        // Load the preset daterange picker
        <?= view('partial/daterangepicker') ?>
        // Set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?= date($config['dateformat'], mktime(0, 0, 0, 01, 01, 2010)) ?>");
        // Update the hidden inputs with the selected dates before submitting the search data
        var start_date = "<?= date('Y-m-d', mktime(0, 0, 0, 01, 01, 2010)) ?>";
        $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            table_support.refresh();
        });

        $("#stock_location").change(function() {
            table_support.refresh();
        });

        <?php
        echo view('partial/bootstrap_tables_locale');
        $employee = model(Employee::class);
        ?>

        table_support.init({
            employee_id: <?= $employee->get_logged_in_employee_info()->person_id ?>,
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'items.item_id',
            queryParams: function() {
                return $.extend(arguments[0], {
                    "start_date": start_date,
                    "end_date": end_date,
                    "stock_location": $("#stock_location").val(),
                    "filters": $("#filters").val()
                });
            },
            onLoadSuccess: function(response) {
                $('a.rollover').imgPreview({
                    imgCSS: {
                        width: 200
                    },
                    distanceFromCursor: {
                        top: 10,
                        left: -210
                    }
                })
            }
        });
    });
</script>

<!-- Title Bar -->
<div id="title_bar" class="mb-3 d-flex justify-content-end gap-2 print_hide">
    <button class="btn btn-info modal-dlg" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/csvImport" ?>" title="<?= lang('Items.import_items_csv') ?>">
        <i class="bi bi-upload me-2"></i><?= lang('Common.import_csv') ?>
    </button>
    <button class="btn btn-primary modal-dlg" data-btn-new="<?= lang('Common.new') ?>" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/view" ?>" title="<?= lang(ucfirst($controller_name) . '.new') ?>">
        <i class="bi bi-plus-circle me-2"></i><?= lang(ucfirst($controller_name) . '.new') ?>
    </button>
</div>

<!-- Toolbar with Filters -->
<div id="toolbar" class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <button id="delete" class="btn btn-danger print_hide">
                <i class="bi bi-trash me-2"></i><?= lang('Common.delete') ?>
            </button>
            <button id="bulk_edit" class="btn btn-warning modal-dlg print_hide" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "items/bulkEdit" ?>" title="<?= lang('Items.edit_multiple_items') ?>">
                <i class="bi bi-pencil me-2"></i><?= lang('Items.bulk_edit') ?>
            </button>
            <button id="generate_barcodes" class="btn btn-secondary print_hide" data-href="<?= "$controller_name/generateBarcodes" ?>" title="<?= lang('Items.generate_barcodes') ?>">
                <i class="bi bi-upc-scan me-2"></i><?= lang('Items.generate_barcodes') ?>
            </button>
            
            <?= form_input(['name' => 'daterangepicker', 'class' => 'form-control', 'id' => 'daterangepicker', 'style' => 'max-width: 250px']) ?>
            
            <?= form_multiselect('filters[]', $filters, [''], [
                'id'                        => 'filters',
                'class'                     => 'selectpicker show-menu-arrow',
                'data-none-selected-text'   => lang('Common.none_selected_text'),
                'data-selected-text-format' => 'count > 1',
                'data-style'                => 'btn-default',
                'data-width'                => 'fit'
            ]) ?>
            
            <?php
            if (count($stock_locations) > 1) {
                echo form_dropdown(
                    'stock_location',
                    $stock_locations,
                    $stock_location,
                    [
                        'id'         => 'stock_location',
                        'class'      => 'selectpicker show-menu-arrow',
                        'data-style' => 'btn-default',
                        'data-width' => 'fit'
                    ]
                );
            }
            ?>
        </div>
    </div>
</div>

<!-- Items Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div id="table_holder" class="table-responsive">
            <table id="table"></table>
        </div>
    </div>
</div>

<?= view('layouts/bootstrap5_footer') ?>
