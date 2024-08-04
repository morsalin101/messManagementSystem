<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdToMealTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('meal', [
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('meal', 'id');
    }
}
