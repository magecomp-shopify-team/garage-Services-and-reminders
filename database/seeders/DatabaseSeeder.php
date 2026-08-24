<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\Mechanic;
use App\Models\SparePart;
use App\Models\JobCard;
use App\Models\JobCardService;
use App\Models\JobCardPart;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@garagepro.test',
            'password' => Hash::make('password'),
        ]);

        // Workshops
        $workshop1 = \App\Models\Workshop::create([
            'name' => 'Downtown Auto Care',
            'address' => '123 Main St, New York',
            'phone' => '555-0100',
        ]);

        $workshop2 = \App\Models\Workshop::create([
            'name' => 'Uptown Garage',
            'address' => '456 North Ave, New York',
            'phone' => '555-0200',
        ]);

        // Users
        $roles = [
            'Manager' => 'manager@garagepro.test',
            'Mechanic' => 'mechanic@garagepro.test',
            'Accountant' => 'accountant@garagepro.test',
            'Receptionist' => 'receptionist@garagepro.test',
        ];

        foreach ($roles as $role => $email) {
            User::create([
                'name' => $role . ' User',
                'email' => $email,
                'role' => $role,
                'password' => Hash::make('password'),
                'workshop_id' => $workshop1->id, // Assign to Workshop 1
            ]);
        }
        
        // Add a second manager for testing multi-tenancy
        User::create([
            'name' => 'Manager 2',
            'email' => 'manager2@garagepro.test',
            'role' => 'Manager',
            'password' => Hash::make('password'),
            'workshop_id' => $workshop2->id,
        ]);

        // Mechanics (For the Workshop)
        $mechanic = Mechanic::create([
            'workshop_id' => $workshop1->id,
            'name' => 'John Doe',
            'mobile' => '9876543210',
            'specialization' => 'Engine Specialist',
        ]);

        // Services
        $services = [
            ['workshop_id' => $workshop1->id, 'name' => 'Oil Change', 'price' => 1500, 'category' => 'Maintenance'],
            ['workshop_id' => $workshop1->id, 'name' => 'Brake Service', 'price' => 2500, 'category' => 'Repair'],
            ['workshop_id' => $workshop1->id, 'name' => 'Full Service', 'price' => 8000, 'category' => 'Maintenance'],
            ['workshop_id' => $workshop1->id, 'name' => 'AC Service', 'price' => 3000, 'category' => 'Repair'],
            ['workshop_id' => $workshop1->id, 'name' => 'Wheel Alignment', 'price' => 800, 'category' => 'Maintenance'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Spare Parts
        $parts = [
            ['workshop_id' => $workshop1->id, 'name' => 'Engine Oil (Synthetic)', 'sku' => 'OIL001', 'purchase_price' => 1000, 'selling_price' => 1200, 'stock' => 50],
            ['workshop_id' => $workshop1->id, 'name' => 'Brake Pads (Front)', 'sku' => 'BRK001', 'purchase_price' => 800, 'selling_price' => 1500, 'stock' => 20],
            ['workshop_id' => $workshop1->id, 'name' => 'Air Filter', 'sku' => 'AIR001', 'purchase_price' => 300, 'selling_price' => 500, 'stock' => 3],
        ];

        foreach ($parts as $part) {
            SparePart::create($part);
        }

        // Customers
        $customer = Customer::create([
            'workshop_id' => $workshop1->id,
            'name' => 'Alice Smith',
            'mobile' => '9998887776',
            'email' => 'alice@example.com',
            'city' => 'New York',
        ]);
        
        $customer2 = Customer::create([
            'workshop_id' => $workshop2->id,
            'name' => 'Bob Jones (Workshop 2)',
            'mobile' => '1112223334',
            'email' => 'bob@example.com',
            'city' => 'New York',
        ]);

        // Vehicles
        $vehicle = Vehicle::create([
            'workshop_id' => $workshop1->id,
            'customer_id' => $customer->id,
            'registration_number' => 'NY-1234',
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => '2020',
            'fuel_type' => 'Petrol',
            'current_km' => 45000,
        ]);

        // Job Card
        $jobCard = JobCard::create([
            'workshop_id' => $workshop1->id,
            'job_number' => 'JC-1001',
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
            'mechanic_id' => $mechanic->id,
            'complaint' => 'Engine noise and AC not working',
            'current_km' => 45050,
            'status' => 'Completed',
            'received_date' => now()->subDays(2),
            'completed_date' => now(),
        ]);

        // Job Card Services & Parts
        JobCardService::create([
            'job_card_id' => $jobCard->id,
            'service_id' => 1, // Oil Change
            'quantity' => 1,
            'price' => 1500,
            'total' => 1500,
        ]);

        JobCardPart::create([
            'job_card_id' => $jobCard->id,
            'spare_part_id' => 1, // Engine Oil
            'quantity' => 1,
            'price' => 1200,
            'total' => 1200,
        ]);

        // Invoice
        $subtotal = 1500 + 1200;
        $tax = $subtotal * 0.18; // 18% tax
        $total = $subtotal + $tax;

        $invoice = Invoice::create([
            'workshop_id' => $workshop1->id,
            'invoice_number' => 'INV-1001',
            'job_card_id' => $jobCard->id,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'paid_amount' => $total,
            'balance' => 0,
            'status' => 'Paid',
        ]);

        // Payment
        Payment::create([
            'workshop_id' => $workshop1->id,
            'invoice_id' => $invoice->id,
            'amount' => $total,
            'payment_method' => 'Card',
            'payment_date' => now(),
        ]);
    }
}
