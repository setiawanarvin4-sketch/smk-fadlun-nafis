<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@smkfadlunnafis.sch.id')],
            [
                'name' => env('ADMIN_NAME', 'Administrator'),
                'password' => env('ADMIN_PASSWORD', 'ChangeThisPassword123!'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}