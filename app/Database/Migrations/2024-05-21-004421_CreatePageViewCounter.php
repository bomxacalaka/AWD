<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePageViewCounter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'page'        => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'views'       => [
                'type'       => 'INT',
                'constraint' => 9,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('page_view_counter');
    }

    public function down()
    {
        $this->forge->dropTable('page_view_counter');
    }
}
