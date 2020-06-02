<?php

use Illuminate\Database\Seeder;

//incluo o User
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //para inserir usuário uso o método create
    	User::create([

    			'name'		=>		'Wend',
    			'email'		=>		'wwendel@live.com',
    			'password'	=>		bcrypt('23456'),

    	]);
    }
}
