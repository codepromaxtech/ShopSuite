<?php

namespace App\Models\Reports;

class Summary_sales extends Summary_report
{
    /**
     * @return array[]
     */
    protected function _get_data_columns(): array
    {
        $columns = [
            ['sale_date' => lang('Reports.date'), 'sortable' => false],
            ['sales'     => lang('Reports.sales'), 'sorter' => 'number_sorter']
        ];
        
        // Add quantity column if not hidden (check request or stored inputs)
        // Note: This is for legacy display; column exclusion happens in _select
        $columns[] = ['quantity'  => lang('Reports.quantity'), 'sorter' => 'number_sorter'];
        
        $columns = array_merge($columns, [
            ['subtotal'  => lang('Reports.subtotal'), 'sorter' => 'number_sorter'],
            ['tax'       => lang('Reports.tax'), 'sorter' => 'number_sorter'],
            ['total'     => lang('Reports.total'), 'sorter' => 'number_sorter'],
            ['cost'      => lang('Reports.cost'), 'sorter' => 'number_sorter'],
            ['profit'    => lang('Reports.profit'), 'sorter' => 'number_sorter']
        ]);
        
        return $columns;
    }

    /**
     * @param array $inputs
     * @param object $builder
     * @return void
     */
    protected function _select(array $inputs, object &$builder): void    // TODO: hungarian notation
    {
        parent::_select($inputs, $builder);    // TODO: hungarian notation

        // Build SELECT with proper column order: date, sales count, quantity
        $select = 'DATE(sales.sale_time) AS sale_date, ';
        $select .= 'COUNT(DISTINCT sales.sale_id) AS sales';
        
        // Only add quantity if not explicitly hidden
        if (!isset($inputs['hide_quantity']) || !$inputs['hide_quantity']) {
            $select .= ', SUM(sales_items.quantity_purchased) AS quantity_purchased';
        }
        
        $builder->select($select);
    }

    /**
     * @param object $builder
     * @return void
     */
    protected function _group_order(object &$builder): void    // TODO: hungarian notation
    {
        $builder->groupBy('sale_date');
        $builder->orderBy('sale_date');
    }
}
