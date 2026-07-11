<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 *
 * ShopSuite — CI4 Explicit Routes
 * All routes use explicit HTTP verbs (get/post). No add() or auto-routing.
 */

// Load the system's routing file first
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);  // CI4: explicit routes only

// ============================================
// AUTH
// ============================================
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login', 'Login::index');
$routes->get('login/logout', 'Login::getLogout');

// ============================================
// HOME / DASHBOARD
// ============================================
$routes->get('home', 'Home::getIndex');
$routes->get('home/logout', 'Home::getLogout');
$routes->get('home/user_settings', 'Home::getUserSettings');
$routes->get('home/debug_sidebar', 'Home::getDebugSidebar');
$routes->get('home/changePassword/(:num)', 'Home::getChangePassword/$1');
$routes->post('home/savePassword', 'Home::postSavePassword');
$routes->post('home/save_password', 'Home::postSavePassword');
$routes->post('home/save/(:segment)', 'Home::postSave/$1');

// ============================================
// NO ACCESS
// ============================================
$routes->get('no_access/index/(:segment)', 'No_access::index/$1');
$routes->get('no_access/index/(:segment)/(:segment)', 'No_access::index/$1/$2');

// ============================================
// NOTIFICATIONS
// ============================================
$routes->get('notifications/get_unread', 'Notifications::get_unread');
$routes->post('notifications/mark_read', 'Notifications::mark_read');
$routes->post('notifications/mark_all_read', 'Notifications::mark_all_read');

// ============================================
// POS / SALES — GET
// ============================================
$routes->get('sales', 'Sales::getIndex');
$routes->get('sales/add', 'Sales::getIndex'); // Fallback for accidental GET redirects
$routes->get('sales/register', 'Sales::getIndex');
$routes->get('sales/manage', 'Sales::getManage');
$routes->get('sales/suspended', 'Sales::getSuspended');
$routes->get('sales/returnExchange', 'Sales::getReturnExchange');
$routes->get('sales/salesKeyboardHelp', 'Sales::getSalesKeyboardHelp');
$routes->get('sales/selectCustomer', 'Sales::getSelectCustomer');
$routes->get('sales/itemSearch', 'Sales::getItemSearch');
$routes->get('sales/receipt/(:num)', 'Sales::getReceipt/$1');
$routes->get('sales/edit/(:num)', 'Sales::getEdit/$1');
$routes->get('sales/invoice/(:num)', 'Sales::getInvoice/$1');
$routes->get('sales/discard_suspended_sale', 'Sales::getDiscardSuspendedSale');
$routes->get('sales/discardSuspendedSale', 'Sales::getDiscardSuspendedSale');
$routes->get('sales/row/(:num)', 'Sales::getRow/$1');
$routes->get('sales/search', 'Sales::getSearch');
$routes->get('sales/searchForReturn', 'Sales::getSearchForReturn');
$routes->get('sales/loadSaleForReturn/(:num)', 'Sales::getLoadSaleForReturn/$1');

// ============================================
// POS / SALES — POST
// ============================================
$routes->post('sales/add', 'Sales::postAdd');
$routes->post('sales/addPayment', 'Sales::postAddPayment');
$routes->post('sales/complete', 'Sales::postComplete');
$routes->post('sales/cancel', 'Sales::postCancel');
$routes->post('sales/suspend', 'Sales::postSuspend');
$routes->post('sales/unsuspend/(:num)', 'Sales::postUnsuspend/$1');
$routes->post('sales/changeMode', 'Sales::postChangeMode');
$routes->post('sales/editItem/(:num)', 'Sales::postEditItem/$1');
$routes->post('sales/deleteItem/(:num)', 'Sales::postDeleteItem/$1');
$routes->post('sales/deletePayment/(:segment)', 'Sales::postDeletePayment/$1');
$routes->post('sales/removeCustomer', 'Sales::postRemoveCustomer');
$routes->post('sales/selectCustomer', 'Sales::postSelectCustomer');
$routes->post('sales/setComment', 'Sales::postSetComment');
$routes->post('sales/setPaymentType', 'Sales::postSetPaymentType');
$routes->post('sales/setInvoiceNumber', 'Sales::postSetInvoiceNumber');
$routes->post('sales/setPrintAfterSale', 'Sales::postSetPrintAfterSale');
$routes->post('sales/setEmailReceipt', 'Sales::postSetEmailReceipt');
$routes->post('sales/setPriceWorkOrders', 'Sales::postSetPriceWorkOrders');
$routes->post('sales/changeItemDescription/(:num)', 'Sales::postChangeItemDescription/$1');
$routes->post('sales/changeItemName/(:num)', 'Sales::postChangeItemName/$1');
$routes->post('sales/changeItemNumber/(:num)', 'Sales::postChangeItemNumber/$1');
$routes->post('sales/checkInvoiceNumber', 'Sales::postCheckInvoiceNumber');
$routes->post('sales/delete/(:num)', 'Sales::postDelete/$1');
$routes->post('sales/save/(:segment)', 'Sales::postSave/$1');
$routes->post('sales/sendPdf/(:num)', 'Sales::postSendPdf/$1');
$routes->post('sales/sendPdf/(:num)/(:segment)', 'Sales::postSendPdf/$1/$2');
$routes->post('sales/sendReceipt/(:num)', 'Sales::postSendReceipt/$1');

// ============================================
// RECEIVINGS — GET
// ============================================
$routes->get('receivings', 'Receivings::getIndex');
$routes->get('receivings/manage', 'Receivings::getManage');
$routes->get('receivings/edit/(:num)', 'Receivings::getEdit/$1');
$routes->get('receivings/receipt/(:num)', 'Receivings::getReceipt/$1');
$routes->get('receivings/search', 'Receivings::getSearch');
$routes->get('receivings/itemSearch', 'Receivings::getItemSearch');
$routes->get('receivings/stockItemSearch', 'Receivings::getStockItemSearch');
$routes->get('receivings/deleteItem/(:segment)', 'Receivings::getDeleteItem/$1');
$routes->get('receivings/removeSupplier', 'Receivings::getRemoveSupplier');

// ============================================
// RECEIVINGS — POST
// ============================================
$routes->post('receivings/add', 'Receivings::postAdd');
$routes->post('receivings/complete', 'Receivings::postComplete');
$routes->post('receivings/cancelReceiving', 'Receivings::postCancelReceiving');
$routes->post('receivings/changeMode', 'Receivings::postChangeMode');
$routes->post('receivings/editItem/(:num)', 'Receivings::postEditItem/$1');
$routes->post('receivings/deleteItem/(:segment)', 'Receivings::postDeleteItem/$1');
$routes->post('receivings/removeSupplier', 'Receivings::postRemoveSupplier');
$routes->post('receivings/selectSupplier', 'Receivings::postSelectSupplier');
$routes->post('receivings/setComment', 'Receivings::postSetComment');
$routes->post('receivings/setReference', 'Receivings::postSetReference');
$routes->post('receivings/setPrintAfterSale', 'Receivings::postSetPrintAfterSale');
$routes->post('receivings/requisitionComplete', 'Receivings::postRequisitionComplete');
$routes->post('receivings/delete/(:num)', 'Receivings::postDelete/$1');
$routes->post('receivings/save/(:segment)', 'Receivings::postSave/$1');

// ============================================
// CUSTOMERS
// ============================================
$routes->get('customers', 'Customers::getIndex');
$routes->get('customers/view/(:segment)', 'Customers::getView/$1');
$routes->get('customers/search', 'Customers::getSearch');
$routes->get('customers/suggest', 'Customers::getSuggest');
$routes->get('customers/stats', 'Customers::getStats');
$routes->get('customers/row/(:num)', 'Customers::getRow/$1');
$routes->get('customers/csv', 'Customers::getCsv');
$routes->get('customers/csv_import', 'Customers::getCsvImport');
$routes->get('customers/excel_export', 'Customers::getCsv');
$routes->get('customers/excel_import', 'Customers::getCsvImport');
$routes->post('customers/save/(:segment)', 'Customers::postSave/$1');
$routes->post('customers/delete', 'Customers::postDelete');
$routes->post('customers/importCsvFile', 'Customers::postImportCsvFile');
$routes->post('customers/checkAccountNumber', 'Customers::postCheckAccountNumber');
$routes->post('customers/checkEmail', 'Customers::postCheckEmail');

// ============================================
// PRODUCTS
// ============================================
$routes->get('products', 'Products::getIndex');
$routes->get('items', 'Products::getIndex');
$routes->get('products/view/(:segment)', 'Products::getView/$1');
$routes->get('products/search', 'Products::getSearch');
$routes->get('products/suggest', 'Products::getSuggest');
$routes->get('products/suggest_search', 'Products::getSuggest');
$routes->get('products/suggestCategory', 'Products::getSuggestCategory');
$routes->get('products/suggestKits', 'Products::getSuggestKits');
$routes->get('products/suggestLocation', 'Products::getSuggestLocation');
$routes->get('products/suggestLowSell', 'Products::getSuggestLowSell');
$routes->get('products/stats', 'Products::getStats');
$routes->get('products/row/(:num)', 'Products::getRow/$1');
$routes->get('products/inventory/(:num)', 'Products::getInventory/$1');
$routes->get('products/countDetails/(:num)', 'Products::getCountDetails/$1');
$routes->get('products/attributes/(:num)', 'Products::getAttributes/$1');
$routes->get('products/bulkEdit', 'Products::getBulkEdit');
$routes->get('products/csv_import', 'Products::getCsvImport');
$routes->get('products/excel_import', 'Products::getCsvImport');
$routes->get('products/excel_export', 'Products::getGenerateCsvFile');
$routes->get('products/generateBarcodes', 'Products::getGenerateBarcodes');
$routes->get('products/picThumb/(:num)', 'Products::getPicThumb/$1');
$routes->get('products/removeLogo/(:num)', 'Products::getRemoveLogo/$1');
$routes->get('products/checkNumeric', 'Products::getCheckNumeric');
$routes->post('products/save/(:segment)', 'Products::postSave/$1');
$routes->post('products/saveInventory/(:num)', 'Products::postSaveInventory/$1');
$routes->post('products/delete', 'Products::postDelete');
$routes->post('products/bulkUpdate', 'Products::postBulkUpdate');
$routes->post('products/importCsvFile', 'Products::postImportCsvFile');
$routes->post('products/checkItemNumber', 'Products::postCheckItemNumber');
$routes->post('products/attributes/(:num)', 'Products::postAttributes/$1');

// ============================================
// SUPPLIERS
// ============================================
$routes->get('suppliers', 'Suppliers::getIndex');
$routes->get('suppliers/view/(:segment)', 'Suppliers::getView/$1');
$routes->get('suppliers/search', 'Suppliers::getSearch');
$routes->get('suppliers/suggest', 'Suppliers::getSuggest');
$routes->get('suppliers/row/(:num)', 'Suppliers::getRow/$1');
$routes->post('suppliers/save/(:segment)', 'Suppliers::postSave/$1');
$routes->post('suppliers/delete', 'Suppliers::postDelete');

// ============================================
// EMPLOYEES
// ============================================
$routes->get('employees', 'Employees::getIndex');
$routes->get('employees/view/(:segment)', 'Employees::getView/$1');
$routes->get('employees/search', 'Employees::getSearch');
$routes->get('employees/suggest', 'Employees::getSuggest');
$routes->get('employees/checkUsername', 'Employees::getCheckUsername');
$routes->post('employees/save/(:segment)', 'Employees::postSave/$1');
$routes->post('employees/delete', 'Employees::postDelete');

// ============================================
// GIFTCARDS
// ============================================
$routes->get('giftcards', 'Giftcards::getIndex');
$routes->get('giftcards/view/(:segment)', 'Giftcards::getView/$1');
$routes->get('giftcards/search', 'Giftcards::getSearch');
$routes->get('giftcards/suggest', 'Giftcards::getSuggest');
$routes->get('giftcards/row/(:num)', 'Giftcards::getRow/$1');
$routes->post('giftcards/save/(:segment)', 'Giftcards::postSave/$1');
$routes->post('giftcards/delete', 'Giftcards::postDelete');
$routes->post('giftcards/checkNumberGiftcard', 'Giftcards::postCheckNumberGiftcard');

// ============================================
// EXPENSES
// ============================================
$routes->get('expenses', 'Expenses::getIndex');
$routes->get('expenses/view/(:segment)', 'Expenses::getView/$1');
$routes->get('expenses/search', 'Expenses::getSearch');
$routes->get('expenses/row/(:num)', 'Expenses::getRow/$1');
$routes->post('expenses/save/(:segment)', 'Expenses::postSave/$1');
$routes->post('expenses/delete', 'Expenses::postDelete');

// ============================================
// EXPENSE CATEGORIES
// ============================================
$routes->get('expenses_categories', 'Expenses_categories::getIndex');
$routes->get('expenses_categories/view/(:segment)', 'Expenses_categories::getView/$1');
$routes->get('expenses_categories/search', 'Expenses_categories::getSearch');
$routes->get('expenses_categories/row/(:num)', 'Expenses_categories::getRow/$1');
$routes->post('expenses_categories/save/(:segment)', 'Expenses_categories::postSave/$1');
$routes->post('expenses_categories/delete', 'Expenses_categories::postDelete');

// ============================================
// ATTRIBUTES
// ============================================
$routes->get('attributes', 'Attributes::getIndex');
$routes->get('attributes/view/(:segment)', 'Attributes::getView/$1');
$routes->get('attributes/search', 'Attributes::getSearch');
$routes->get('attributes/suggestAttribute', 'Attributes::getSuggestAttribute');
$routes->get('attributes/row/(:num)', 'Attributes::getRow/$1');
$routes->post('attributes/saveDefinition/(:num)', 'Attributes::postSaveDefinition/$1');
$routes->post('attributes/saveAttributeValue', 'Attributes::postSaveAttributeValue');
$routes->post('attributes/delete', 'Attributes::postDelete');
$routes->post('attributes/DeleteDropdownAttributeValue', 'Attributes::postDeleteDropdownAttributeValue');

// ============================================
// CASHUPS
// ============================================
$routes->get('cashups', 'Cashups::getIndex');
$routes->get('cashups/view/(:segment)', 'Cashups::getView/$1');
$routes->get('cashups/search', 'Cashups::getSearch');
$routes->get('cashups/row/(:num)', 'Cashups::getRow/$1');
$routes->post('cashups/save/(:segment)', 'Cashups::postSave/$1');
$routes->post('cashups/delete', 'Cashups::postDelete');
$routes->post('cashups/ajax_cashup_total', 'Cashups::postAjax_cashup_total');

// ============================================
// BACKUPS
// ============================================
$routes->get('backups', 'Backups::getIndex');
$routes->get('backups/settings', 'Backups::getSettings');
$routes->get('backups/download/(:segment)', 'Backups::getDownload/$1');
$routes->post('backups/create', 'Backups::postCreate');
$routes->post('backups/restore', 'Backups::postRestore');
$routes->post('backups/delete', 'Backups::postDelete');
$routes->post('backups/clean', 'Backups::postClean');
$routes->post('backups/saveSettings', 'Backups::postSaveSettings');

// ============================================
// CONFIG (System Settings)
// ============================================
$routes->get('config', 'Config::getIndex');
$routes->get('config/general', 'Config::getGeneral');
$routes->get('config/barcode', 'Config::getBarcode');
$routes->get('config/email', 'Config::getEmail');
$routes->get('config/info', 'Config::getInfo');
$routes->get('config/invoice', 'Config::getInvoice');
$routes->get('config/locale', 'Config::getLocale');
$routes->get('config/message', 'Config::getGeneral');
$routes->get('config/receipt', 'Config::getReceipt');
$routes->get('config/reward', 'Config::getReward');
$routes->get('config/stock', 'Config::getStock');
$routes->get('config/stockLocations', 'Config::getStockLocations');
$routes->get('config/system', 'Config::getSystem');
$routes->get('config/table', 'Config::getTable');
$routes->get('config/tax', 'Config::getTax');
$routes->get('config/customerRewards', 'Config::getCustomerRewards');
$routes->get('config/dinnerTables', 'Config::getDinnerTables');
$routes->post('config/saveGeneral', 'Config::postSaveGeneral');
$routes->post('config/saveBarcode', 'Config::postSaveBarcode');
$routes->post('config/saveEmail', 'Config::postSaveEmail');
$routes->post('config/saveInfo', 'Config::postSaveInfo');
$routes->post('config/saveInvoice', 'Config::postSaveInvoice');
$routes->post('config/saveLocale', 'Config::postSaveLocale');
$routes->post('config/saveLocations', 'Config::postSaveLocations');
$routes->post('config/saveMailchimp', 'Config::postSaveMailchimp');
$routes->post('config/saveMessage', 'Config::postSaveMessage');
$routes->post('config/saveReceipt', 'Config::postSaveReceipt');
$routes->post('config/saveRewards', 'Config::postSaveRewards');
$routes->post('config/saveTables', 'Config::postSaveTables');
$routes->post('config/saveTax', 'Config::postSaveTax');
$routes->post('config/clearCache', 'Config::postClearCache');
$routes->post('config/removeLogo', 'Config::postRemoveLogo');
$routes->post('config/checkMailchimpApiKey', 'Config::postCheckMailchimpApiKey');
$routes->post('config/checkNumberLocale', 'Config::postCheckNumberLocale');

// ============================================
// TAXES
// ============================================
$routes->get('taxes', 'Taxes::getIndex');
$routes->get('taxes/view/(:segment)', 'Taxes::getView/$1');
$routes->get('taxes/search', 'Taxes::getSearch');
$routes->get('taxes/row/(:num)', 'Taxes::getRow/$1');
$routes->get('taxes/suggestTaxCodes', 'Taxes::getSuggestTaxCodes');
$routes->get('taxes/view_tax_categories', 'Taxes::getView_tax_categories');
$routes->get('taxes/view_tax_categories/(:segment)', 'Taxes::getView_tax_categories/$1');
$routes->get('taxes/view_tax_codes', 'Taxes::getView_tax_codes');
$routes->get('taxes/view_tax_jurisdictions', 'Taxes::getView_tax_jurisdictions');
$routes->get('taxes/view_tax_jurisdictions/(:segment)', 'Taxes::getView_tax_jurisdictions/$1');
$routes->post('taxes/save/(:segment)', 'Taxes::postSave/$1');
$routes->post('taxes/delete', 'Taxes::postDelete');
$routes->post('taxes/save_tax_categories', 'Taxes::save_tax_categories');
$routes->post('taxes/save_tax_codes', 'Taxes::save_tax_codes');
$routes->post('taxes/save_tax_jurisdictions', 'Taxes::save_tax_jurisdictions');

// ============================================
// TAX CATEGORIES
// ============================================
$routes->get('tax_categories', 'Tax_categories::getIndex');
$routes->get('tax_categories/view/(:segment)', 'Tax_categories::getView/$1');
$routes->get('tax_categories/search', 'Tax_categories::getSearch');
$routes->get('tax_categories/row/(:num)', 'Tax_categories::getRow/$1');
$routes->post('tax_categories/save/(:segment)', 'Tax_categories::postSave/$1');
$routes->post('tax_categories/delete', 'Tax_categories::postDelete');

// ============================================
// TAX CODES
// ============================================
$routes->get('tax_codes', 'Tax_codes::getIndex');
$routes->get('tax_codes/view/(:segment)', 'Tax_codes::getView/$1');
$routes->get('tax_codes/search', 'Tax_codes::getSearch');
$routes->get('tax_codes/row/(:num)', 'Tax_codes::getRow/$1');
$routes->get('tax_codes/data', 'Tax_codes::get_data');
$routes->post('tax_codes/save/(:segment)', 'Tax_codes::postSave/$1');
$routes->post('tax_codes/delete', 'Tax_codes::postDelete');

// ============================================
// TAX JURISDICTIONS
// ============================================
$routes->get('tax_jurisdictions', 'Tax_jurisdictions::getIndex');
$routes->get('tax_jurisdictions/view/(:segment)', 'Tax_jurisdictions::getView/$1');
$routes->get('tax_jurisdictions/search', 'Tax_jurisdictions::getSearch');
$routes->get('tax_jurisdictions/row/(:num)', 'Tax_jurisdictions::getRow/$1');
$routes->post('tax_jurisdictions/save/(:segment)', 'Tax_jurisdictions::postSave/$1');
$routes->post('tax_jurisdictions/delete', 'Tax_jurisdictions::postDelete');

// ============================================
// ROLES
// ============================================
$routes->get('roles', 'Roles::getIndex');
$routes->get('roles/view/(:segment)', 'Roles::getView/$1');
$routes->post('roles/save/(:segment)', 'Roles::postSave/$1');
$routes->post('roles/delete', 'Roles::postDelete');
$routes->post('roles/duplicate', 'Roles::postDuplicate');

// ============================================
// PRODUCT BUNDLES / ITEM KITS
// ============================================
$routes->get('product_bundles', 'Product_bundles::getIndex');
$routes->get('product_bundles/view/(:segment)', 'Product_bundles::getView/$1');
$routes->get('product_bundles/search', 'Product_bundles::getSearch');
$routes->get('product_bundles/row/(:num)', 'Product_bundles::getRow/$1');
$routes->get('product_bundles/generateBarcodes', 'Product_bundles::getGenerateBarcodes');
$routes->get('item_kits/view/(:segment)', 'Product_bundles::getView/$1');
$routes->get('item_kits/search', 'Product_bundles::getSearch');
$routes->post('product_bundles/save/(:segment)', 'Product_bundles::postSave/$1');
$routes->post('product_bundles/delete', 'Product_bundles::postDelete');
$routes->post('product_bundles/checkItemNumber', 'Product_bundles::postCheckItemNumber');
$routes->post('item_kits/save/(:segment)', 'Product_bundles::postSave/$1');
$routes->post('item_kits/delete', 'Product_bundles::postDelete');

// ============================================
// MESSAGES
// ============================================
$routes->get('messages', 'Messages::getIndex');
$routes->get('messages/view/(:segment)', 'Messages::getView/$1');
$routes->get('messages/search', 'Messages::getIndex');
$routes->get('messages/send_form/(:num)', 'Messages::send_form/$1');
$routes->post('messages/send', 'Messages::send');
$routes->post('messages/delete', 'Messages::getIndex');

// ============================================
// OFFICE
// ============================================
$routes->get('office', 'Office::getIndex');
$routes->get('office/search', 'Office::getIndex');
$routes->post('office/delete', 'Office::getIndex');

// ============================================
// PERSONS
// ============================================
$routes->get('persons/suggest', 'Persons::getSuggest');
$routes->get('persons/row/(:num)', 'Persons::getRow/$1');

// ============================================
// REPORTS — Dashboard & Unified
// ============================================
$routes->get('reports', 'Reports::index');
$routes->get('reports/sales', 'Reports::sales');
$routes->post('reports/sales', 'Reports::sales');
$routes->get('reports/products', 'Reports::products');
$routes->post('reports/products', 'Reports::products');
$routes->get('reports/customers', 'Reports::customers');
$routes->post('reports/customers', 'Reports::customers');
$routes->get('reports/suppliers', 'Reports::suppliers');
$routes->post('reports/suppliers', 'Reports::suppliers');
$routes->get('reports/employees', 'Reports::employees');
$routes->post('reports/employees', 'Reports::employees');
$routes->get('reports/financial', 'Reports::financial');
$routes->post('reports/financial', 'Reports::financial');
$routes->post('reports/(:segment)/export', 'Reports::export/$1');

// ============================================
// REPORTS — Summary (input pages)
// ============================================
$routes->get('reports/summary_sales', 'Reports::date_input');
$routes->get('reports/summary_categories', 'Reports::date_input');
$routes->get('reports/summary_customers', 'Reports::date_input');
$routes->get('reports/summary_suppliers', 'Reports::date_input');
$routes->get('reports/summary_items', 'Reports::date_input');
$routes->get('reports/summary_employees', 'Reports::date_input');
$routes->get('reports/summary_taxes', 'Reports::date_input');
$routes->get('reports/summary_rewards', 'Reports::date_input');
$routes->get('reports/summary_discounts', 'Reports::summary_discounts_input');
$routes->get('reports/summary_payments', 'Reports::date_input_only');
$routes->get('reports/summary_expenses_categories', 'Reports::date_input_only');

// ============================================
// REPORTS — Summary (data views)
// ============================================
$routes->get('reports/summary_(:any)/(:any)/(:any)', 'Reports::Summary_$1/$2/$3/$4');

// ============================================
// REPORTS — Graphical
// ============================================
$routes->get('reports/graphical_summary_expenses_categories', 'Reports::date_input_only');
$routes->get('reports/graphical_summary_discounts', 'Reports::summary_discounts_input');
$routes->get('reports/graphical_(:any)/(:any)/(:any)', 'Reports::Graphical_$1/$2/$3/$4');
$routes->get('reports/graphical_(:any)', 'Reports::date_input');

// ============================================
// REPORTS — Inventory
// ============================================
$routes->get('reports/inventory_low', 'Reports::inventory_low');
$routes->get('reports/inventory_expiring', 'Reports::inventory_low');
$routes->get('reports/inventory_summary', 'Reports::inventory_summary_input');
$routes->get('reports/inventory_summary/(:any)/(:any)/(:any)', 'Reports::inventory_summary/$1/$2/$3');
$routes->get('reports/inventory_(:any)/(:any)', 'Reports::Inventory_$1/$2');

// ============================================
// REPORTS — Detailed
// ============================================
$routes->get('reports/detailed_sales', 'Reports::date_input_sales');
$routes->get('reports/detailed_receivings', 'Reports::date_input_recv');
$routes->get('reports/detailed_(:any)/(:any)/(:any)/(:any)', 'Reports::Detailed_$1/$2/$3/$4');

// ============================================
// REPORTS — Specific
// ============================================
$routes->get('reports/specific_customers', 'Reports::specific_customer_input');
$routes->get('reports/specific_customer', 'Reports::specific_customer_input');
$routes->get('reports/specific_employees', 'Reports::specific_employee_input');
$routes->get('reports/specific_employee', 'Reports::specific_employee_input');
$routes->get('reports/specific_discounts', 'Reports::specific_discount_input');
$routes->get('reports/specific_suppliers', 'Reports::specific_supplier_input');
$routes->get('reports/specific_supplier', 'Reports::specific_supplier_input');
$routes->get('reports/specific_(:any)/(:any)/(:any)/(:any)', 'Reports::Specific_$1/$2/$3/$4');

// ============================================
// REPORTS — Timeclock
// ============================================
$routes->get('reports/timeclock', 'Reports::date_input');
