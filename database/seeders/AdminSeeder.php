<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert a sample admin user
        DB::table('admins')->insert([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);

        // Add more seed data as needed
    }
}
