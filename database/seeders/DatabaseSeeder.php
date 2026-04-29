<?php

namespace Database\Seeders;

use Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "Critiqly Admin",
            "username" => "Admin",
            "email" => "admin@critiqly.com",
            "password" => Hash::make("CritiqlyAdmin1"),
            "is_admin" => true,
        ]);

        User::factory(10)->create();
        $this->call([
            MovieSeeder::class,
            RatingSeeder::class,
            AdminDataSeeder::class
        ]);




    }
}
