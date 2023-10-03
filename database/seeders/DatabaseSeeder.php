<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
             'password' => bcrypt('123456')
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
    }
}
