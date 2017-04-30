<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tasks', function (Blueprint $table) {
          $table->increments('id');
          $table->string('texto');
          $table->enum('estado',['Pendiente','En proceso','Completada'])->default('Pendiente');
          $table->integer('user-id')->unsigned();
          $table->timestamp('created_at')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
