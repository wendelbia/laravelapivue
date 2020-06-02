<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	//mudo colocando em array para incluir o factory
        //$this->call(UsersTableSeeder::class);
        $this->call([
        		//UsersTableSeeder::class,
        		ProductsTableSeeder::class,
        		CategoriesTableSeeder::class,
        ]); 
        //e rodo o db:seed especificando qual seed qero rodar para não dar erro
    }
}
