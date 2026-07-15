<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRentalsTable extends Migration
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
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'vehicle_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tanggal_sewa' => [
                'type' => 'DATE',
            ],
            'tanggal_kembali' => [
                'type' => 'DATE',
            ],
            'tanggal_kembali_actual' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'harga_perhari' => [
                'type' => 'DECIMAL',
                'constraint' => [10, 2],
            ],
            'total_hari' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'total_harga' => [
                'type' => 'DECIMAL',
                'constraint' => [10, 2],
            ],
            'denda' => [
                'type' => 'DECIMAL',
                'constraint' => [10, 2],
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'selesai', 'dibatalkan'],
                'default' => 'aktif',
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
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('vehicle_id', 'vehicles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rentals');
    }

    public function down()
    {
        $this->forge->dropTable('rentals');
    }
}
