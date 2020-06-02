<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            //declaro um novo item da tabela para chave estrangeira
            $table->integer('category_id')->unsigned();
            //declaro a chave estrangeira
            $table->foreign('category_id')
            //coluna q a chave estrangeira esta se referindo
                        ->references('id')
            //qual tabela 
                        ->on('categories')
            //o tipo que será deletado a linha da tabela
                        ->onDelete('cascade');
            //100 caracteres e unique de única
            $table->string('name', 100)->unique();
            //descrição que posso deixar o campo em branco com nullable()
            $table->text('description')->nullable();
            //opçãode imagem
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
