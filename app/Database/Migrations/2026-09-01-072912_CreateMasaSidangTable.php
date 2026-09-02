<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasaSidangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tahun' => [
                'type'       => 'YEAR',
                'constraint' => 4,
            ],
            'nomor' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
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

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['tahun', 'nomor']);
        $this->forge->createTable('masa_sidang');
    }

    public function down()
    {
        $this->forge->dropTable('masa_sidang');
    }
}