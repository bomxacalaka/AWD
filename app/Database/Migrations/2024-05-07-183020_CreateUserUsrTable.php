<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserUsrTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_usr' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'firstname_usr' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'email_usr' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => false,
            ],
            'password_usr' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'ppicture_usr' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_usr', true);
        $this->forge->createTable('user_usr2');
    }

    public function down()
    {
        $this->forge->dropTable('user_usr2');
    }
}
