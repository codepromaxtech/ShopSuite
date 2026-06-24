<?php

namespace app\Libraries;

use App\Models\Customer;
use App\Models\Item_taxes;
use App\Models\Enums\Rounding_mode;
use App\Models\Sale;
use App\Models\Tax;
use App\Models\Tax_category;
use App\Models\Tax_code;
use App\Models\Tax_jurisdiction;
use App\Libraries\Sale_lib;
use Config\ShopSuite;

/**
 * Tax library
 *
 * Library with utilities to manage taxes
 */
class Tax_lib
{
    public const TAX_TYPE_EXCLUDED = '1';    // TODO: These constants need to be moved to constants.php
    public const TAX_TYPE_INCLUDED = '0';
    private Sale_lib $sale_lib;
    private Customer $customer;
    private Item_taxes $item_taxes;
    private Sale $sale;
    private Tax $tax;
    private Tax_category $tax_category;
    private Tax_code $tax_code;
    private Tax_jurisdiction $tax_jurisdiction;
    private array $config;

    public function __construct()
    {
        $this->sale_lib = new Sale_lib();

        $this->customer = model(Customer::class);
        $this->item_taxes = model(Item_taxes::class);
        $this->sale = model(Sale::class);
        $this->tax = model(Tax::class);
        $this->tax_category = model(Tax_category::class);
        $this->tax_code = model(Tax_code::class);
        $this->tax_jurisdiction = model(Tax_jurisdiction::class);
        $this->config = config(ShopSuite::class)->settings;
    }

    /**
     * @return array
     */
    public function get_tax_types(): array
    {
        return [
            Tax_lib::TAX_TYPE_EXCLUDED => lang('Taxes.tax_excluded'),
            Tax_lib::TAX_TYPE_INCLUDED => lang('Taxes.tax_included')
        ];
    }

    /**
     * Compute the tax basis and returns the tax amount
     */
    public function get_item_sales_tax(string $quantity, string $price, string $discount, int $discount_type, string $tax_percentage, int $rounding_code): string    // TODO: It appears this function is never called in the code.
    {
        $decimals = tax_decimals();

        // The tax basis should be returned to the currency scale
        $tax_basis = $this->sale_lib->get_item_total($quantity, $price, $discount, $discount_type, true);

        return $this->get_tax_for_amount($tax_basis, $tax_percentage, $rounding_code, $decimals);
    }

    /**
     * Computes the item level sales tax amount for a given tax basis
     */
    public function get_tax_for_amount(string $tax_basis, string $tax_percentage, int $rounding_mode, int $decimals): string
    {
        $tax_amount = bcmul($tax_basis, bcdiv($tax_percentage, '100'));

        return rounding_mode::round_number($rounding_mode, $tax_amount, $decimals);
    }

    /**
     * Compute taxes for all items in the cart
     */
    public function get_taxes(array &$cart, int $sale_id = NEW_ENTRY): array
    {
        $register_mode = $this->sale_lib->get_mode();
        $tax_decimals = tax_decimals();
        $customer_id = $this->sale_lib->get_customer();
        $customer_info = $this->customer->get_info($customer_id);
        $taxes = [];
        $item_taxes = [];

        // Charge sales tax if customer is not selected (walk-in) or customer is flagged as taxable
        if ($customer_id == NEW_ENTRY || $customer_info->taxable) {
            foreach ($cart as $line => $item) {
                $taxed = false;

                if (!$this->config['use_destination_based_tax']) {
                    // Start of current Base System tax calculations

                    $tax_info = ($sale_id == NEW_ENTRY) ? $this->item_taxes->get_info($item['item_id']) : $this->sale->get_sales_item_taxes($sale_id, $item['item_id']);

                    $tax_group_sequence = 0;

                    foreach ($tax_info as $tax) {
                        // This computes tax for each line item and adds it to the tax type total
                        $tax_basis = $this->sale_lib->get_item_total($item['quantity'], $item['price'], $item['discount'], $item['discount_type'], true);
                        $tax_amount = '0.0';

                        if ($this->config['tax_included']) {
                            $tax_type = Tax_lib::TAX_TYPE_INCLUDED;
                            $tax_amount = $this->get_included_tax($item['quantity'], $item['price'], $item['discount'], $item['discount_type'], $tax['percent']);
                        } else {
                            $tax_type = Tax_lib::TAX_TYPE_EXCLUDED;
                            $tax_amount = $this->get_tax_for_amount($tax_basis, $tax['percent'], Rounding_mode::HALF_UP, $tax_decimals);
                        }

                        if ($tax_amount <> 0) {
                            $tax_group_sequence++;
                            $this->update_taxes($taxes, $tax_type, $tax['name'], $tax['percent'], $tax_basis, $tax_amount, $tax_group_sequence, Rounding_mode::HALF_UP, NEW_ENTRY, $tax['name']);
                            $tax_group_sequence++;
                            $taxed = true;
                        }

                        $items_taxes_detail = [];
                        $items_taxes_detail['item_id'] = $item['item_id'];
                        $items_taxes_detail['line'] = $item['line'];
                        $items_taxes_detail['name'] = $tax['name'];
                        $items_taxes_detail['percent'] = $tax['percent'];
                        $items_taxes_detail['tax_type'] = $tax_type;
                        $items_taxes_detail['rounding_code'] = Rounding_mode::HALF_UP;
                        $items_taxes_detail['cascade_sequence'] = 0;
                        $items_taxes_detail['item_tax_amount'] = $tax_amount;
                        $items_taxes_detail['sales_tax_code_id'] = null;
                        $items_taxes_detail['jurisdiction_id'] = null;
                        $items_taxes_detail['tax_category_id'] = null;

                        $item_taxes[] = $items_taxes_detail;
                    }
                } else {
                    // Start of destination based tax calculations
                    if ($item['tax_category_id'] == null) {    // TODO: === ?
                        $item['tax_category_id'] = $this->config['default_tax_category'];
                    }

                    $taxed = $this->apply_destination_tax($item, $customer_info->city, $customer_info->state, $customer_info->sales_tax_code_id, $register_mode, 0, $taxes, $item_taxes, $item['line']);
                }

                $cart[$line]['taxed_flag'] = $taxed ? lang('Sales.taxed_ind') : lang('Sales.nontaxed_ind');
            }
            $this->round_taxes($taxes);
        }

        $tax_details = [];
        $tax_details[0] = $taxes;
        $tax_details[1] = $item_taxes;

        return $tax_details;
    }

    /**
     * @param string $quantity
     * @param string $price
     * @param string $discount_percentage
     * @param int $discount_type
     * @param string $tax_percentage
     * @param $tax_decimal
     * @param $rounding_code
     * @return string
     */
    public function get_included_tax(string $quantity, string $price, string $discount_percentage, int $discount_type, string $tax_percentage): string
    {
        $item_total = $this->sale_lib->get_item_total($quantity, $price, $discount_percentage, $discount_type, true);
        $tax_fraction = bcdiv(bcadd('100', $tax_percentage), '100');
        $price_tax_excl = bcdiv($item_total, $tax_fraction);
        return bcsub($item_total, $price_tax_excl);
    }

    /**
     * Updates the sales_tax array which is later saved to the `sales_taxes` table and used for printing taxes on receipts and invoices
     */
    public function update_taxes(array &$taxes, string $tax_type, string $tax_group, string $tax_rate, string $tax_basis, string $item_tax_amount, int $tax_group_sequence, int $rounding_code, int $sale_id, string $name = '', ?int $tax_code_id = null, ?int $jurisdiction_id = null, ?int $tax_category_id = null): void
    {
        $tax_group_index = $this->clean('X' . (float)$tax_rate . '% ' . $tax_group);    // TODO: Not sure we should be casting to a float here.  The clean() function takes a string, so it just gets converted back to a string and there's risk of inaccuracies in the value displayed.

        if (!array_key_exists($tax_group_index, $taxes)) {
            $insertkey = $tax_group_index;    // TODO: this variable does not follow naming conventions.

            $tax = [
                $insertkey => [
                    'sale_id'           => $sale_id,
                    'tax_type'          => $tax_type,
                    'tax_group'         => $tax_group,
                    'sale_tax_basis'    => $tax_basis,
                    'sale_tax_amount'   => $item_tax_amount,
                    'print_sequence'    => $tax_group_sequence,
                    'name'              => $name,
                    'tax_rate'          => $tax_rate,
                    'sales_tax_code_id' => $tax_code_id,
                    'jurisdiction_id'   => $jurisdiction_id,
                    'tax_category_id'   => $tax_category_id,
                    'rounding_code'     => $rounding_code
                ]
            ];

            // Add to existing array
            $taxes += $tax;
        } else {
            // Important: the sales amounts are accumulated for the group at the maximum configurable scale value of 4
            // but the scale will in reality be the scale specified by the tax_decimal configuration value  used for sales_items_taxes
            $taxes[$tax_group_index]['sale_tax_basis'] = bcadd($taxes[$tax_group_index]['sale_tax_basis'], $tax_basis, 4);
            $taxes[$tax_group_index]['sale_tax_amount'] = bcadd($taxes[$tax_group_index]['sale_tax_amount'], $item_tax_amount, 4);
        }
    }

    /**
     * If invoice taxing (as opposed to invoice_item_taxing) rules apply then recalculate the sales tax after tax group totals are final
     * This is currently used ONLY for the original sales tax migration.
     */
    public function apply_invoice_taxing(array &$taxes): void
    {
        if (!empty($taxes)) {
            $sort = [];
            foreach ($taxes as $k => $v) {
                $sort['print_sequence'][$k] = $v['print_sequence'];
            }
            array_multisort($sort['print_sequence'], SORT_ASC, $taxes);
        }

        $decimals = totals_decimals();

        foreach ($taxes as $row_number => $tax) {
            $taxes[$row_number]['sale_tax_amount'] = $this->get_tax_for_amount($tax['sale_tax_basis'], $tax['tax_rate'], $tax['rounding_code'], $decimals);
        }
    }

    /**
     * Apply rounding rules to the accumulated sales tax amounts
     */
    public function round_taxes(array &$taxes): void
    {
        if (!empty($taxes)) {
            $sort = [];
            foreach ($taxes as $k => $v) {
                $sort['print_sequence'][$k] = $v['print_sequence'];
            }
            array_multisort($sort['print_sequence'], SORT_ASC, $taxes);
        }

        // If tax included then round decimal to tax decimals, otherwise round it to currency_decimals
        $decimals = $this->config['tax_included'] ? tax_decimals() : totals_decimals();

        foreach ($taxes as $row_number => $sales_tax) {
            $tax_amount = $sales_tax['sale_tax_amount'];
            $rounding_code = $sales_tax['rounding_code'];
            $rounded_tax_amount = $tax_amount;

            switch ($rounding_code) {
                case Rounding_mode::HALF_UP:
                case Rounding_mode::HALF_ODD:
                    $rounded_tax_amount = round($tax_amount, $decimals, PHP_ROUND_HALF_UP);
                    break;
                case Rounding_mode::HALF_DOWN:
                    $rounded_tax_amount = round($tax_amount, $decimals, PHP_ROUND_HALF_DOWN);
                    break;
                case Rounding_mode::HALF_EVEN:
                    $rounded_tax_amount = round($tax_amount, $decimals, PHP_ROUND_HALF_EVEN);
                    break;
                case Rounding_mode::ROUND_UP:
                    $fig = (int)str_pad('1', $decimals, '0');
                    $rounded_tax_amount = ceil($tax_amount * $fig) / $fig;
                    break;
                case Rounding_mode::ROUND_DOWN:
                    $fig = (int)str_pad('1', $decimals, '0');
                    $rounded_tax_amount = floor($tax_amount * $fig) / $fig;
                    break;
                case Rounding_mode::HALF_FIVE:
                    $rounded_tax_amount = round($tax_amount / 5) * 5;
                    break;
            }

            $taxes[$row_number]['sale_tax_amount'] = $rounded_tax_amount;
        }
    }

    /**
     * Determine the applicable tax code and then determine the tax amount to be applied.
     * If a tax amount was identified then accumulate into the sales_taxes array
     */
    public function apply_destination_tax(array &$item, string $city, string $state, int $sales_tax_code_id, string $register_mode, int $sale_id, array &$taxes, array &$item_taxes, int $line): bool
    {
        $taxed = false;

        $tax_code_id = $this->get_applicable_tax_code($register_mode, $city, $state, $sales_tax_code_id);

        if ($tax_code_id != NEW_ENTRY && $item['price'] != 0) {

            $tax_definition = $this->tax->get_taxes($tax_code_id, $item['tax_category_id']);

            $tax_basis = $this->sale_lib->get_item_total($item['quantity'], $item['price'], $item['discount'], $item['discount_type'], true);

            $last_cascade_sequence = 0;
            $cascade_tax_amount = '0.0';

            foreach ($tax_definition as $tax) {
                $cascade_sequence = $tax['cascade_sequence'];
                if ($cascade_sequence != $last_cascade_sequence) {
                    $last_cascade_sequence = $cascade_sequence;
                    $tax_basis = bcadd($tax_basis, $cascade_tax_amount);
                }

                $tax_rate = $tax['tax_rate'];
                $rounding_code = $tax['tax_rounding_code'];

                // This computes tax for each line item and adds it to the tax type total
                $tax_type = $tax['tax_type'];

                if ($tax_type == Tax_lib::TAX_TYPE_INCLUDED) {
                    $tax_amount = $this->get_included_tax($item['quantity'], $item['price'], $item['discount'], $item['discount_type'], $tax_rate);
                } else {
                    $tax_amount = $this->get_tax_for_amount($tax_basis, $tax_rate, $rounding_code, $tax_decimals);
                    $cascade_tax_amount = bcadd($cascade_tax_amount, $tax_amount);
                }

                if ($tax_amount != 0) {
                    $taxed = true;
                    $this->update_taxes($taxes, $tax_type, $tax['tax_group'], $tax_rate, $tax_basis, $tax_amount, $tax['tax_group_sequence'], $rounding_code, $sale_id, $tax['tax_group'], $tax_code_id, $tax['rate_jurisdiction_id'], $item['tax_category_id']);
                }

                $item_taxes_detail = [];
                $item_taxes_detail['line'] = $line;
                $item_taxes_detail['item_id'] = $item['item_id'];
                $item_taxes_detail['name'] = $tax['tax_group'];
                $item_taxes_detail['percent'] = $tax['tax_rate'];
                $item_taxes_detail['tax_type'] = $tax_type;
                $item_taxes_detail['rounding_code'] = $rounding_code;
                $item_taxes_detail['cascade_sequence'] = $cascade_sequence;
                $item_taxes_detail['item_tax_amount'] = $tax_amount;
                $item_taxes_detail['sales_tax_code_id'] = $tax_code_id;
                $item_taxes_detail['jurisdiction_id'] = $tax['rate_jurisdiction_id'];
                $item_taxes_detail['tax_category_id'] = $tax['rate_tax_category_id'];
                $item_taxes_detail['tax_group_sequence'] = $tax['tax_group_sequence'];

                $item_taxes[] = $item_taxes_detail;
            }
        }

        return $taxed;
    }

    /**
     * @param string $register_mode
     * @param string $city
     * @param string $state
     * @param int $sales_tax_code_id
     * @return int
     */
    public function get_applicable_tax_code(string $register_mode, string $city, string $state, int $sales_tax_code_id): int
    {
        if ($register_mode == 'sale') {
            $sales_tax_code_id = $this->config['default_tax_code']; // Overrides customer assigned code
        } else {
            if ($sales_tax_code_id == null || $sales_tax_code_id == 0) {
                $sales_tax_code_id = $this->tax_code->get_sales_tax_code($city, $state);

                if ($sales_tax_code_id == null || $sales_tax_code_id == 0) {
                    $sales_tax_code_id = $this->config['default_tax_code']; // Overrides customer assigned code
                }
            }
        }

        return $sales_tax_code_id;
    }

    /**
     * @param string $string
     * @return string
     */
    public function clean(string $rawString): string
    {
        $rawString = str_replace(' ', '-', $rawString); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $rawString); // Removes special chars.
    }

    /**
     * @return array
     */
    public function get_tax_code_options(): array
    {
        $tax_codes = $this->tax_code->get_all()->getResultArray();
        $tax_code_options = [];
        $tax_code_options[''] = '';

        foreach ($tax_codes as $tax_code) {
            $taxCodeId = $tax_code['tax_code_id'];
            $taxCodeName = $tax_code['tax_code_name'];
            $tax_code_options[$taxCodeId] = $taxCodeName;
        }

        return $tax_code_options;
    }

    /**
     * @return array
     */
    public function get_tax_jurisdiction_options(): array
    {
        $tax_jurisdictions = $this->tax_jurisdiction->get_all()->getResultArray();
        $tax_jurisdiction_options = [];
        $tax_jurisdiction_options[0] = '';

        foreach ($tax_jurisdictions as $tax_jurisdiction) {
            $jurisdictionId = $tax_jurisdiction['jurisdiction_id'];
            $jurisdictionName = $tax_jurisdiction['jurisdiction_name'];
            $tax_jurisdiction_options[$jurisdictionId] = $jurisdictionName;
        }

        return $tax_jurisdiction_options;
    }

    /**
     * @return array
     */
    public function get_tax_category_options(): array
    {
        $tax_categories = $this->tax_category->get_all()->getResultArray();
        $tax_category_options = [];
        $tax_category_options[0] = '';

        foreach ($tax_categories as $tax_category) {
            $categoryId = $tax_category['tax_category_id'];
            $categoryName = $tax_category['tax_category'];

            $tax_category_options[$categoryId] = $categoryName;
        }

        return $tax_category_options;
    }

    /**
     * @param string $selected_tax_type
     * @return string
     */
    public function get_tax_type_options(string $selected_tax_type): string
    {
        $selected = 'selected=\"selected\" ';

        $excludedSelected = '';
        $includedSelected = '';

        if ($selected_tax_type === Tax_lib::TAX_TYPE_EXCLUDED) {
            $excludedSelected = $selected;
        } elseif ($selected_tax_type === Tax_lib::TAX_TYPE_INCLUDED) {
            $includedSelected = $selected;
        }

        return '<option value=\"' . Tax_lib::TAX_TYPE_EXCLUDED . '\" ' . $excludedSelected . '> ' . lang('Taxes.sales_tax') . '</option>'
            . '<option value=\"' . Tax_lib::TAX_TYPE_INCLUDED . '\" ' . $includedSelected . '> ' . lang('Taxes.vat_tax') . '</option>';
    }
}
