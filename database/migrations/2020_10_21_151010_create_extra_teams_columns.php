<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExtraTeamsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table(
            \Config::get('teamwork.teams_table'), function (Blueprint $table) {
                $table->string('fantasia')->nullable();
                $table->string('cnpj')->nullable();
                $table->string('cep')->nullable();
                $table->string('rua')->nullable();
                $table->string('bairro')->nullable();
                $table->string('cidade')->nullable();
                $table->string('estado')->nullable();
                $table->string('telefone_1')->nullable();
                $table->string('telefone_2')->nullable();
                $table->string('telefone_3')->nullable();
                $table->string('email_1')->nullable();
                $table->string('email_2')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
