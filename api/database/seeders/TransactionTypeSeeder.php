<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionTypeSeeder extends Seeder
{
    public function run()
    {
        $typeTransactions = $this->getTypeTransactions();
        $typeTransactions->each(function (array $item) {
            $dbAccount = DB::select('SELECT * FROM type_transaction WHERE slug_name = ?', [$item['slugname']]);
            if (empty($dbAccount)) {
                DB::insert('INSERT INTO type_transaction (id, description, slug_name) VALUES(?, ? , ?)', [
                    $item['id'],
                    $item['description'],
                    $item['slugname']
                ]);
            }
        });
    }

    private function getTypeTransactions(): Collection
    {
        return collect([
            [
                'id' => Str::uuid()->toString(),
                'slugname' => 'receita',
                'description' => 'Receita',
            ],
            [
                'id' => Str::uuid()->toString(),
                'slugname' => 'despesa',
                'description' => 'Despesa'
            ]
        ]);
    }
}
