<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'password'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'kampus'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'foto'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user');

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'password'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('admin');
    }

    public function down()
    {
        $this->forge->dropTable('user');
        $this->forge->dropTable('admin');
    }
}
