<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $accountTypes = collect([
            [
                'id' => Str::uuid()->toString(),
                'username' => 'admin',
                'password' => '123456',
                'show_name' => 'Admin',
                'active' => true,
            ],
        ]);

        $accountTypes->each(function (array $item) {
            $dbUser = DB::select('SELECT * FROM users WHERE username = ?', [$item['username']]);
            if (empty($dbUser)) {
                DB::insert('INSERT INTO users (id, username, password, show_name, active) VALUES(?, ?, ?, ?, ?)', [
                    $item['id'],
                    $item['username'],
                    $item['password'],
                    $item['show_name'],
                    $item['active'],
                ]);
            }
        });
    }
}
