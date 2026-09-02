<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgressTracingTable extends Migration
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

            'progress_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'tracing_step_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'status' => [
                'type' => 'ENUM',
                'constraint' => ['belum', 'proses', 'selesai'],
                'null' => true,
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

        $this->forge->addKey(
            ['progress_id', 'tracing_step_id'],
            false,
            true
        );

        $this->forge->addForeignKey(
            'progress_id',
            'progress',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'tracing_step_id',
            'sop_tracing_steps',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('progress_tracing');
    }

    public function down()
    {
        $this->forge->dropTable('progress_tracing', true);
    }
}