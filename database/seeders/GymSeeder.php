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
        $firstline = true;

        foreach ($lines as $line) {
            if ($firstline) {
                $firstline = false;
                continue;
            }

            $name = trim($line);
            if ($name !== '') {
                Gym::firstOrCreate(['name' => $name]);
            }
        }
    }
}
