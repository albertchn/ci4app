<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Orang extends Migration
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
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'created_at' => [
                'type'      => 'DATETIME',
                'null'      => true
            ],
            'updated_at' => [
                'type'      => 'DATETIME',
                'null'      => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('orang');
    }

    public function down()
    {
        $this->forge->dropTable('orang');
    }
}
