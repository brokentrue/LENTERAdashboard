<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CheckTracingSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT sop_step_id, COUNT(*) AS jumlah
            FROM sop_tracing_steps
            GROUP BY sop_step_id
            ORDER BY sop_step_id
        ");

        foreach ($query->getResultArray() as $row) {
            echo $row['sop_step_id'] . " -> " . $row['jumlah'] . PHP_EOL;
        }

        $total = $db->query("
            SELECT COUNT(*) AS total
            FROM sop_tracing_steps
        ")->getRow()->total;

        echo "TOTAL -> " . $total . PHP_EOL;
    }
}