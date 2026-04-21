<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCreatedAtToArtikel extends Migration
{
    public function up()
    {
        $this->forge->addColumn('artikel', [
            'created_at' => [
                'type'  => 'DATETIME',
                'null'  => true,
                'after' => 'status',
            ],
        ]);

        // Isi created_at dengan waktu sekarang untuk data yang sudah ada
        $this->db->query("UPDATE artikel SET created_at = NOW() WHERE created_at IS NULL");
    }

    public function down()
    {
        $this->forge->dropColumn('artikel', 'created_at');
    }
}