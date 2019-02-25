<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('usuarios', function (Blueprint $table) {
        $table->increments('id');
        $table->string('role', 20);
        $table->string('nombre', 30);
        $table->string('apellido', 30);
        $table->string('email', 255);
        $table->string('password', 255);
        $table->string('remeber_token', 255);
        $table->timestamp('created_at')->nullable($value = true);
        $table->timestamp('updated_at')->nullable($value = true);
    });
    Schema::create('coches', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned();
        $table->string('titulo', 255);
        $table->text('descripcion');
        $table->decimal('precio', 10, 2);
        $table->string('status', 255);
        $table->unique('user_id');
        $table->timestamp('created_at')->nullable($value = true);
        $table->timestamp('updated_at')->nullable($value = true);
        $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('cascade');

    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
