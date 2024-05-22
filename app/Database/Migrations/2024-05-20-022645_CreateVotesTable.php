<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVotesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'mod_id' => [
                'type'       => 'INT',
                'unsigned'   => true
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
        $this->forge->addForeignKey('mod_id', 'mods', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('votes');
    }

    public function down()
    {
        $this->forge->dropTable('votes');
    }
}
