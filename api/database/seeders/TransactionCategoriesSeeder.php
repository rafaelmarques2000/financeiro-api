<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionCategoriesSeeder extends Seeder
{
    public function run()
    {
        $this->getTransactionCategoriesReceita()
            ->merge($this->getTransactionCategoriesDespesa()
            ->toArray())
            ->each(function ($item) {
                $dbTypeCategory = DB::select('SELECT * FROM transaction_categories WHERE slug_name = ?', [$item['slugname']]);
                if (empty($dbTypeCategory)) {
                    DB::insert('INSERT INTO transaction_categories (id, description, type_transaction_id, slug_name) VALUES(?, ? , ?, ?)', [
                        $item['id'],
                        $item['description'],
                        $item['type_transaction_id'],
                        $item['slugname'],
                    ]);
                }else{
                    DB::update('UPDATE transaction_categories SET description=?, type_transaction_id=? WHERE slug_name = ?',[
                       $item['description'],
                       $item['type_transaction_id'],
                       $item['slugname']
                    ]);
                }
            });
    }

    private function getTransactionCategoriesReceita(): Collection
    {
        $typeCategorieReceita = DB::selectOne('SELECT * FROM type_transaction WHERE slug_name=?', ['receita']);

        return collect([
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Salário mensal',
                'slugname' => 'salario_mensal',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Décimo terceiro salário',
                'slugname' => 'decimo_terceiro_salario',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Férias',
                'slugname' => 'ferias',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Adiantamento de salário',
                'slugname' => 'adiantamento_salario',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Empréstimo',
                'slugname' => 'emprestimo',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Vendas',
                'slugname' => 'vendas',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Renda extra',
                'slugname' => 'renda_extra',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Ajuste de saldo',
                'slugname' => 'ajuste_saldo',
                'type_transaction_id' => $typeCategorieReceita->id,
            ],
        ]);
    }

    private function getTransactionCategoriesDespesa(): Collection
    {
        $typeCategorieDespesa = DB::selectOne('SELECT * FROM type_transaction WHERE slug_name=?', ['despesa']);

        return collect([
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Alimentação',
                'slugname' => 'alimentacao',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Contas da casa',
                'slugname' => 'contas_da_casa',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Transporte',
                'slugname' => 'transporte',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Empréstimos',
                'slugname' => 'emprestimo',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Itens de beleza e vestuário',
                'slugname' => 'beleza_vestuario',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Itens de tecnologia',
                'slugname' => 'itens_tecnologia',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Itens domésticos',
                'slugname' => 'itens_domestico',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Games e entretenimento',
                'slugname' => 'games_entretenimento',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Reserva financeira',
                'slugname' => 'reserva_financeira',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Saúde',
                'slugname' => 'saude',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Estudos',
                'slugname' => 'estudos',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Serviços contratados',
                'slugname' => 'servicos_contratados',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Serviços de assinatura',
                'slugname' => 'servicos_assinatura',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Ajuste de saldo',
                'slugname' => 'ajuste_saldo',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Despesa financeira',
                'slugname' => 'despesa_financeira',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
            [
                'id' => Str::uuid()->toString(),
                'description' => 'Outros',
                'slugname' => 'outros',
                'type_transaction_id' => $typeCategorieDespesa->id,
            ],
        ]);
    }
}
