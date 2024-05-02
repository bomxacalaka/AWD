<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddContentColumnToPages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pages', [
            'content' => ['type' => 'TEXT', 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pages', 'content');
    }
}