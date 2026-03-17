<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $ceps = [
            '01310100' => 'Bela Vista',
            '04543011' => 'Itaim Bibi',
            '22041080' => 'Copacabana',
            '30130100' => 'Centro',
            '80240020' => 'Centro',
            '40020000' => 'Centro',
            '70040902' => 'Asa Sul',
            '13015900' => 'Centro',
            '80010000' => 'Centro',
            '20040020' => 'Centro',
        ];

        $cep = (string) array_key_first($ceps);
        $bairro = $ceps[$cep];

        if ($this->faker->boolean(60)) {
            $cep = str_pad((string) $this->faker->numberBetween(1000000, 99999999), 8, '0');
            $bairro = $this->faker->randomElement([
                'Centro', 'Jardins', 'Vila Nova', 'São Paulo', 'Copacabana',
                'Ipanema', 'Botafogo', 'Flamengo', 'Laranjeiras', 'Tijuca',
            ]);
        }

        $nomes = [
            'Cubo Mágico 3x3', 'Cubo Mágico 2x2', 'Piramix', 'Megaminx', 'Cubo 4x4',
            'Cubo 5x5', 'Skewb', 'Square-1', 'Cubo Mágico Speed', 'Cubo Infantil',
            'Kit Lubrificante para Cubos', 'Timer de Cubo Mágico', 'Bolsa para Cubos',
            'Cubo Espelhado', 'Cubo Impossível',
        ];

        $descricoes = [
            'Cubo de alta qualidade, ideal para iniciantes e avançados.',
            'Perfeito para prática de speedcubing.',
            'Ótimo estado de conservação.',
            'Produto novo na embalagem.',
            'Ideal para presentear.',
        ];

        return [
            'nome' => $this->faker->randomElement($nomes),
            'descricao' => $this->faker->randomElement($descricoes),
            'preco' => $this->faker->randomFloat(2, 15, 350),
            'cep' => $cep,
            'bairro' => $bairro,
        ];
    }
}
