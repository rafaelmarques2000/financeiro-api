<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountTypeSeeder extends Seeder
{
    public function run()
    {
        $accountTypes = $this->getAccountTypeList();

        $accountTypes->each(function (array $item) {
            $dbAccount = DB::select('SELECT * FROM account_types WHERE slug_name = ?', [$item['slugname']]);
            if (empty($dbAccount)) {
                DB::insert('INSERT INTO account_types (id, description, slug_name, color) VALUES(?, ?, ?, ?)', [
                    $item['id'],
                    $item['description'],
                    $item['slugname'],
                    $item['color']
                ]);
            }
        });
    }

    private function getAccountTypeList(): Collection
    {
        return collect([
            [
                'id' => Str::uuid()->toString(),
                'slugname' => 'conta_corrente',
                'description' => 'Conta Corrente',
                'color' => '#FFB74B',
            ],
            [
                'id' => Str::uuid()->toString(),
                'slugname' => 'poupanca_reserva',
                'description' => 'Poupança/Reserva',
                'color' => '#2ea88c',
            ],
            [
                'id' => Str::uuid()->toString(),
                'slugname' => 'investimento',
                'description' => 'Investimento',
                'color' => '#a560cb',
            ],
            [
                'id' => Str::uuid()->toString(),
                'slugname' => 'cartao_credito',
                'description' => 'Cartão de crédito',
                'color' => '#f27966',
            ],
        ]);
    }
}
