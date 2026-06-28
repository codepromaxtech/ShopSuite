<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\Module;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Part of the grants mechanism to restrict access to modules that the user doesn't have permission for.
 */
class No_access extends BaseController
{
    private Module $module;
    private Employee $employee;

    public function __construct()
    {
        $this->module = model(Module::class);
        $this->employee = model(Employee::class);
    }

    /**
     * @param string $module_id
     * @param string $permission_id
     * @return RedirectResponse|void
     */
    public function getIndex(string $module_id = '', string $permission_id = '')
    {
        if (!$this->employee->is_logged_in()) {
            return redirect()->to('login');
        }

        $data['module_name']   = $this->module->get_module_name($module_id);
        $data['permission_id'] = $permission_id;

        echo view('no_access', $data);
    }
}
