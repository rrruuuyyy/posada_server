<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->double('cantidad');
            //Las claves foraneas
            $table->integer('empresa_id')->unsigned();
            $table->integer('subcategoria_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
			$table->foreign('subcategoria_id')->references('id')->on('subcategorias');
			$table->foreign('empresa_id')->references('id')->on('empresas');
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
        Schema::dropIfExists('ingresos');
    }
}
