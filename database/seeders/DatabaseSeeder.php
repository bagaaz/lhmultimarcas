<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'name' => 'Gabriel Oliveira',
             'email' => 'admin@admin.com',
             'password' => bcrypt('Ga96911431@')
         ]);

        \App\Models\Product\Size::factory()->createMany([
            ['name' => 'Padrão'],
            ['name' => 'Único'],
            ['name' => 'PP'],
            ['name' => 'P'],
            ['name' => 'M'],
            ['name' => 'G'],
            ['name' => 'GG'],
            ['name' => 'XG'],
            ['name' => 'XGG'],
            ['name' => '32'],
            ['name' => '34'],
            ['name' => '36'],
            ['name' => '38'],
            ['name' => '40'],
            ['name' => '42'],
            ['name' => '44'],
            ['name' => '46'],
            ['name' => '48'],
            ['name' => '50'],
            ['name' => '52'],
            ['name' => '54'],
            ['name' => '56'],
            ['name' => '58'],
            ['name' => '60']
        ]);

        \App\Models\Product\Color::factory()->createMany([
            ['name' => 'Amarelo'],
            ['name' => 'Azul'],
            ['name' => 'Azul Claro'],
            ['name' => 'Azul Escuro'],
            ['name' => 'Azul Marinho'],
            ['name' => 'Azul Petróleo'],
            ['name' => 'Azul Royal'],
            ['name' => 'Bege'],
            ['name' => 'Bordô'],
            ['name' => 'Branco'],
            ['name' => 'Cinza'],
            ['name' => 'Cinza Claro'],
            ['name' => 'Cinza Escuro'],
            ['name' => 'Cinza Mescla'],
            ['name' => 'Coral'],
            ['name' => 'Dourado'],
            ['name' => 'Estampado'],
            ['name' => 'Fúcsia'],
            ['name' => 'Laranja'],
            ['name' => 'Lilás'],
            ['name' => 'Marrom'],
            ['name' => 'Marrom Claro'],
            ['name' => 'Marrom Escuro'],
            ['name' => 'Mostarda'],
            ['name' => 'Nude'],
            ['name' => 'Off White'],
            ['name' => 'Pink'],
            ['name' => 'Preto'],
            ['name' => 'Rosa'],
            ['name' => 'Rosa Claro'],
            ['name' => 'Rosa Escuro'],
            ['name' => 'Rosa Pink'],
            ['name' => 'Rosa Queimado'],
            ['name' => 'Roxo'],
            ['name' => 'Salmão'],
            ['name' => 'Terracota'],
            ['name' => 'Verde'],
            ['name' => 'Verde Água'],
            ['name' => 'Verde Claro'],
            ['name' => 'Verde Escuro'],
            ['name' => 'Verde Militar'],
            ['name' => 'Verde Musgo'],
            ['name' => 'Verde Oliva'],
            ['name' => 'Verde Petróleo'],
            ['name' => 'Verde Tiffany'],
            ['name' => 'Vermelho'],
            ['name' => 'Vermelho Escuro'],
            ['name' => 'Vinho']
        ]);

        \App\Models\Sales\PaymentMethod::factory()->createMany([
            ['name' => 'À Vista', 'tax' => 0.00],
            ['name' => 'Fiado', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 1x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 2x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 3x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 4x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 5x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 6x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 7x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 8x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 9x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 10x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 11x', 'tax' => 0.00],
            ['name' => 'Cartão de Crédito 12x', 'tax' => 0.00],
            ['name' => 'Cartão de Débito', 'tax' => 0.00]
        ]);
    }
}
