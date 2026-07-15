<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\API\ResponseTrait;

class CustomerController extends BaseController
{
    use ResponseTrait;
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    /**
     * Display list of all customers
     */
    public function index()
    {
        $customers = $this->customerModel->findAll();
        return view('customer/index', ['customers' => $customers]);
    }

    /**
     * Display create customer form
     */
    public function create()
    {
        return view('customer/create');
    }

    /**
     * Store new customer
     */
    public function store()
    {
        $rules = [
            'nama' => 'required|string|max_length[100]',
            'email' => 'required|valid_email|is_unique[customers.email]',
            'telepon' => 'required|string|max_length[15]',
            'alamat' => 'required|string',
            'nomor_identitas' => 'required|is_unique[customers.nomor_identitas]',
            'nomor_sim' => 'required|is_unique[customers.nomor_sim]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat' => $this->request->getPost('alamat'),
            'nomor_identitas' => $this->request->getPost('nomor_identitas'),
            'nomor_sim' => $this->request->getPost('nomor_sim'),
            'status' => 'aktif',
        ];

        if ($this->customerModel->save($data)) {
            return redirect()->to('customer')->with('success', 'Pelanggan berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan pelanggan');
        }
    }

    /**
     * Display edit form
     */
    public function edit($id)
    {
        $customer = $this->customerModel->find($id);
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pelanggan tidak ditemukan');
        }

        return view('customer/edit', ['customer' => $customer]);
    }

    /**
     * Update customer
     */
    public function update($id)
    {
        $rules = [
            'nama' => 'required|string|max_length[100]',
            'email' => 'required|valid_email',
            'telepon' => 'required|string|max_length[15]',
            'alamat' => 'required|string',
            'nomor_identitas' => 'required',
            'nomor_sim' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat' => $this->request->getPost('alamat'),
            'nomor_identitas' => $this->request->getPost('nomor_identitas'),
            'nomor_sim' => $this->request->getPost('nomor_sim'),
        ];

        if ($this->customerModel->update($id, $data)) {
            return redirect()->to('customer')->with('success', 'Pelanggan berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui pelanggan');
        }
    }

    /**
     * Delete customer
     */
    public function delete($id)
    {
        if ($this->customerModel->deactivateCustomer($id)) {
            return redirect()->to('customer')->with('success', 'Pelanggan berhasil dinonaktifkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menonaktifkan pelanggan');
        }
    }

    /**
     * Get active customers (API)
     */
    public function getActive()
    {
        $customers = $this->customerModel->getActiveCustomers();
        return $this->respond($customers);
    }
}
