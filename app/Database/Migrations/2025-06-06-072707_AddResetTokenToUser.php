<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResetTokenToUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [
            'reset_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'password'
            ],
            'reset_token_expire' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'reset_token'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user', ['reset_token', 'reset_token_expire']);
    }
}
