<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gym;
use Illuminate\Support\Facades\Storage;

class GymSeeder extends Seeder {
    public function run(): void {
        $path = storage_path('app/gimnasios.csv');
        $lines = file($path, FILE_IGNORE_NEW_LINES);
        $gyms = array_slice($lines, 1);
        foreach ($gyms as $name) {
            Gym::create(['name' => trim($name)]);
        }
    }

}
