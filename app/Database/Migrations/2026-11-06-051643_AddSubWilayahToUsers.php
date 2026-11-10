<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubWilayahToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'sub_wilayah_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'role_id',
            ],
        ]);

        $this->db->query(
            'ALTER TABLE users
             ADD CONSTRAINT fk_users_sub_wilayah
             FOREIGN KEY (sub_wilayah_id)
             REFERENCES sub_wilayah(id)
             ON UPDATE CASCADE
             ON DELETE RESTRICT'
        );
    }

    public function down()
    {
        $this->db->query(
            'ALTER TABLE users
             DROP FOREIGN KEY fk_users_sub_wilayah'
        );

        $this->forge->dropColumn('users', 'sub_wilayah_id');
    }
}
