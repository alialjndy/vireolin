<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultImages = ['one.jpg', 'two.jpg', 'three.jpg' ,'four.jpg', 'five.jpg' ,'six.jpg' ,'seven.jpg', 'eight.jpg', 'nine.jpg'];
        ServiceType::factory()->count(10)->create()->each(function($serviceType) use ($defaultImages) {

            // Optionally, you can create related images or other data here
            $serviceType->images()->create([
                'image_path' => 'Images/' . $defaultImages[array_rand($defaultImages)],
            ]);
        });
    }
}
