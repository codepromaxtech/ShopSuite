<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBackupsModule extends Migration
{
    public function up(): void
    {
        // 1. Create backups table
        $this->forge->addField([
            'backup_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_size' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'backup_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'manual',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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

        $this->forge->addKey('backup_id', true);
        $this->forge->createTable('shopsuite_backups', true);

        // 2. Register the backups module
        $this->db->table('shopsuite_modules')->ignore(true)->insert([
            'module_id'     => 'backups',
            'name_lang_key' => 'module_backups',
            'desc_lang_key' => 'module_backups_desc',
            'sort'          => 895,
        ]);

        // 3. Register the permission
        $this->db->table('shopsuite_permissions')->ignore(true)->insert([
            'permission_id' => 'backups',
            'module_id'     => 'backups',
            'location_id'   => null,
        ]);

        // 4. Grant access to admin (person_id = 1)
        $this->db->table('shopsuite_grants')->ignore(true)->insert([
            'permission_id' => 'backups',
            'person_id'     => 1,
            'menu_group'    => 'office',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('shopsuite_backups', true);

        $this->db->table('shopsuite_modules')->where('module_id', 'backups')->delete();
        $this->db->table('shopsuite_permissions')->where('permission_id', 'backups')->delete();
        $this->db->table('shopsuite_grants')->where('permission_id', 'backups')->delete();
    }
}
