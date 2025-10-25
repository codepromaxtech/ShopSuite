<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Home extends Secure_Controller
{
    protected $db;
    
    public function __construct()
    {
        parent::__construct('home', null, 'home');
        $this->db = \Config\Database::connect();
    }

    /**
     * @return void
     */
    public function getIndex(): void
    {
        $logged_in = $this->employee->is_logged_in();
        
        // Get dashboard stats
        $stats = $this->getDashboardStats();
        $data = $this->global_view_data;
        $data['stats'] = $stats;
        
        // Use new modern responsive dashboard
        echo view('home/dashboard_modern', $data);
    }
    
    /**
     * Get comprehensive dashboard statistics
     */
    private function getDashboardStats(): array
    {
        $prefix = $this->db->getPrefix();
        
        // Today's sales count and revenue
        $today_sales = $this->db->table($prefix . 'sales')
            ->where('DATE(sale_time)', date('Y-m-d'))
            ->countAllResults();
        
        $today_revenue = $this->db->table($prefix . 'sales_payments sp')
            ->select('SUM(sp.payment_amount) as total', false)
            ->join($prefix . 'sales s', 's.sale_id = sp.sale_id')
            ->where('DATE(s.sale_time)', date('Y-m-d'))
            ->get()
            ->getRow()
            ->total ?? 0;
        
        // This month's revenue
        $month_revenue = $this->db->table($prefix . 'sales_payments sp')
            ->select('SUM(sp.payment_amount) as total', false)
            ->join($prefix . 'sales s', 's.sale_id = sp.sale_id')
            ->where('YEAR(s.sale_time)', date('Y'))
            ->where('MONTH(s.sale_time)', date('m'))
            ->get()
            ->getRow()
            ->total ?? 0;
        
        // Total customers
        $total_customers = $this->db->table($prefix . 'customers')
            ->where('deleted', 0)
            ->countAllResults();
        
        // Total items in stock
        $total_items = $this->db->table($prefix . 'item_quantities')
            ->selectSum('quantity', 'total')
            ->get()
            ->getRow()
            ->total ?? 0;
        
        // Low stock items (below reorder level)
        $low_stock = $this->db->query("
            SELECT COUNT(*) as count
            FROM {$prefix}items i
            LEFT JOIN {$prefix}item_quantities iq ON i.item_id = iq.item_id
            WHERE i.deleted = 0
            AND (iq.quantity IS NULL OR iq.quantity <= i.reorder_level)
        ")->getRow()->count ?? 0;
        
        // Recent sales (last 5)
        $recent_sales = $this->db->query("
            SELECT s.sale_id, s.sale_time, 
                   CONCAT(p.first_name, ' ', p.last_name) as customer_name,
                   SUM(sp.payment_amount) as total
            FROM {$prefix}sales s
            LEFT JOIN {$prefix}people p ON s.customer_id = p.person_id
            LEFT JOIN {$prefix}sales_payments sp ON s.sale_id = sp.sale_id
            WHERE s.sale_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY s.sale_id
            ORDER BY s.sale_time DESC
            LIMIT 5
        ")->getResultArray();
        
        // Top 5 products by sales
        $top_products = $this->db->query("
            SELECT i.name, SUM(si.quantity_purchased) as total_sold
            FROM {$prefix}sales_items si
            JOIN {$prefix}items i ON si.item_id = i.item_id
            JOIN {$prefix}sales s ON si.sale_id = s.sale_id
            WHERE s.sale_time >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            AND i.deleted = 0
            GROUP BY si.item_id
            ORDER BY total_sold DESC
            LIMIT 5
        ")->getResultArray();
        
        // Sales trend (last 7 days)
        $sales_trend = $this->db->query("
            SELECT DATE(s.sale_time) as date, 
                   COUNT(s.sale_id) as count,
                   COALESCE(SUM(sp.payment_amount), 0) as revenue
            FROM {$prefix}sales s
            LEFT JOIN {$prefix}sales_payments sp ON s.sale_id = sp.sale_id
            WHERE s.sale_time >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(s.sale_time)
            ORDER BY date ASC
        ")->getResultArray();
        
        return [
            'today_sales' => $today_sales,
            'today_revenue' => number_format($today_revenue, 2),
            'month_revenue' => number_format($month_revenue, 2),
            'total_customers' => $total_customers,
            'total_items' => number_format($total_items),
            'low_stock' => $low_stock,
            'recent_sales' => $recent_sales,
            'top_products' => $top_products,
            'sales_trend' => $sales_trend
        ];
    }

    /**
     * User Settings Page
     *
     * @return void
     * @noinspection PhpUnused
     */
    public function getUserSettings(): void
    {
        echo view('home/user_settings', $this->global_view_data);
    }
    
    /**
     * Debug sidebar data
     *
     * @return void
     * @noinspection PhpUnused
     */
    public function getDebugSidebar(): void
    {
        echo view('debug_sidebar', $this->global_view_data);
    }
    
    /**
     * Logs the currently logged in employee out of the system.  Used in app/Views/partial/header.php
     *
     * @return RedirectResponse
     * @noinspection PhpUnused
     */
    public function getLogout(): RedirectResponse
    {
        $this->employee->logout();
        return redirect()->to('login');
    }

    /**
     * Load "change employee password" form
     *
     * @noinspection PhpUnused
     */
    public function getChangePassword(int $employee_id = -1): void    // TODO: Replace -1 with a constant
    {
        $person_info = $this->employee->get_info($employee_id);
        foreach (get_object_vars($person_info) as $property => $value) {
            $person_info->$property = $value;
        }
        $data['person_info'] = $person_info;

        echo view('home/form_change_password', $data);
    }

    /**
     * Change employee password
     */
    public function postSave(int $employee_id = -1): void    // TODO: Replace -1 with a constant
    {
        if (!empty($this->request->getPost('current_password')) && $employee_id != -1) {
            if ($this->employee->check_password($this->request->getPost('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS), $this->request->getPost('current_password'))) {
                $employee_data = [
                    'username'     => $this->request->getPost('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'hash_version' => 2
                ];

                if ($this->employee->change_password($employee_data, $employee_id)) {
                    echo json_encode([
                        'success' => true,
                        'message' => lang('Employees.successful_change_password'),
                        'id'      => $employee_id
                    ]);
                } else { // Failure    // TODO: Replace -1 with constant
                    echo json_encode([
                        'success' => false,
                        'message' => lang('Employees.unsuccessful_change_password'),
                        'id'      => -1
                    ]);
                }
            } else {    // TODO: Replace -1 with constant
                echo json_encode([
                    'success' => false,
                    'message' => lang('Employees.current_password_invalid'),
                    'id'      => -1
                ]);
            }
        } else {    // TODO: Replace -1 with constant
            echo json_encode([
                'success' => false,
                'message' => lang('Employees.current_password_invalid'),
                'id'      => -1
            ]);
        }
    }
    
    /**
     * Save password from user settings page
     * @return void
     */
    public function postSavePassword(): void
    {
        $this->response->setContentType('application/json');
        
        $person_id = $this->request->getPost('person_id', FILTER_SANITIZE_NUMBER_INT);
        $current_password = $this->request->getPost('current_password');
        $new_password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');
        
        // Verify passwords match
        if ($new_password !== $confirm_password) {
            echo json_encode([
                'success' => false,
                'message' => 'Passwords do not match'
            ]);
            exit;
        }
        
        // Get employee info
        $employee_info = $this->employee->get_info($person_id);
        
        // Verify current password
        if ($this->employee->check_password($employee_info->username, $current_password)) {
            $employee_data = [
                'username'     => $employee_info->username,
                'password'     => password_hash($new_password, PASSWORD_DEFAULT),
                'hash_version' => 2
            ];
            
            if ($this->employee->change_password($employee_data, $person_id)) {
                echo json_encode([
                    'success' => true,
                    'message' => lang('Employees.successful_change_password')
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => lang('Employees.unsuccessful_change_password')
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => lang('Employees.current_password_invalid')
            ]);
        }
        exit;
    }
}
