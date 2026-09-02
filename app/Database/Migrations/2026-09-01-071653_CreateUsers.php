<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
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
        'name' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
        ],
        'username' => [
            'type'       => 'VARCHAR',
            'constraint' => 50,
        ],
        'password' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
        ],
        'role_id' => [
            'type'       => 'INT',
            'constraint' => 11,
            'unsigned'   => true,
        ],
        'is_active' => [
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => 1,
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
    $this->forge->addUniqueKey('username');

    $this->forge->addForeignKey(
        'role_id',
        'roles',
        'id',
        'CASCADE',
        'RESTRICT'
    );

    $this->forge->createTable('users');
}

    public function down()
{
    $this->forge->dropTable('users');
}
}
