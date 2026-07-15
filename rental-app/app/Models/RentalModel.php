<?php

namespace App\Models;

use CodeIgniter\Model;

class RentalModel extends Model
{
    protected $table = 'rentals';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['customer_id', 'vehicle_id', 'tanggal_sewa', 'tanggal_kembali', 
                                 'tanggal_kembali_actual', 'harga_perhari', 'total_hari', 'total_harga', 
                                 'denda', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'customer_id' => 'required|integer',
        'vehicle_id' => 'required|integer',
        'tanggal_sewa' => 'required|valid_date',
        'tanggal_kembali' => 'required|valid_date',
        'harga_perhari' => 'required|decimal',
        'total_hari' => 'required|integer',
        'total_harga' => 'required|decimal',
    ];

    /**
     * Get rental with customer and vehicle details
     */
    public function getRentalDetail($id)
    {
        return $this->select('rentals.*, customers.nama as customer_nama, customers.telepon, vehicles.plat_nomor, vehicles.merek, vehicles.model')
                    ->join('customers', 'customers.id = rentals.customer_id')
                    ->join('vehicles', 'vehicles.id = rentals.vehicle_id')
                    ->find($id);
    }

    /**
     * Get all rentals with details
     */
    public function getAllRentalsWithDetails()
    {
        return $this->select('rentals.*, customers.nama as customer_nama, vehicles.plat_nomor, vehicles.merek, vehicles.model')
                    ->join('customers', 'customers.id = rentals.customer_id')
                    ->join('vehicles', 'vehicles.id = rentals.vehicle_id')
                    ->findAll();
    }

    /**
     * Get active rentals
     */
    public function getActiveRentals()
    {
        return $this->select('rentals.*, customers.nama as customer_nama, vehicles.plat_nomor, vehicles.merek, vehicles.model')
                    ->join('customers', 'customers.id = rentals.customer_id')
                    ->join('vehicles', 'vehicles.id = rentals.vehicle_id')
                    ->where('rentals.status', 'aktif')
                    ->findAll();
    }

    /**
     * Get rentals by customer
     */
    public function getRentalsByCustomer($customer_id)
    {
        return $this->select('rentals.*, vehicles.plat_nomor, vehicles.merek, vehicles.model')
                    ->join('vehicles', 'vehicles.id = rentals.vehicle_id')
                    ->where('rentals.customer_id', $customer_id)
                    ->findAll();
    }

    /**
     * Calculate late fee
     */
    public function calculateLateFee($rental_id, $daily_fee = 50000)
    {
        $rental = $this->find($rental_id);
        if (!$rental) return 0;

        $return_date = new \DateTime($rental['tanggal_kembali']);
        $actual_return_date = $rental['tanggal_kembali_actual'] ? new \DateTime($rental['tanggal_kembali_actual']) : new \DateTime();

        if ($actual_return_date > $return_date) {
            $late_days = $actual_return_date->diff($return_date)->days;
            return $late_days * $daily_fee;
        }

        return 0;
    }

    /**
     * Complete rental
     */
    public function completeRental($rental_id, $actual_return_date)
    {
        $data = [
            'tanggal_kembali_actual' => $actual_return_date,
            'status' => 'selesai'
        ];

        return $this->update($rental_id, $data);
    }
}
