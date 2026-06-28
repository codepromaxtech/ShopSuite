<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSalesCashupId extends Migration
{
    public function up(): void
    {
        if (!$this->db->fieldExists('cashup_id', 'sales')) {
            $this->forge->addColumn('sales', [
                'cashup_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'sale_type',
                ],
            ]);

            $this->forge->addKey('cashup_id');
        }
    }

    public function down(): void
    {
        if ($this->db->fieldExists('cashup_id', 'sales')) {
            $this->forge->dropColumn('sales', 'cashup_id');
        }
    }
}
