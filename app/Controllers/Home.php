<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Home extends Secure_Controller
{
    public function __construct()
    {
        parent::__construct('home', null, 'home');
    }

    /**
     * @return void
     */
    public function getIndex(): void
    {
        $logged_in = $this->employee->is_logged_in();
        
        // Use new Bootstrap 5 modern UI
        echo view('home/home_bootstrap5', $this->global_view_data);
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
