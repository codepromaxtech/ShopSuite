<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesSystem extends Migration
{
    public function up()
    {
        // Create roles table
        $this->forge->addField([
            'role_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'role_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_system_role' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = system role (cannot be deleted), 0 = custom role'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('role_id', true);
        $this->forge->createTable('roles');

        // Create role_permissions table (links roles to permissions)
        $this->forge->addField([
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'permission_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'menu_group' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
                'default'    => 'home',
            ],
        ]);
        $this->forge->addPrimaryKey(['role_id', 'permission_id']);
        $this->forge->addForeignKey('role_id', 'roles', 'role_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permissions', 'permission_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('role_permissions');

        // Add role_id to employees table
        $fields = [
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'person_id',
            ],
        ];
        $this->forge->addColumn('employees', $fields);
        
        // Add foreign key
        $this->db->query('ALTER TABLE ' . $this->db->prefixTable('employees') . ' 
                          ADD CONSTRAINT fk_employees_role 
                          FOREIGN KEY (role_id) REFERENCES ' . $this->db->prefixTable('roles') . '(role_id) 
                          ON DELETE SET NULL');

        // Insert default system roles
        $this->db->table('roles')->insertBatch([
            [
                'role_name'        => 'Administrator',
                'role_description' => 'Full system access with all permissions',
                'is_system_role'   => 1,
                'created_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'role_name'        => 'Manager',
                'role_description' => 'Can manage inventory, sales, customers, and reports',
                'is_system_role'   => 1,
                'created_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'role_name'        => 'Cashier',
                'role_description' => 'Can process sales and manage customers',
                'is_system_role'   => 1,
                'created_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'role_name'        => 'Stock Manager',
                'role_description' => 'Can manage inventory and receivings',
                'is_system_role'   => 1,
                'created_at'       => date('Y-m-d H:i:s'),
            ],
        ]);

        // Get all permissions
        $permissions = $this->db->table('permissions')->select('permission_id')->get()->getResultArray();
        
        // Administrator gets ALL permissions
        $adminPermissions = [];
        foreach ($permissions as $perm) {
            $adminPermissions[] = [
                'role_id'       => 1,
                'permission_id' => $perm['permission_id'],
                'menu_group'    => 'both',
            ];
        }
        if (!empty($adminPermissions)) {
            $this->db->table('role_permissions')->insertBatch($adminPermissions);
        }

        // Manager gets most permissions except system config
        $managerPermissions = [
            ['role_id' => 2, 'permission_id' => 'sales', 'menu_group' => 'home'],
            ['role_id' => 2, 'permission_id' => 'items', 'menu_group' => 'both'],
            ['role_id' => 2, 'permission_id' => 'customers', 'menu_group' => 'both'],
            ['role_id' => 2, 'permission_id' => 'suppliers', 'menu_group' => 'office'],
            ['role_id' => 2, 'permission_id' => 'receivings', 'menu_group' => 'office'],
            ['role_id' => 2, 'permission_id' => 'reports', 'menu_group' => 'both'],
            ['role_id' => 2, 'permission_id' => 'giftcards', 'menu_group' => 'both'],
            ['role_id' => 2, 'permission_id' => 'employees', 'menu_group' => 'office'],
            ['role_id' => 2, 'permission_id' => 'office', 'menu_group' => 'both'],
            ['role_id' => 2, 'permission_id' => 'home', 'menu_group' => 'both'],
        ];
        $this->db->table('role_permissions')->insertBatch($managerPermissions);

        // Cashier gets sales and customer permissions
        $cashierPermissions = [
            ['role_id' => 3, 'permission_id' => 'sales', 'menu_group' => 'home'],
            ['role_id' => 3, 'permission_id' => 'customers', 'menu_group' => 'home'],
            ['role_id' => 3, 'permission_id' => 'giftcards', 'menu_group' => 'home'],
            ['role_id' => 3, 'permission_id' => 'home', 'menu_group' => 'home'],
        ];
        $this->db->table('role_permissions')->insertBatch($cashierPermissions);

        // Stock Manager gets inventory permissions
        $stockPermissions = [
            ['role_id' => 4, 'permission_id' => 'items', 'menu_group' => 'office'],
            ['role_id' => 4, 'permission_id' => 'item_kits', 'menu_group' => 'office'],
            ['role_id' => 4, 'permission_id' => 'receivings', 'menu_group' => 'office'],
            ['role_id' => 4, 'permission_id' => 'suppliers', 'menu_group' => 'office'],
            ['role_id' => 4, 'permission_id' => 'office', 'menu_group' => 'office'],
        ];
        $this->db->table('role_permissions')->insertBatch($stockPermissions);

        // Assign role_id = 1 (Administrator) to person_id = 1
        $this->db->table('employees')->update(['role_id' => 1], ['person_id' => 1]);
    }

    public function down()
    {
        // Remove foreign key from employees
        $this->db->query('ALTER TABLE ' . $this->db->prefixTable('employees') . ' DROP FOREIGN KEY fk_employees_role');
        
        // Remove role_id column from employees
        $this->forge->dropColumn('employees', 'role_id');
        
        // Drop tables
        $this->forge->dropTable('role_permissions', true);
        $this->forge->dropTable('roles', true);
    }
}
