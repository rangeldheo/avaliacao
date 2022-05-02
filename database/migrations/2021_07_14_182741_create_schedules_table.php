<?php

use App\Alias\ScheduleAlias;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ScheduleAlias::TABLE, function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('professional_id');
            $table->foreign('professional_id')
                ->references('id')
                ->on('professionals')
                ->onDelete('cascade');

            $table->uuid('client_id');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->timestamp('start_service')->comment('Data e hora prevista de início do serviço');
            $table->timestamp('end_service')->comment('Data e hora do prevista final do serviço');
            $table->timestamp('real_start_service')->comment('Data e hora de início do serviço')->nullable();
            $table->timestamp('real_end_service')->comment('Data e hora do final do serviço')->nullable();

            $table->boolean('status')->default(0)->comment('Situação do serviço: agendado, atendendo, cancelado, reagendado, concluído');

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
        Schema::dropIfExists(ScheduleAlias::TABLE);
    }
}
