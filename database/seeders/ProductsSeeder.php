<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder {
    public function run(): void {
        $data = [
            ['sku'=>'REP-001','name'=>'Filtro aceite','price'=>15,'stock'=>50],
            ['sku'=>'REP-002','name'=>'Batería moto','price'=>45,'stock'=>20],
            ['sku'=>'REP-003','name'=>'Pastillas freno','price'=>25,'stock'=>80],
            ['sku'=>'REP-004','name'=>'Aceite motor 10W40','price'=>30,'stock'=>60],
            ['sku'=>'REP-005','name'=>'Bujía estándar','price'=>8,'stock'=>200],
        ];
        foreach ($data as $d) {
            Product::firstOrCreate(['sku'=>$d['sku']], $d);
        }
    }
}