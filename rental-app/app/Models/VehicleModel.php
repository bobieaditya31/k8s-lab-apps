<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['plat_nomor', 'merek', 'model', 'tipe', 'tahun', 'warna', 'harga_perhari', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'plat_nomor' => 'required|is_unique[vehicles.plat_nomor]',
        'merek' => 'required|string|max_length[50]',
        'model' => 'required|string|max_length[50]',
        'tipe' => 'required|in_list[mobil,motor,bus,truk]',
        'tahun' => 'required|integer',
        'warna' => 'required|string|max_length[30]',
        'harga_perhari' => 'required|decimal',
    ];

    /**
     * Get vehicle by ID
     */
    public function getVehicle($id)
    {
        return $this->find($id);
    }

    /**
     * Get all available vehicles
     */
    public function getAvailableVehicles()
    {
        return $this->where('status', 'tersedia')->findAll();
    }

    /**
     * Get vehicles by type
     */
    public function getVehiclesByType($tipe)
    {
        return $this->where('tipe', $tipe)->findAll();
    }

    /**
     * Update vehicle status
     */
    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}
