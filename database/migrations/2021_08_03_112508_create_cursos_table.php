<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao');
            $table->string('image')->nullable();// Por que a imagem está como 'text"? Pois está passando somente o endereço da imagem e não a imagem em si.
            $table->enum('ativo', ['A' , 'I']);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voidf
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
