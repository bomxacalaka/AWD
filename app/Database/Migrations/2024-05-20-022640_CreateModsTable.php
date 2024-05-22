<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'forge_version_id' => [
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
        $this->forge->addForeignKey('forge_version_id', 'forge_versions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mods');
    }

    public function down()
    {
        $this->forge->dropTable('mods');
    }
}
