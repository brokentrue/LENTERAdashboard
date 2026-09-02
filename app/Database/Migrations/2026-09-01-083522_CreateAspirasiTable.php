<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAspirasiTable extends Migration
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

            'masa_sidang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'sub_wilayah_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'provinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'sumber' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'isu' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'uraian' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Baru',
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

        $this->forge->addForeignKey(
            'masa_sidang_id',
            'masa_sidang',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'sub_wilayah_id',
            'sub_wilayah',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('aspirasi');
    }

    public function down()
    {
        $this->forge->dropTable('aspirasi');
    }
}