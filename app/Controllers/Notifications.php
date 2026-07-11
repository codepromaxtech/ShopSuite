<?php

namespace App\Controllers;

use App\Models\Notification;
use App\Models\Employee;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Notifications Controller
 *
 * JSON API endpoints for the notification bell dropdown.
 * All methods return JSON responses — never HTML.
 */
class Notifications extends BaseController
{
    protected Employee $employee;

    /**
     * CI4 lifecycle hook — runs after request/response are available.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->employee = model(Employee::class);
    }

    /**
     * GET /notifications/get_unread
     *
     * Returns up to 10 unread notifications for the currently logged-in employee.
     */
    public function get_unread(): ResponseInterface
    {
        try {
            // Auth guard
            if (!$this->employee->is_logged_in()) {
                return $this->json(['success' => false, 'notifications' => [], 'count' => 0]);
            }

            $employee_info = $this->employee->get_logged_in_employee_info();
            if (!$employee_info || empty($employee_info->person_id)) {
                return $this->json(['success' => false, 'notifications' => [], 'count' => 0]);
            }

            $notificationModel = model(Notification::class);
            $unread = $notificationModel->get_unread((int) $employee_info->person_id, 10);

            return $this->json([
                'success'       => true,
                'notifications' => $unread,
                'count'         => count($unread),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[Notifications::get_unread] ' . $e->getMessage());
            return $this->jsonError($e->getMessage());
        }
    }

    /**
     * POST /notifications/mark_read
     *
     * Marks a single notification as read. Expects POST param: id
     */
    public function mark_read(): ResponseInterface
    {
        try {
            if (!$this->employee->is_logged_in()) {
                return $this->json(['success' => false]);
            }

            $employee_info = $this->employee->get_logged_in_employee_info();
            $id = $this->request->getPost('id');

            if (!$id || !$employee_info || empty($employee_info->person_id)) {
                return $this->json(['success' => false]);
            }

            $notificationModel = model(Notification::class);
            $success = $notificationModel->mark_as_read((int) $id, (int) $employee_info->person_id);

            return $this->json(['success' => (bool) $success]);
        } catch (\Throwable $e) {
            log_message('error', '[Notifications::mark_read] ' . $e->getMessage());
            return $this->jsonError($e->getMessage());
        }
    }

    /**
     * POST /notifications/mark_all_read
     *
     * Marks all unread notifications as read for the current employee.
     */
    public function mark_all_read(): ResponseInterface
    {
        try {
            if (!$this->employee->is_logged_in()) {
                return $this->json(['success' => false]);
            }

            $employee_info = $this->employee->get_logged_in_employee_info();
            if (!$employee_info || empty($employee_info->person_id)) {
                return $this->json(['success' => false]);
            }

            $notificationModel = model(Notification::class);
            $success = $notificationModel->mark_all_as_read((int) $employee_info->person_id);

            return $this->json(['success' => (bool) $success]);
        } catch (\Throwable $e) {
            log_message('error', '[Notifications::mark_all_read] ' . $e->getMessage());
            return $this->jsonError($e->getMessage());
        }
    }

    // ------------------------------------------------------------------
    // Private helpers — guarantee JSON output
    // ------------------------------------------------------------------

    /**
     * Return a standard JSON response with correct headers.
     */
    private function json(array $data, int $status = 200): ResponseInterface
    {
        return $this->response
            ->setStatusCode($status)
            ->setContentType('application/json')
            ->setJSON($data);
    }

    /**
     * Return a JSON error response.
     */
    private function jsonError(string $message, int $status = 500): ResponseInterface
    {
        return $this->json(['success' => false, 'error' => $message], $status);
    }
}
