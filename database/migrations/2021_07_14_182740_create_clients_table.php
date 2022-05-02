<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('mobile_phone', 20)->unique()->nullable()->comment('Telefone móvel');
            $table->string('document', 255)->unique()->comment('documento oficial. No Brasil CPF');
            $table->string('nickname', 80)->comment('Apelido');

            //endereço do cliente
            $table->string('zipcode', 25)->comment('No Brasil CEP');
            $table->string('street', 80)->comment('Numero');
            $table->string('complement', 80)->comment('Complemento')->nullable();
            $table->string('number', 10)->comment('Rua');
            $table->string('district', 25)->comment('Bairro');
            $table->string('city', 255)->comment('Cidade');
            $table->string('state', 80)->comment('Cidade');
            $table->string('country', 80)->comment('País');
            // situação do cadastro do cliente
            $table->boolean('status')->comment('Status do cadastro')->default(0);
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
        Schema::dropIfExists('clients');
    }
}
