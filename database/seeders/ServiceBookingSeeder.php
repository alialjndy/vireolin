<?php

namespace Database\Seeders;

use App\Models\ServiceBooking;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class ServiceBookingSeeder extends Seeder
{
    use WithFaker ;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceBooking::factory()->count(10)->create();
    }
}
