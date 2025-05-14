<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $json = File::get(database_path('seeders/data/users.json'));
        $users = json_decode($json, true);

        foreach ($users as $data) {
            User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'gym_id' => $data['gym_id'],
                'age' => $data['age'],
                'favorite_exercises' => $data['favorite_exercises'],
                'goals' => $data['goals'],
                'hobbies' => $data['hobbies'],
                'photo' => $data['photo']
            ]);
        }
    }
}
