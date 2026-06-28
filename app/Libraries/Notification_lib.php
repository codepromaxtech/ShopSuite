<?php

namespace App\Libraries;

use App\Models\Employee;
use App\Models\Notification;

/**
 * Creates in-app notifications for employees.
 */
class Notification_lib
{
    private Notification $notification;
    private Employee $employee;

    public function __construct()
    {
        $this->notification = model(Notification::class);
        $this->employee = model(Employee::class);
    }

    /**
     * Create a notification for one employee.
     */
    public function notify(int $person_id, string $title, string $message, ?string $link = null): bool
    {
        if ($person_id <= 0) {
            return false;
        }

        return (bool) $this->notification->insert([
            'person_id' => $person_id,
            'title'     => $title,
            'message'   => $message,
            'is_read'   => 0,
            'link'      => $link,
        ]);
    }

    /**
     * Notify every employee who has a specific permission grant (direct or via role).
     */
    public function notify_by_permission(string $permission_id, string $title, string $message, ?string $link = null): void
    {
        foreach ($this->get_employee_ids_with_permission($permission_id) as $person_id) {
            $this->notify($person_id, $title, $message, $link);
        }
    }

    /**
     * @return list<int>
     */
    private function get_employee_ids_with_permission(string $permission_id): array
    {
        $db = db_connect();
        $prefix = $db->getPrefix();
        $ids = [];

        $grantRows = $db->table($prefix . 'grants')
            ->select('person_id')
            ->where('permission_id', $permission_id)
            ->get()
            ->getResultArray();

        foreach ($grantRows as $row) {
            $ids[(int) $row['person_id']] = true;
        }

        $roleRows = $db->table($prefix . 'role_permissions')
            ->select($prefix . 'employees.person_id')
            ->join($prefix . 'employees', $prefix . 'employees.role_id = ' . $prefix . 'role_permissions.role_id')
            ->where($prefix . 'role_permissions.permission_id', $permission_id)
            ->where($prefix . 'employees.deleted', 0)
            ->get()
            ->getResultArray();

        foreach ($roleRows as $row) {
            $ids[(int) $row['person_id']] = true;
        }

        return array_keys($ids);
    }
}
