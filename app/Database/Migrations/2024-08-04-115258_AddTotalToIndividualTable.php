<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTotalToIndividualTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('individual_meal', [
            'total' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
             
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('individual_meal', 'total');
    }

}
