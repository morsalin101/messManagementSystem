<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIndividualMealTable extends Migration
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
            'date' => [
                'type' => 'DATE',
                'null' => false
            ],
            'launch' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'dinner' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'guest' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'member_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'meal_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('individual_meal');
    }

    public function down()
    {
        $this->forge->dropTable('individual_meal');
    }
}
