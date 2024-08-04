<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMealTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'meal_uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => '36',
                'null'       => false,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'finished_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
        ]);

        // Set the primary key
        $this->forge->addKey('meal_uuid', true);

        // Create the table
        $this->forge->createTable('meal');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('meal');
    }
}
