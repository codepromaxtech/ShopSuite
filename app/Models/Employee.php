<?php

namespace App\Models;

use CodeIgniter\Database\ResultInterface;
use CodeIgniter\Session\Session;

/**
 * Employee class
 *
 * @property session session
 *
 */
class Employee extends Person
{
    public Session $session;
    protected $table = 'Employees';
    protected $primaryKey = 'person_id';
    protected $useAutoIncrement = false;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'username',
        'password',
        'deleted',
        'hashversion',
        'language',
        'language_code'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
    }

    /**
     * Determines if a given person_id is an employee
     */
    public function exists(int $person_id): bool
    {
        $builder = $this->db->table('employees');
        $builder->join('people', 'people.person_id = employees.person_id');
        $builder->where('employees.person_id', $person_id);

        return ($builder->get()->getNumRows() == 1);    // TODO: ===
    }

    /**
     * @param int $employee_id
     * @param string $username
     * @return bool
     */
    public function username_exists(int $employee_id, string $username): bool
    {
        $builder = $this->db->table('employees');
        $builder->where('employees.username', $username);
        $builder->where('employees.person_id <>', $employee_id);

        return ($builder->get()->getNumRows() == 1);    // TODO: ===
    }

    /**
     * Gets total of rows
     */
    public function get_total_rows(): int
    {
        $builder = $this->db->table('employees');
        $builder->where('deleted', 0);

        return $builder->countAllResults();
    }

    /**
     * Returns all the employees
     */
    public function get_all(int $limit = 10000, int $offset = 0): ResultInterface
    {
        $builder = $this->db->table('employees');
        $builder->where('deleted', 0);
        $builder->join('people', 'employees.person_id = people.person_id');
        $builder->orderBy('last_name', 'asc');
        $builder->limit($limit);
        $builder->offset($offset);

        return $builder->get();
    }

    /**
     * Gets information about a particular employee
     */
    public function get_info(int $person_id): object
    {
        $builder = $this->db->table('employees');
        $builder->join('people', 'people.person_id = employees.person_id');
        $builder->where('employees.person_id', $person_id);
        $query = $builder->get();

        if ($query->getNumRows() == 1) {    // TODO: ===
            return $query->getRow();
        }

        // Get empty base parent object, as $employee_id is NOT an employee
        $person_obj = parent::get_info(NEW_ITEM);

        // Get all the fields from employee table
        // Append those fields to base parent object, we have a complete empty object
        foreach ($this->db->getFieldNames('employees') as $field) {
            $person_obj->$field = null;
        }

        return $person_obj;
    }

    /**
     * Gets information about multiple employees
     */
    public function get_multiple_info(array $person_ids): ResultInterface
    {
        $builder = $this->db->table('employees');
        $builder->join('people', 'people.person_id = employees.person_id');
        $builder->whereIn('employees.person_id', $person_ids);
        $builder->orderBy('last_name', 'asc');

        return $builder->get();
    }

    /**
     * Inserts or updates an employee
     */
    public function save_employee(array &$person_data, array &$employee_data, array &$grants_data, int $employee_id = NEW_ENTRY): bool
    {
        $success = false;

        // Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->transStart();

        if (ENVIRONMENT != 'testing' && parent::save_value($person_data, $employee_id)) {
            $builder = $this->db->table('employees');
            if ($employee_id == NEW_ENTRY || !$this->exists($employee_id)) {
                $employee_data['person_id'] = $employee_id = $person_data['person_id'];
                $success = $builder->insert($employee_data);
            } else {
                $builder->where('person_id', $employee_id);
                $success = $builder->update($employee_data);
            }

            // We have either inserted or updated a new employee, now lets set permissions.
            if ($success) {
                // First lets clear out any grants the employee currently has.
                $builder = $this->db->table('grants');
                $success = $builder->delete(['person_id' => $employee_id]);

                // Now insert the new grants
                if ($success) {
                    foreach ($grants_data as $grant) {
                        $data = [
                            'permission_id' => $grant['permission_id'],
                            'person_id'     => $employee_id,
                            'menu_group'    => $grant['menu_group']
                        ];

                        $builder = $this->db->table('grants');
                        $success = $builder->insert($data);
                    }
                }
            }
        }

        $this->db->transComplete();

        $success &= $this->db->transStatus();

        return $success;
    }

    /**
     * Deletes one employee
     */
    public function delete($employee_id = null, bool $purge = false): bool
    {
        $success = false;

        // Don't let employees delete themselves
        if ($employee_id == $this->get_logged_in_employee_info()->person_id) {
            return false;
        }

        // Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->transStart();

        // Delete permissions
        $builder = $this->db->table('grants');

        if ($builder->delete(['person_id' => $employee_id])) {
            $builder = $this->db->table('employees');
            $builder->where('person_id', $employee_id);
            $success = $builder->update(['deleted' => 1]);
        }

        $this->db->transComplete();

        return $success;
    }

    /**
     * Deletes a list of employees
     */
    public function delete_list(array $person_ids): bool
    {
        $success = false;

        // Don't let employees delete themselves
        if (in_array($this->get_logged_in_employee_info()->person_id, $person_ids)) {
            return false;
        }

        // Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->transStart();

        $builder = $this->db->table('grants');
        $builder->whereIn('person_id', $person_ids);
        // Delete permissions
        if ($builder->delete()) {
            // Delete from employee table
            $builder = $this->db->table('employees');
            $builder->whereIn('person_id', $person_ids);
            $success = $builder->update(['deleted' => 1]);
        }

        $this->db->transComplete();
        $success &= $this->db->transStatus();

        return $success;
    }

    /**
     * Get search suggestions to find employees
     */
    public function get_search_suggestions(string $search, int $limit = 25, bool $unique = false): array
    {
        $suggestions = [];

        $builder = $this->db->table('employees');
        $builder->join('people', 'employees.person_id = people.person_id');
        $builder->groupStart();
        $builder->like('first_name', $search);
        $builder->orLike('last_name', $search);
        $builder->orLike('CONCAT(first_name, " ", last_name)', $search);
        $builder->groupEnd();

        if (!$unique) {
            $builder->where('deleted', 0);
        }

        $builder->orderBy('last_name', 'asc');

        foreach ($builder->get()->getResult() as $row) {
            $suggestions[] = ['value' => $row->person_id, 'label' => $row->first_name . ' ' . $row->last_name];
        }

        $builder = $this->db->table('employees');
        $builder->join('people', 'employees.person_id = people.person_id');

        if (!$unique) {
            $builder->where('deleted', 0);
        }

        $builder->like('email', $search);
        $builder->orderBy('email', 'asc');

        foreach ($builder->get()->getResult() as $row) {
            $suggestions[] = ['value' => $row->person_id, 'label' => $row->email];
        }

        $builder = $this->db->table('employees');
        $builder->join('people', 'employees.person_id = people.person_id');

        if (!$unique) {
            $builder->where('deleted', 0);
        }

        $builder->like('username', $search);
        $builder->orderBy('username', 'asc');

        foreach ($builder->get()->getResult() as $row) {
            $suggestions[] = ['value' => $row->person_id, 'label' => $row->username];
        }

        $builder = $this->db->table('employees');
        $builder->join('people', 'employees.person_id = people.person_id');

        if (!$unique) {
            $builder->where('deleted', 0);
        }

        $builder->like('phone_number', $search);
        $builder->orderBy('phone_number', 'asc');

        foreach ($builder->get()->getResult() as $row) {
            $suggestions[] = ['value' => $row->person_id, 'label' => $row->phone_number];
        }

        // Only return $limit suggestions
        if (count($suggestions) > $limit) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;
    }

    /**
     * Gets rows
     */
    public function get_found_rows(string $search): int
    {
        return $this->search($search, 0, 0, 'last_name', 'asc', true);
    }

    /**
     * Performs a search on employees
     */
    public function search(string $search, ?int $rows = 0, ?int $limit_from = 0, ?string $sort = 'last_name', ?string $order = 'asc', ?bool $count_only = false)
    {
        // Set default values
        if ($rows == null) $rows = 0;
        if ($limit_from == null) $limit_from = 0;
        if ($sort == null) $sort = 'last_name';
        if ($order == null) $order = 'asc';
        if ($count_only == null) $count_only = false;

        $builder = $this->db->table('employees AS employees');

        // get_found_rows case
        if ($count_only) {
            $builder->select('COUNT(employees.person_id) as count');
        }

        $builder->join('people', 'employees.person_id = people.person_id');
        $builder->groupStart();
        $builder->like('first_name', $search);
        $builder->orLike('last_name', $search);
        $builder->orLike('email', $search);
        $builder->orLike('phone_number', $search);
        $builder->orLike('username', $search);
        $builder->orLike('CONCAT(first_name, " ", last_name)', $search);
        $builder->groupEnd();
        $builder->where('deleted', 0);

        // get_found_rows case
        if ($count_only) {
            return $builder->get()->getRow()->count;
        }

        $builder->orderBy($sort, $order);

        if ($rows > 0) {
            $builder->limit($rows, $limit_from);
        }

        return $builder->get();
    }

    /**
     * Attempts to log in employee and set session. Returns boolean based on outcome.
     */
    public function login(string $username, string $password): bool
    {
        $builder = $this->db->table('employees');
        $query = $builder->getWhere(['username' => $username, 'deleted' => 0], 1);

        if ($query->getNumRows() === 1) {
            $row = $query->getRow();

            // Compare passwords depending on the hash version
            if ($row->hash_version === '1' && $row->password === md5($password)) {
                $this->session->set('person_id', $row->person_id);
                $this->session->set('force_password_change', true);
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $builder->where('person_id', $row->person_id);

                return $builder->update(['hash_version' => 2, 'password' => $password_hash]);
            } elseif ($row->hash_version === '2' && password_verify($password, $row->password)) {
                $this->session->set('person_id', $row->person_id);

                return true;
            }
        }

        return false;
    }

    /**
     * Logs out a user by destroying all session data and redirect to log in
     */
    public function logout(): void
    {
        session()->destroy();
    }

    /**
     * Determines if an employee is logged in
     */
    public function is_logged_in(): bool
    {
        return ($this->session->get('person_id') != false);
    }

    /**
     * Gets information about the currently logged in employee.
     */
    public function get_logged_in_employee_info()
    {
        if ($this->is_logged_in()) {
            return $this->get_info($this->session->get('person_id'));
        }

        return false;
    }

    /**
     * Determines whether the employee has access to at least one submodule
     */
    public function has_module_grant(string $permission_id, int $person_id): bool
    {
        $builder = $this->db->table('grants');
        $builder->like('permission_id', $permission_id, 'after');
        $builder->where('person_id', $person_id);
        $result_count = $builder->get()->getNumRows();

        if ($result_count != 1) {
            if ($result_count != 0) {
                return true;
            }
        } else {
            return $this->has_subpermissions($permission_id);
        }

        $role_id = $this->get_employee_role_id($person_id);
        if ($role_id === null) {
            return false;
        }

        $prefix = $this->db->getPrefix();
        $builder = $this->db->table($prefix . 'role_permissions');
        $builder->like('permission_id', $permission_id, 'after');
        $builder->where('role_id', $role_id);
        $role_count = $builder->get()->getNumRows();

        if ($role_count != 1) {
            return ($role_count != 0);
        }

        return $this->has_subpermissions($permission_id);
    }

    /**
     * Checks permissions
     */
    public function has_subpermissions(string $permission_id): bool
    {
        $builder = $this->db->table('permissions');
        $builder->like('permission_id', $permission_id . '_', 'after');

        return ($builder->get()->getNumRows() == 0);    // TODO: ===
    }

    /**
     * Determines whether the employee specified employee has access the specific module.
     */
    public function has_grant(?string $permission_id, ?int $person_id): bool
    {
        if ($permission_id == null) {
            return true;
        }
        if ($person_id == null) {
            return false;
        }

        $builder = $this->db->table('grants');
        $query = $builder->getWhere(['person_id' => $person_id, 'permission_id' => $permission_id], 1);

        if ($query->getNumRows() === 1) {
            return true;
        }

        $role_id = $this->get_employee_role_id($person_id);

        return $role_id !== null && $this->has_role_grant($role_id, $permission_id);
    }

    /**
     * Returns the menu group designation that this module is to appear in
     */
    public function get_menu_group(string $permission_id, ?int $person_id): string
    {
        $builder = $this->db->table('grants');
        $builder->select('menu_group');
        $builder->where('permission_id', $permission_id);
        $builder->where('person_id', $person_id);

        $row = $builder->get()->getRow();

        if ($row != null) {
            return $row->menu_group;
        }

        $role_id = $person_id !== null ? $this->get_employee_role_id($person_id) : null;
        if ($role_id !== null) {
            $prefix = $this->db->getPrefix();
            $roleRow = $this->db->table($prefix . 'role_permissions')
                ->select('menu_group')
                ->where('role_id', $role_id)
                ->where('permission_id', $permission_id)
                ->get()
                ->getRow();

            if ($roleRow !== null) {
                return $roleRow->menu_group;
            }
        }

        return 'home';
    }

    /**
     * Copy role permissions into the grants table for an employee.
     */
    public function sync_grants_from_role(int $person_id, int $role_id): bool
    {
        $prefix = $this->db->getPrefix();
        $permissions = $this->db->table($prefix . 'role_permissions')
            ->where('role_id', $role_id)
            ->get()
            ->getResultArray();

        $builder = $this->db->table('grants');
        $builder->delete(['person_id' => $person_id]);

        foreach ($permissions as $perm) {
            if (!$builder->insert([
                'permission_id' => $perm['permission_id'],
                'person_id'     => $person_id,
                'menu_group'    => $perm['menu_group'] ?? 'home',
            ])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return int|null
     */
    private function get_employee_role_id(int $person_id): ?int
    {
        $info = $this->get_info($person_id);

        if ($info === false || empty($info->role_id)) {
            return null;
        }

        return (int) $info->role_id;
    }

    private function has_role_grant(int $role_id, string $permission_id): bool
    {
        $prefix = $this->db->getPrefix();

        return $this->db->table($prefix . 'role_permissions')
                ->where('role_id', $role_id)
                ->where('permission_id', $permission_id)
                ->countAllResults() > 0;
    }

    /**
     * Gets employee permission grants
     */
    public function get_employee_grants(int $person_id): array
    {
        $builder = $this->db->table('grants');
        $builder->where('person_id', $person_id);

        return $builder->get()->getResultArray();
    }

    /**
     * Attempts to log in employee and set session. Returns boolean based on outcome.
     */
    public function check_password(string $username, string $password): bool
    {
        $builder = $this->db->table('employees');
        $query = $builder->getWhere(['username' => $username, 'deleted' => 0], 1);

        if ($query->getNumRows() == 1) {    // TODO: ===
            $row = $query->getRow();

            if (password_verify($password, $row->password)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Change password for the employee
     */
    public function change_password(array $employee_data, $employee_id = false): bool
    {
        $success = false;

        if (ENVIRONMENT != 'testing') {
            $this->db->transStart();

            $builder = $this->db->table('employees');
            $builder->where('person_id', $employee_id);
            $success = $builder->update($employee_data);

            $this->db->transComplete();

            $success &= $this->db->transStatus();
        }

        return $success;
    }
}
