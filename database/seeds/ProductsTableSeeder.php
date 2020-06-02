<?php

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //chamo o factory passo o modelo q qero trabalhar e a quantidade que quero inserir
        factory(Product::class, 50)->create();
        //vou no database seeder
    }
}
