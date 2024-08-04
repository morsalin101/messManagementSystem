<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMoneyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'member_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'deposite' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'meal_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'date' => [
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('money');
    }

    public function down()
    {
        $this->forge->dropTable('money');
    }
}
