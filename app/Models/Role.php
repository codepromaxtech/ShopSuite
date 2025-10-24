<?php

namespace App\Models;

use CodeIgniter\Model;

class Role extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'role_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['role_name', 'role_description', 'is_system_role'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all roles with permission count
     */
    public function get_all_with_counts()
    {
        return $this->db->table('roles')
            ->select('roles.*, COUNT(role_permissions.permission_id) as permission_count, 
                     (SELECT COUNT(*) FROM employees WHERE employees.role_id = roles.role_id) as employee_count')
            ->join('role_permissions', 'role_permissions.role_id = roles.role_id', 'left')
            ->groupBy('roles.role_id')
            ->orderBy('roles.is_system_role', 'DESC')
            ->orderBy('roles.role_name', 'ASC')
            ->get()
            ->getResult();
    }

    /**
     * Get role with permissions
     */
    public function get_role_with_permissions(int $role_id)
    {
        $role = $this->find($role_id);
        
        if ($role) {
            $permissions = $this->db->table('role_permissions')
                ->select('role_permissions.*, permissions.module_id, modules.name_lang_key, modules.desc_lang_key')
                ->join('permissions', 'permissions.permission_id = role_permissions.permission_id')
                ->join('modules', 'modules.module_id = permissions.module_id', 'left')
                ->where('role_permissions.role_id', $role_id)
                ->get()
                ->getResult();
            
            $role->permissions = $permissions;
        }
        
        return $role;
    }

    /**
     * Get all permissions grouped by module
     */
    public function get_all_permissions_grouped()
    {
        $permissions = $this->db->table('permissions')
            ->select('permissions.*, modules.name_lang_key, modules.desc_lang_key, modules.sort')
            ->join('modules', 'modules.module_id = permissions.module_id', 'left')
            ->orderBy('modules.sort', 'ASC')
            ->orderBy('permissions.permission_id', 'ASC')
            ->get()
            ->getResult();

        // Group by module
        $grouped = [];
        foreach ($permissions as $perm) {
            $module_id = $perm->module_id;
            if (!isset($grouped[$module_id])) {
                $grouped[$module_id] = [
                    'module_id'      => $module_id,
                    'name_lang_key'  => $perm->name_lang_key,
                    'desc_lang_key'  => $perm->desc_lang_key,
                    'permissions'    => []
                ];
            }
            $grouped[$module_id]['permissions'][] = $perm;
        }

        return array_values($grouped);
    }

    /**
     * Save role permissions
     */
    public function save_role_permissions(int $role_id, array $permissions_data): bool
    {
        $this->db->transStart();

        // Delete existing permissions
        $this->db->table('role_permissions')->where('role_id', $role_id)->delete();

        // Insert new permissions
        if (!empty($permissions_data)) {
            foreach ($permissions_data as $perm) {
                $this->db->table('role_permissions')->insert([
                    'role_id'       => $role_id,
                    'permission_id' => $perm['permission_id'],
                    'menu_group'    => $perm['menu_group'] ?? 'home'
                ]);
            }
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Delete role (if not system role and no employees assigned)
     */
    public function delete_role(int $role_id): array
    {
        $role = $this->find($role_id);

        if (!$role) {
            return ['success' => false, 'message' => 'Role not found'];
        }

        if ($role->is_system_role) {
            return ['success' => false, 'message' => 'Cannot delete system roles'];
        }

        // Check if any employees have this role
        $employee_count = $this->db->table('employees')
            ->where('role_id', $role_id)
            ->countAllResults();

        if ($employee_count > 0) {
            return ['success' => false, 'message' => 'Cannot delete role. ' . $employee_count . ' employee(s) are assigned to this role'];
        }

        // Delete role (permissions will be deleted via foreign key cascade)
        if ($this->delete($role_id)) {
            return ['success' => true, 'message' => 'Role deleted successfully'];
        }

        return ['success' => false, 'message' => 'Failed to delete role'];
    }

    /**
     * Duplicate role
     */
    public function duplicate_role(int $role_id, string $new_role_name): array
    {
        $role = $this->get_role_with_permissions($role_id);

        if (!$role) {
            return ['success' => false, 'message' => 'Role not found'];
        }

        $this->db->transStart();

        // Create new role
        $new_role_id = $this->insert([
            'role_name'        => $new_role_name,
            'role_description' => $role->role_description . ' (Copy)',
            'is_system_role'   => 0,
        ]);

        // Copy permissions
        if ($new_role_id && !empty($role->permissions)) {
            foreach ($role->permissions as $perm) {
                $this->db->table('role_permissions')->insert([
                    'role_id'       => $new_role_id,
                    'permission_id' => $perm->permission_id,
                    'menu_group'    => $perm->menu_group
                ]);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus()) {
            return ['success' => true, 'message' => 'Role duplicated successfully', 'role_id' => $new_role_id];
        }

        return ['success' => false, 'message' => 'Failed to duplicate role'];
    }
}
