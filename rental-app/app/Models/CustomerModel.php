<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'email', 'telepon', 'alamat', 'nomor_identitas', 'nomor_sim', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'nama' => 'required|string|max_length[100]',
        'email' => 'required|valid_email|is_unique[customers.email]',
        'telepon' => 'required|string|max_length[15]',
        'alamat' => 'required|string',
        'nomor_identitas' => 'required|is_unique[customers.nomor_identitas]',
        'nomor_sim' => 'required|is_unique[customers.nomor_sim]',
    ];

    /**
     * Get customer by ID
     */
    public function getCustomer($id)
    {
        return $this->find($id);
    }

    /**
     * Get customer by email
     */
    public function getCustomerByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get all active customers
     */
    public function getActiveCustomers()
    {
        return $this->where('status', 'aktif')->findAll();
    }

    /**
     * Deactivate customer
     */
    public function deactivateCustomer($id)
    {
        return $this->update($id, ['status' => 'nonaktif']);
    }
}
