<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gym;
use Illuminate\Support\Facades\File;

class GymSeeder extends Seeder
{
    public function run():void
    {
        $path = database_path('seeders/data/gyms.csv');
        $lines = File::lines($path);

        foreach ($lines as $line) {
            $name = trim($line);
            if ($name !== '') {
                Gym::firstOrCreate(['name' => $name]);
            }
        }
    }
}
