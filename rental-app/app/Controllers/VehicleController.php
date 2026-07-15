<?php

namespace App\Controllers;

use App\Models\VehicleModel;
use CodeIgniter\API\ResponseTrait;

class VehicleController extends BaseController
{
    use ResponseTrait;
    protected $vehicleModel;

    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
    }

    /**
     * Display list of all vehicles
     */
    public function index()
    {
        $vehicles = $this->vehicleModel->findAll();
        return view('vehicle/index', ['vehicles' => $vehicles]);
    }

    /**
     * Display create vehicle form
     */
    public function create()
    {
        return view('vehicle/create');
    }

    /**
     * Store new vehicle
     */
    public function store()
    {
        $rules = [
            'plat_nomor' => 'required|is_unique[vehicles.plat_nomor]',
            'merek' => 'required',
            'model' => 'required',
            'tipe' => 'required|in_list[mobil,motor,bus,truk]',
            'tahun' => 'required|integer',
            'warna' => 'required',
            'harga_perhari' => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'plat_nomor' => $this->request->getPost('plat_nomor'),
            'merek' => $this->request->getPost('merek'),
            'model' => $this->request->getPost('model'),
            'tipe' => $this->request->getPost('tipe'),
            'tahun' => $this->request->getPost('tahun'),
            'warna' => $this->request->getPost('warna'),
            'harga_perhari' => $this->request->getPost('harga_perhari'),
            'status' => 'tersedia',
        ];

        if ($this->vehicleModel->save($data)) {
            return redirect()->to('vehicle')->with('success', 'Kendaraan berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan kendaraan');
        }
    }

    /**
     * Display edit form
     */
    public function edit($id)
    {
        $vehicle = $this->vehicleModel->find($id);
        if (!$vehicle) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kendaraan tidak ditemukan');
        }

        return view('vehicle/edit', ['vehicle' => $vehicle]);
    }

    /**
     * Update vehicle
     */
    public function update($id)
    {
        $rules = [
            'plat_nomor' => 'required',
            'merek' => 'required',
            'model' => 'required',
            'tipe' => 'required|in_list[mobil,motor,bus,truk]',
            'tahun' => 'required|integer',
            'warna' => 'required',
            'harga_perhari' => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'plat_nomor' => $this->request->getPost('plat_nomor'),
            'merek' => $this->request->getPost('merek'),
            'model' => $this->request->getPost('model'),
            'tipe' => $this->request->getPost('tipe'),
            'tahun' => $this->request->getPost('tahun'),
            'warna' => $this->request->getPost('warna'),
            'harga_perhari' => $this->request->getPost('harga_perhari'),
        ];

        if ($this->vehicleModel->update($id, $data)) {
            return redirect()->to('vehicle')->with('success', 'Kendaraan berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui kendaraan');
        }
    }

    /**
     * Delete vehicle
     */
    public function delete($id)
    {
        if ($this->vehicleModel->delete($id)) {
            return redirect()->to('vehicle')->with('success', 'Kendaraan berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus kendaraan');
        }
    }

    /**
     * Get available vehicles (API)
     */
    public function getAvailable()
    {
        $vehicles = $this->vehicleModel->getAvailableVehicles();
        return $this->respond($vehicles);
    }

    /**
     * Get vehicles by type (API)
     */
    public function getByType($type)
    {
        $vehicles = $this->vehicleModel->getVehiclesByType($type);
        return $this->respond($vehicles);
    }
}
