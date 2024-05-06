<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScoresTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'loss' => [
                'type' => 'FLOAT',
            ],
            'accuracy' => [
                'type' => 'FLOAT',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'model_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'dataset_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'model_timestamp' => [
                'type' => 'TIMESTAMP',
                'on update' => 'CURRENT_TIMESTAMP',
            ],
            'epoch_number' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            // Add any other fields here
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('scores');
    }

    public function down()
    {
        $this->forge->dropTable('scores');
    }
}
