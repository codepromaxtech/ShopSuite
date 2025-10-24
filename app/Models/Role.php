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
        $prefix = $this->db->getPrefix();
        return $this->db->table($prefix . 'roles')
            ->select($prefix . 'roles.*, COUNT(' . $prefix . 'role_permissions.permission_id) as permission_count, 
                     (SELECT COUNT(*) FROM ' . $prefix . 'employees WHERE ' . $prefix . 'employees.role_id = ' . $prefix . 'roles.role_id) as employee_count')
            ->join($prefix . 'role_permissions', $prefix . 'role_permissions.role_id = ' . $prefix . 'roles.role_id', 'left')
            ->groupBy($prefix . 'roles.role_id')
            ->orderBy($prefix . 'roles.is_system_role', 'DESC')
            ->orderBy($prefix . 'roles.role_name', 'ASC')
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
            $prefix = $this->db->getPrefix();
            $permissions = $this->db->table($prefix . 'role_permissions')
                ->select($prefix . 'role_permissions.*, ' . $prefix . 'permissions.module_id, ' . $prefix . 'modules.name_lang_key, ' . $prefix . 'modules.desc_lang_key')
                ->join($prefix . 'permissions', $prefix . 'permissions.permission_id = ' . $prefix . 'role_permissions.permission_id')
                ->join($prefix . 'modules', $prefix . 'modules.module_id = ' . $prefix . 'permissions.module_id', 'left')
                ->where($prefix . 'role_permissions.role_id', $role_id)
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
        $prefix = $this->db->getPrefix();
        $permissions = $this->db->table($prefix . 'permissions')
            ->select($prefix . 'permissions.*, ' . $prefix . 'modules.name_lang_key, ' . $prefix . 'modules.desc_lang_key, ' . $prefix . 'modules.sort')
            ->join($prefix . 'modules', $prefix . 'modules.module_id = ' . $prefix . 'permissions.module_id', 'left')
            ->orderBy($prefix . 'modules.sort', 'ASC')
            ->orderBy($prefix . 'permissions.permission_id', 'ASC')
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
        $prefix = $this->db->getPrefix();

        // Delete existing permissions
        $this->db->table($prefix . 'role_permissions')->where('role_id', $role_id)->delete();

        // Insert new permissions
        if (!empty($permissions_data)) {
            foreach ($permissions_data as $perm) {
                $this->db->table($prefix . 'role_permissions')->insert([
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
        $prefix = $this->db->getPrefix();
        $employee_count = $this->db->table($prefix . 'employees')
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
            $prefix = $this->db->getPrefix();
            foreach ($role->permissions as $perm) {
                $this->db->table($prefix . 'role_permissions')->insert([
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
