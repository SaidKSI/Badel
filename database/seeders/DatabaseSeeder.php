<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $files = [
            'database/seeders/db_table_seeder/admins.sql',
            'database/seeders/db_table_seeder/fees.sql',
            'database/seeders/db_table_seeder/transactions.sql',
            'database/seeders/db_table_seeder/sous_banks.sql',
            'database/seeders/db_table_seeder/users.sql',
        ];
    
        // Iterate through each SQL file
        foreach ($files as $file) {
            // Read the SQL file
            $sql = file_get_contents($file);
    
            // Execute the SQL queries
            DB::unprepared($sql);
        }
    }
    
}
