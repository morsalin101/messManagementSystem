<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBazarTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'member_uuid' => [
                'type'           => 'VARCHAR',
                'constraint'     => '36',
            ],
            'meal_uuid' => [
                'type'           => 'VARCHAR',
                'constraint'     => '36',
            ],
            'date' => [
                'type'           => 'DATE',
            ],
            'details' => [
                'type'           => 'TEXT',
            ],
            'total' => [
                'type'           => 'VARCHAR',
                'constraint'     => '36',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bazars');
    }

    public function down()
    {
        $this->forge->dropTable('bazars');
    }
}
