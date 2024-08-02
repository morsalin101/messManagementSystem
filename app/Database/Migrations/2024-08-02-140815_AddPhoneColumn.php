<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhoneColumn extends Migration
{
    public function up()
    {
        $fields = [
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                 
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'phone');
    }
}
