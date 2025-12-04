<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Delivery;

class DeliveriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveries = [
            [
                'store_id' => 1,
                'rider_id' => 1,
                'pickup_address' => '123 Store Street, Manila',
                'dropoff_address' => '456 Customer Avenue, Quezon City',
                'amount' => 150.50,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ],
            [
                'store_id' => 1,
                'rider_id' => 2,
                'pickup_address' => '789 Market Road, Makati',
                'dropoff_address' => '321 Residential Lane, Pasig',
                'amount' => 250.00,
                'status' => 'accepted',
                'payment_status' => 'unpaid',
            ],
            [
                'store_id' => 2,
                'rider_id' => 1,
                'pickup_address' => '555 Commerce Blvd, Taguig',
                'dropoff_address' => '888 Home Street, Mandaluyong',
                'amount' => 320.75,
                'status' => 'picked_up',
                'payment_status' => 'unpaid',
            ],
            [
                'store_id' => 2,
                'rider_id' => 2,
                'pickup_address' => '111 Shop Avenue, Paranaque',
                'dropoff_address' => '222 Condo Tower, BGC',
                'amount' => 180.00,
                'status' => 'in_transit',
                'payment_status' => 'unpaid',
            ],
            [
                'store_id' => 3,
                'rider_id' => 1,
                'pickup_address' => '333 Mall Drive, Alabang',
                'dropoff_address' => '444 Village Road, Las Pinas',
                'amount' => 420.50,
                'status' => 'delivered',
                'payment_status' => 'paid',
            ],
            [
                'store_id' => 3,
                'rider_id' => null,
                'pickup_address' => '666 Business Center, Ortigas',
                'dropoff_address' => '777 Subdivision, Cainta',
                'amount' => 95.00,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ],
            [
                'store_id' => 1,
                'rider_id' => 3,
                'pickup_address' => '999 Plaza Mall, Cubao',
                'dropoff_address' => '101 Apartment Complex, Marikina',
                'amount' => 275.25,
                'status' => 'cancelled',
                'payment_status' => 'unpaid',
            ],
        ];

        foreach ($deliveries as $delivery) {
            Delivery::create($delivery);
        }
    }
}
