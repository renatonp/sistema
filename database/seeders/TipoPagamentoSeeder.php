<?php

namespace Database\Seeders;

use App\Models\TipoPagamento;
use Illuminate\Database\Seeder;

class TipoPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoPagamento::create([
            'pagamento' => 'Cartão',
        ]);
        TipoPagamento::create([
            'pagamento' => 'Dinheiro',
        ]);
        TipoPagamento::create([
            'pagamento' => 'PicPay',
        ]);
        TipoPagamento::create([
            'pagamento' => 'PIX',
        ]);
    }
}
