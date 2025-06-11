<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKolomBaru extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'password'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user', ['alamat']);
    }
}
