<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateTrainnerAlunosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'trainners', function (Blueprint $table) {
                $table->string('code')->unique();                                                                                                                                                                      
                $table->primary('code'); 
                $table->string('code_top');
                $table->string('code_bot');

                $table->date('init_at')->nullable();

                $table->timestamps();
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
        Schema::dropIfExists('bots');
    }
}
