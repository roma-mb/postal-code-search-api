<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ];

        if(User::where($data)->get()->isEmpty()) {
            User::factory()->create($data);
        }
    }
}
