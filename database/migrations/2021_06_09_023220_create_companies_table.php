<?php

use Egulias\EmailValidator\Warning\Comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('user_id');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            //dados da empresa
            $table->string('corporate_name',255)->comment('Nome da empresa');
            $table->string('corporate_doc',255)->unique()->comment('documento oficial da empresa. No Brasil CNPJ');
            $table->string('manager',255)->comment('Responsável pela empresa na plataforma');
            $table->boolean('status')->comment('Status da empresa')->default(0);
            $table->string('mobile_phone',20)->nullable()->comment('Telefone móvel');
            $table->string('web_site',255)->nullable()->comment('site da empresa');
            //endereço da empresa
            $table->string('zipcode',25)->comment('No Brasil CEP');
            $table->string('street',80)->comment('Numero');
            $table->string('complement',80)->comment('Complemento')->nullable();
            $table->string('number',10)->comment('Rua');
            $table->string('district',25)->comment('Bairro');
            $table->string('city',255)->comment('Cidade');
            $table->string('state',80)->comment('Cidade');
            $table->string('country',80)->comment('País');
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
        Schema::dropIfExists('companies');
    }
}
