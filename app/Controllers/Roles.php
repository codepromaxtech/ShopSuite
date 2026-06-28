<?php

namespace App\Controllers;

use App\Models\Role;

class Roles extends Secure_Controller
{
    protected Role $role;

    public function __construct()
    {
        parent::__construct('roles', null, 'office');
        $this->role = model(Role::class);
    }

    /**
     * List all roles
     */
    public function getIndex(): void
    {
        $data['roles'] = $this->role->get_all_with_counts();
        echo view('roles/manage_modern', $data);
    }

    /**
     * View/Edit role form
     */
    public function getView(int $role_id = -1): void
    {
        if ($role_id == -1) {
            // New role
            $data['role_info'] = (object)[
                'role_id'          => -1,
                'role_name'        => '',
                'role_description' => '',
                'is_system_role'   => 0,
                'permissions'      => []
            ];
        } else {
            // Existing role
            $data['role_info'] = $this->role->get_role_with_permissions($role_id);
        }

        $data['all_permissions'] = $this->role->get_all_permissions_grouped();

        echo view('roles/form_modern', $data);
    }

    /**
     * Save role
     */
    public function postSave(int $role_id = -1): void
    {
        $this->response->setContentType('application/json');

        $role_name = $this->request->getPost('role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $role_description = $this->request->getPost('role_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $permissions = $this->request->getPost('permissions') ?? [];

        // Validate
        if (empty($role_name)) {
            echo json_encode([
                'success' => false,
                'message' => 'Role name is required'
            ]);
            exit;
        }

        // Prepare role data
        $role_data = [
            'role_name'        => $role_name,
            'role_description' => $role_description,
            'is_system_role'   => 0, // Custom roles are never system roles
        ];

        // Save role
        if ($role_id == -1) {
            // New role
            $new_role_id = $this->role->insert($role_data);
            if ($new_role_id) {
                $role_id = $new_role_id;
                $message = 'Role created successfully';
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to create role'
                ]);
                exit;
            }
        } else {
            // Update existing role
            // Check if it's a system role
            $existing_role = $this->role->find($role_id);
            if ($existing_role && $existing_role->is_system_role) {
                // Can only update permissions, not name/description of system roles
                $message = 'System role permissions updated';
            } else {
                if (!$this->role->update($role_id, $role_data)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to update role'
                    ]);
                    exit;
                }
                $message = 'Role updated successfully';
            }
        }

        // Save permissions
        $permissions_data = [];
        foreach ($permissions as $perm_id => $menu_group) {
            $permissions_data[] = [
                'permission_id' => $perm_id,
                'menu_group'    => $menu_group
            ];
        }

        if ($this->role->save_role_permissions($role_id, $permissions_data)) {
            $this->sync_employee_grants_for_role($role_id);

            echo json_encode([
                'success' => true,
                'message' => $message,
                'role_id' => $role_id
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save permissions'
            ]);
        }
        exit;
    }

    /**
     * Refresh grants for all employees assigned to a role.
     */
    private function sync_employee_grants_for_role(int $role_id): void
    {
        $employee = model(\App\Models\Employee::class);
        $prefix = $this->role->db->getPrefix();
        $employees = $this->role->db->table($prefix . 'employees')
            ->select('person_id')
            ->where('role_id', $role_id)
            ->where('deleted', 0)
            ->get()
            ->getResultArray();

        foreach ($employees as $row) {
            $employee->sync_grants_from_role((int) $row['person_id'], $role_id);
        }
    }

    /**
     * Delete role
     */
    public function postDelete(): void
    {
        $this->response->setContentType('application/json');

        $role_ids = $this->request->getPost('ids');

        if (empty($role_ids)) {
            echo json_encode([
                'success' => false,
                'message' => 'No roles selected'
            ]);
            exit;
        }

        $errors = [];
        $deleted_count = 0;

        foreach ($role_ids as $role_id) {
            $result = $this->role->delete_role($role_id);
            if ($result['success']) {
                $deleted_count++;
            } else {
                $errors[] = $result['message'];
            }
        }

        if ($deleted_count > 0 && empty($errors)) {
            echo json_encode([
                'success' => true,
                'message' => $deleted_count . ' role(s) deleted successfully'
            ]);
        } elseif ($deleted_count > 0) {
            echo json_encode([
                'success' => true,
                'message' => $deleted_count . ' role(s) deleted. Errors: ' . implode(', ', $errors)
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => implode(', ', $errors)
            ]);
        }
        exit;
    }

    /**
     * Duplicate role
     */
    public function postDuplicate(): void
    {
        $this->response->setContentType('application/json');

        $role_id = $this->request->getPost('role_id', FILTER_SANITIZE_NUMBER_INT);
        $new_name = $this->request->getPost('new_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($role_id) || empty($new_name)) {
            echo json_encode([
                'success' => false,
                'message' => 'Role ID and new name are required'
            ]);
            exit;
        }

        $result = $this->role->duplicate_role($role_id, $new_name);
        echo json_encode($result);
        exit;
    }
}
