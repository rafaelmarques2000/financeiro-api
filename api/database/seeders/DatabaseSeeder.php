<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AccountTypeSeeder::class,
            UserSeeder::class,
            TransactionTypeSeeder::class,
            TransactionCategoriesSeeder::class,
        ]);
    }
}
