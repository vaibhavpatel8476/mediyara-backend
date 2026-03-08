<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Default admin credentials (change in production):
     * Email: admin@mediyara.com
     * Password: password
     */
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'admin@mediyara.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
    }
}
