<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Load the system's routing file first
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// Set default namespace
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// Note: Auto-routing is configured in app/Config/Feature.php

$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->get('login/logout', 'Login::getLogout');
$routes->post('login', 'Login::index');

$routes->get('home', 'Home::getIndex');
$routes->get('home/logout', 'Home::getLogout');
$routes->get('home/user_settings', 'Home::getUserSettings');
$routes->get('home/debug_sidebar', 'Home::getDebugSidebar');
$routes->post('home/savePassword', 'Home::postSavePassword');

$routes->get('sales', 'Sales::getIndex');
$routes->get('sales/register', 'Sales::getIndex');
$routes->get('sales/discard_suspended_sale', 'Sales::getDiscardSuspendedSale');

$routes->add('no_access/index/(:segment)', 'No_access::index/$1');
$routes->add('no_access/index/(:segment)/(:segment)', 'No_access::index/$1/$2');

// Notifications API
$routes->get('notifications/get_unread', 'Notifications::get_unread');
$routes->post('notifications/mark_read', 'Notifications::mark_read');
$routes->post('notifications/mark_all_read', 'Notifications::mark_all_read');

// Main Reports Dashboard
$routes->add('reports', 'Reports::index');

// Unified Report Routes (must come BEFORE wildcard routes)
$routes->add('reports/sales', 'Reports::sales');
$routes->add('reports/products', 'Reports::products');
$routes->add('reports/customers', 'Reports::customers');
$routes->add('reports/suppliers', 'Reports::suppliers');
$routes->add('reports/employees', 'Reports::employees');
$routes->add('reports/financial', 'Reports::financial');

// Export routes - must come BEFORE legacy wildcards
$routes->post('reports/(:segment)/export', 'Reports::export/$1');

// Legacy Report Routes (wildcards)
$routes->add('reports/summary_(:any)/(:any)/(:any)', 'Reports::Summary_$1/$2/$3/$4');
$routes->add('reports/summary_expenses_categories', 'Reports::date_input_only');
$routes->add('reports/summary_payments', 'Reports::date_input_only');
$routes->add('reports/summary_discounts', 'Reports::summary_discounts_input');
$routes->add('reports/summary_(:any)', 'Reports::date_input');

$routes->add('reports/graphical_(:any)/(:any)/(:any)', 'Reports::Graphical_$1/$2/$3/$4');
$routes->add('reports/graphical_summary_expenses_categories', 'Reports::date_input_only');
$routes->add('reports/graphical_summary_discounts', 'Reports::summary_discounts_input');
$routes->add('reports/graphical_(:any)', 'Reports::date_input');

$routes->add('reports/inventory_(:any)/(:any)', 'Reports::Inventory_$1/$2');
$routes->add('reports/inventory_low', 'Reports::inventory_low');
$routes->add('reports/inventory_summary', 'Reports::inventory_summary_input');
$routes->add('reports/inventory_summary/(:any)/(:any)/(:any)', 'Reports::inventory_summary/$1/$2/$3');

$routes->add('reports/detailed_(:any)/(:any)/(:any)/(:any)', 'Reports::Detailed_$1/$2/$3/$4');
$routes->add('reports/detailed_sales', 'Reports::date_input_sales');
$routes->add('reports/detailed_receivings', 'Reports::date_input_recv');

$routes->add('reports/specific_(:any)/(:any)/(:any)/(:any)', 'Reports::Specific_$1/$2/$3/$4');
$routes->add('reports/specific_customers', 'Reports::specific_customer_input');
$routes->add('reports/specific_employees', 'Reports::specific_employee_input');
$routes->add('reports/specific_discounts', 'Reports::specific_discount_input');
$routes->add('reports/specific_suppliers', 'Reports::specific_supplier_input');

// POS / receivings state-changing endpoints (POST + CSRF)
$routes->post('sales/cancel', 'Sales::postCancel');
$routes->post('sales/deleteItem/(:num)', 'Sales::postDeleteItem/$1');
$routes->post('sales/deletePayment/(:segment)', 'Sales::postDeletePayment/$1');
$routes->post('sales/removeCustomer', 'Sales::postRemoveCustomer');
$routes->post('receivings/deleteItem/(:segment)', 'Receivings::postDeleteItem/$1');
$routes->post('receivings/removeSupplier', 'Receivings::postRemoveSupplier');

// Sale document email (POST + CSRF — replaces GET side effects)
$routes->post('sales/sendPdf/(:num)', 'Sales::postSendPdf/$1');
$routes->post('sales/sendPdf/(:num)/(:segment)', 'Sales::postSendPdf/$1/$2');
$routes->post('sales/sendReceipt/(:num)', 'Sales::postSendReceipt/$1');

// Password change (required after legacy login migration)
$routes->get('home/changePassword/(:num)', 'Home::getChangePassword/$1');
$routes->post('home/save/(:num)', 'Home::postSave/$1');
