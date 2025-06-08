<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKolomBaru extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'nama'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user', ['nim']);
    }
}
