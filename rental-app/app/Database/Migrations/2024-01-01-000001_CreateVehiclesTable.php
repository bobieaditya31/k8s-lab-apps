<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVehiclesTable extends Migration
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
            'plat_nomor' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'merek' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'model' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'tipe' => [
                'type' => 'ENUM',
                'constraint' => ['mobil', 'motor', 'bus', 'truk'],
                'default' => 'mobil',
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'warna' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'harga_perhari' => [
                'type' => 'DECIMAL',
                'constraint' => [10, 2],
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['tersedia', 'dipinjam', 'maintenance'],
                'default' => 'tersedia',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', false, true);
        $this->forge->createTable('vehicles');
    }

    public function down()
    {
        $this->forge->dropTable('vehicles');
    }
}
