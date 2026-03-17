<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition(): array
    {
        $titulos = [
            'Cubo mágico 3x3 novo', 'Piramix original', 'Kit 2 cubos + 1 piramix',
            'Megaminx profissional', 'Cubo 2x2 e 3x3 juntos', 'Cubo speed 3x3',
            'Vendo cubos mágicos diversos', 'Kit iniciante cubo mágico', 'Cubo 4x4 e 5x5',
            'Coleção de cubos - ótimo preço', 'Cubo mágico infantil', 'Timer + cubo 3x3',
            'Cubo espelhado raro', 'Dois cubos 3x3 novos', 'Piramix e Skewb',
            'Cubo mágico profissional', 'Kit completo speedcubing', 'Cubo 3x3 usado',
            'Vários cubos - liquidação', 'Cubo mágico para presente',
        ];

        $descricoes = [
            'Produto em excelente estado. Entrego na região.',
            'Vendo pois não uso mais. Aceito propostas.',
            'Novo, só abri para testar. Preço justo.',
            'Ideal para quem está começando no hobby.',
            'Entrego ou envio. Negócio fechado.',
        ];

        return [
            'titulo' => $this->faker->randomElement($titulos),
            'descricao' => $this->faker->randomElement($descricoes),
            'preco_venda' => $this->faker->randomFloat(2, 25, 800),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Ad $ad) {
            $products = Product::inRandomOrder()->limit(rand(1, 4))->get();
            if ($products->isEmpty()) {
                return;
            }
            $sync = [];
            foreach ($products as $p) {
                $sync[$p->id] = ['quantidade' => rand(1, 5)];
            }
            $ad->products()->sync($sync);
        });
    }
}
