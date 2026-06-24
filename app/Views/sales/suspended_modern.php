<?php
/**
 * Modern Suspended Sales View
 * @var array $suspended_sales
 * @var array $config
 */

use App\Models\Employee;
use App\Models\Customer;
$dinner_table = model(Dinner_table::class);

echo view('layouts/modern_header', ['title' => 'Suspended Sales', 'extra_css' => ['css/pos-compact.min.css']]);
?>

<div class="page-container">
    <div class="suspended-page-header">
        <div>
            <h1 class="suspended-page-title">Suspended Sales</h1>
            <p class="suspended-page-subtitle">View and restore suspended sales</p>
        </div>
        <a href="<?= base_url('sales') ?>" class="btn btn-outline">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to POS
        </a>
    </div>

    <?php if (empty($suspended_sales)): ?>
        <!-- Empty State -->
        <div class="suspended-empty">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3>No Suspended Sales</h3>
            <p>There are no suspended sales at the moment</p>
            <a href="<?= base_url('sales') ?>" class="btn btn-primary">
                Go to POS Register
            </a>
        </div>
    <?php else: ?>
        <!-- Sales Cards Grid -->
        <div class="suspended-grid">
            <?php foreach ($suspended_sales as $index => $suspended_sale): ?>
                <?php
                // Get customer info
                $customer_name = '';
                if (isset($suspended_sale['customer_id'])) {
                    $customer = model(Customer::class);
                    $customer_data = $customer->get_info($suspended_sale['customer_id']);
                    $customer_name = esc("$customer_data->first_name $customer_data->last_name");
                }
                
                // Get employee info
                $employee_name = '';
                if (isset($suspended_sale['employee_id'])) {
                    $employee = model(Employee::class);
                    $employee_data = $employee->get_info($suspended_sale['employee_id']);
                    $employee_name = esc("$employee_data->first_name $employee_data->last_name");
                }
                
                // Get table name if enabled
                $table_name = '';
                if ($config['dinner_table_enable'] && isset($suspended_sale['dinner_table_id'])) {
                    $table_name = esc($dinner_table->get_name($suspended_sale['dinner_table_id']));
                }
                ?>
                
                <div class="suspended-card" style="animation-delay: <?= $index * 0.05 ?>s" onclick="unsuspendSale(<?= $suspended_sale['sale_id'] ?>)">
                    <!-- Card Header -->
                    <div class="suspended-card-header">
                        <div>
                            <div class="suspended-card-id">#<?= $suspended_sale['doc_id'] ?></div>
                            <div class="suspended-card-time">
                                <?= date($config['dateformat'] . ' ' . $config['timeformat'], strtotime($suspended_sale['sale_time'])) ?>
                            </div>
                        </div>
                        <span class="suspended-badge">Suspended</span>
                    </div>

                    <!-- Card Content -->
                    <div>
                        <!-- Customer -->
                        <div class="suspended-card-meta">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span><?= !empty($customer_name) ? $customer_name : 'Walk-in Customer' ?></span>
                        </div>

                        <!-- Employee -->
                        <?php if (!empty($employee_name)): ?>
                        <div class="suspended-card-meta">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span><?= $employee_name ?></span>
                        </div>
                        <?php endif; ?>

                        <!-- Table -->
                        <?php if (!empty($table_name)): ?>
                        <div class="suspended-card-meta">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span><?= $table_name ?></span>
                        </div>
                        <?php endif; ?>

                        <!-- Comments -->
                        <?php if (!empty($suspended_sale['comment'])): ?>
                        <div class="suspended-card-comment">
                            <div class="suspended-card-comment-label">Comment:</div>
                            <div class="suspended-card-comment-text"><?= esc($suspended_sale['comment']) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Actions -->
                    <div class="suspended-card-actions">
                        <button type="button" onclick="event.stopPropagation(); unsuspendSale(<?= $suspended_sale['sale_id'] ?>)" class="btn btn-primary flex-1">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Resume Sale
                        </button>
                        <button type="button" onclick="event.stopPropagation(); deleteSuspendedSale(<?= $suspended_sale['sale_id'] ?>)" class="btn btn-outline btn-delete-suspended">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function unsuspendSale(saleId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("sales/unsuspend") ?>';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'suspended_sale_id';
    input.value = saleId;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}

function deleteSuspendedSale(saleId) {
    if (confirm('Are you sure you want to delete this suspended sale? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("sales/discardSuspendedSale") ?>';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'suspended_sale_id';
        input.value = saleId;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
