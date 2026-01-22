<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPesanMotivasiToKelas extends Migration
{
    public function up()
    {
        $fields = [
            'pesan_motivasi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => 'Ayo kumpulkan poin hari ini dan jadilah juara!',
            ],
        ];
        $this->forge->addColumn('kelas', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('kelas', 'pesan_motivasi');
    }
}