<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 regular users with password '1234password'
        User::factory(3)->create([
            'password' => bcrypt('1234password'),
        ]);

        // Create admin user with password '1234password'
        User::factory()->create([
            'name'     => 'Meyor',
            'email'    => 'meyorpop@gmail.com',
            'password' => bcrypt('1234password'),
        ]);
    }
}
