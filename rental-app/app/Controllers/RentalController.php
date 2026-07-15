<?php

namespace App\Controllers;

use App\Models\RentalModel;
use App\Models\VehicleModel;
use App\Models\CustomerModel;
use CodeIgniter\API\ResponseTrait;

class RentalController extends BaseController
{
    use ResponseTrait;
    protected $rentalModel;
    protected $vehicleModel;
    protected $customerModel;

    public function __construct()
    {
        $this->rentalModel = new RentalModel();
        $this->vehicleModel = new VehicleModel();
        $this->customerModel = new CustomerModel();
    }

    /**
     * Display list of all rentals
     */
    public function index()
    {
        $rentals = $this->rentalModel->getAllRentalsWithDetails();
        return view('rental/index', ['rentals' => $rentals]);
    }

    /**
     * Display create rental form
     */
    public function create()
    {
        $vehicles = $this->vehicleModel->getAvailableVehicles();
        $customers = $this->customerModel->getActiveCustomers();
        return view('rental/create', ['vehicles' => $vehicles, 'customers' => $customers]);
    }

    /**
     * Store new rental
     */
    public function store()
    {
        $rules = [
            'customer_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'tanggal_sewa' => 'required|valid_date',
            'tanggal_kembali' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $customer_id = $this->request->getPost('customer_id');
        $vehicle_id = $this->request->getPost('vehicle_id');
        $tanggal_sewa = $this->request->getPost('tanggal_sewa');
        $tanggal_kembali = $this->request->getPost('tanggal_kembali');

        // Get vehicle price
        $vehicle = $this->vehicleModel->find($vehicle_id);
        if (!$vehicle) {
            return redirect()->back()->with('error', 'Kendaraan tidak ditemukan');
        }

        // Calculate rental days and total price
        $start = new \DateTime($tanggal_sewa);
        $end = new \DateTime($tanggal_kembali);
        $interval = $start->diff($end);
        $total_hari = $interval->days + 1;
        $total_harga = $total_hari * $vehicle['harga_perhari'];

        $data = [
            'customer_id' => $customer_id,
            'vehicle_id' => $vehicle_id,
            'tanggal_sewa' => $tanggal_sewa,
            'tanggal_kembali' => $tanggal_kembali,
            'harga_perhari' => $vehicle['harga_perhari'],
            'total_hari' => $total_hari,
            'total_harga' => $total_harga,
            'status' => 'aktif',
        ];

        if ($this->rentalModel->save($data)) {
            // Update vehicle status
            $this->vehicleModel->updateStatus($vehicle_id, 'dipinjam');
            return redirect()->to('rental')->with('success', 'Sewa kendaraan berhasil dibuat');
        } else {
            return redirect()->back()->with('error', 'Gagal membuat sewa kendaraan');
        }
    }

    /**
     * Display rental details
     */
    public function view($id)
    {
        $rental = $this->rentalModel->getRentalDetail($id);
        if (!$rental) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sewa tidak ditemukan');
        }

        return view('rental/view', ['rental' => $rental]);
    }

    /**
     * Complete rental
     */
    public function complete($id)
    {
        $rental = $this->rentalModel->find($id);
        if (!$rental) {
            return redirect()->back()->with('error', 'Sewa tidak ditemukan');
        }

        $rules = [
            'tanggal_kembali_actual' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $actual_return_date = $this->request->getPost('tanggal_kembali_actual');

        // Calculate late fee
        $denda = $this->rentalModel->calculateLateFee($id);

        $data = [
            'tanggal_kembali_actual' => $actual_return_date,
            'denda' => $denda,
            'status' => 'selesai',
        ];

        if ($this->rentalModel->update($id, $data)) {
            // Update vehicle status back to available
            $this->vehicleModel->updateStatus($rental['vehicle_id'], 'tersedia');
            return redirect()->to('rental')->with('success', 'Pengembalian kendaraan berhasil dicatat');
        } else {
            return redirect()->back()->with('error', 'Gagal mencatat pengembalian kendaraan');
        }
    }

    /**
     * Cancel rental
     */
    public function cancel($id)
    {
        $rental = $this->rentalModel->find($id);
        if (!$rental) {
            return redirect()->back()->with('error', 'Sewa tidak ditemukan');
        }

        if ($this->rentalModel->update($id, ['status' => 'dibatalkan'])) {
            // Update vehicle status back to available
            $this->vehicleModel->updateStatus($rental['vehicle_id'], 'tersedia');
            return redirect()->to('rental')->with('success', 'Sewa berhasil dibatalkan');
        } else {
            return redirect()->back()->with('error', 'Gagal membatalkan sewa');
        }
    }

    /**
     * Get active rentals (API)
     */
    public function getActive()
    {
        $rentals = $this->rentalModel->getActiveRentals();
        return $this->respond($rentals);
    }

    /**
     * Get customer rentals (API)
     */
    public function getCustomerRentals($customer_id)
    {
        $rentals = $this->rentalModel->getRentalsByCustomer($customer_id);
        return $this->respond($rentals);
    }
}
