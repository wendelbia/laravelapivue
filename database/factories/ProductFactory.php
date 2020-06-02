<?php

use Faker\Generator as Faker;
use App\Models\Product;
//passo a model
$factory->define(Product::class, function (Faker $faker) {
    return [

 		//inserindo mais esse item após fazer a relação entre tabelas
 		//além disso para não dar erro, pois todos os dados seriam cadastrados no id 1, teremos q fazer uma seeds para category_id
 		'category_id' => 1,
        //aqui coloco os valores q quero q preencha
        //faker é o objeto de Faker e word a palavra q será gerada e unique vl único 
        'name' => $faker->unique()->word,
        //sentence palavra maior q word
        'description' => $faker->sentence(),
        

        //temos q ter um seeders para isso
    ];
});
