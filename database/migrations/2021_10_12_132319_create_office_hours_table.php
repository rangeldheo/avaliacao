<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_hours', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('professional_id');
            $table->foreign('professional_id')
                ->references('id')
                ->on('professionals')
                ->onDelete('cascade');

            $table->integer('week_day')->comment('Dias da semana');

            $table->time('start')->comment('Inicio expediente');
            $table->time('end')->comment('Final do expediente');
            $table->time('start_interval')->comment('Iniciao do intervalo')->nullable();
            $table->time('end_interval')->comment('Final do intervalo')->nullable();

            $table->text('observation')->comment('Anotações para os clientes sobre dias bloqueados, feriados,etc..')->nullable();;
            $table->boolean('status')->default(0)->comment('Situação do dia: aberto, bloqueado, feriado');
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
        Schema::dropIfExists('office_hours');
    }
}