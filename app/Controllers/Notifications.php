<?php

namespace App\Controllers;

use App\Models\Notification;
use App\Models\Employee;

/**
 * Class Notifications
 * Handles API requests for the notification bell dropdown.
 */
class Notifications extends BaseController
{
    protected Employee $employee;

    public function __construct()
    {
        $this->employee = model(Employee::class);
    }

    /**
     * Get unread notifications for the logged in user as JSON.
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function get_unread()
    {
        if (!$this->employee->is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Not logged in']);
        }

        $employee_info = $this->employee->get_logged_in_employee_info();
        if (!$employee_info || empty($employee_info->person_id)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid session']);
        }

        $notificationModel = model(Notification::class);
        $unread = $notificationModel->get_unread($employee_info->person_id, 10);

        return $this->response->setJSON([
            'success' => true,
            'notifications' => $unread,
            'count' => count($unread)
        ]);
    }

    /**
     * Mark a specific notification as read.
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function mark_read()
    {
        if (!$this->employee->is_logged_in()) {
            return $this->response->setJSON(['success' => false]);
        }

        $employee_info = $this->employee->get_logged_in_employee_info();
        $id = $this->request->getPost('id');

        if ($id && $employee_info) {
            $notificationModel = model(Notification::class);
            $success = $notificationModel->mark_as_read($id, $employee_info->person_id);
            return $this->response->setJSON(['success' => $success]);
        }

        return $this->response->setJSON(['success' => false]);
    }

    /**
     * Mark all notifications as read.
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function mark_all_read()
    {
        if (!$this->employee->is_logged_in()) {
            return $this->response->setJSON(['success' => false]);
        }

        $employee_info = $this->employee->get_logged_in_employee_info();
        if ($employee_info) {
            $notificationModel = model(Notification::class);
            $success = $notificationModel->mark_all_as_read($employee_info->person_id);
            return $this->response->setJSON(['success' => $success]);
        }

        return $this->response->setJSON(['success' => false]);
    }
}
