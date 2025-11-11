<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Llanta Michelin 17"', 'sku' => 'MIC17', 'price' => 1200, 'stock' => 8, 'category_id' => 1],
            ['name' => 'Llanta Pirelli 16"', 'sku' => 'PIR16', 'price' => 950, 'stock' => 12, 'category_id' => 1],
            ['name' => 'Pastillas de freno Honda', 'sku' => 'FRHON', 'price' => 350, 'stock' => 20, 'category_id' => 2],
            ['name' => 'Filtro de aceite Yamaha', 'sku' => 'FILTROYA', 'price' => 180, 'stock' => 15, 'category_id' => 2],
            ['name' => 'Bujía NGK', 'sku' => 'BUJNGK', 'price' => 90, 'stock' => 40, 'category_id' => 2],
            ['name' => 'Aceite Motul 10W40', 'sku' => 'ACEITEMOT', 'price' => 260, 'stock' => 25, 'category_id' => 3],
            ['name' => 'Refrigerante Prestone', 'sku' => 'REFPRE', 'price' => 210, 'stock' => 18, 'category_id' => 3],
            ['name' => 'Cadena DID 428', 'sku' => 'CAD428', 'price' => 420, 'stock' => 10, 'category_id' => 2],
            ['name' => 'Llanta Dunlop 18"', 'sku' => 'DUN18', 'price' => 1100, 'stock' => 7, 'category_id' => 1],
            ['name' => 'Liquido de frenos DOT4', 'sku' => 'LIQDOT4', 'price' => 75, 'stock' => 30, 'category_id' => 3],
        ];

        foreach ($products as $data) {
            Product::firstOrCreate(
                ['sku' => $data['sku']],
                $data
            );
        }
    }
}