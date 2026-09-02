<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgressTable extends Migration
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

            'sub_wilayah_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'masa_sidang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'sop_step_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum', 'proses', 'selesai'],
                'default'    => 'belum',
            ],

            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'tanggal_update' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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

        $this->forge->addUniqueKey([
            'sub_wilayah_id',
            'masa_sidang_id',
            'sop_step_id'
        ]);

        $this->forge->addForeignKey(
            'sub_wilayah_id',
            'sub_wilayah',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'masa_sidang_id',
            'masa_sidang',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'sop_step_id',
            'sop_steps',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'updated_by',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('progress');
    }

    public function down()
    {
        $this->forge->dropTable('progress');
    }
}