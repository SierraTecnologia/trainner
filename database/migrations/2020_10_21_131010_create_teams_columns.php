<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {







        // Schema::table(
        //     'computers', function (Blueprint $table) {
        //         $table->integer('team_id')->unsigned()->default(1)->nullable();
        //         $table->foreign('team_id')
        //             ->references('id')
        //             ->on(\Config::get('teamwork.teams_table'))
        //             ->onDelete('cascade');
        //     }
        // );
        Schema::table(
            'groups', function (Blueprint $table) {
                $table->integer('team_id')->unsigned()->default(1);
                $table->foreign('team_id')
                    ->references('id')
                    ->on(\Config::get('teamwork.teams_table'))
                    ->onDelete('cascade');
            }
        );
        Schema::table(
            'videos', function (Blueprint $table) {
                $table->integer('team_id')->unsigned()->default(1)->nullable();
                $table->foreign('team_id')
                    ->references('id')
                    ->on(\Config::get('teamwork.teams_table'))
                    ->onDelete('cascade');
            }
        );
        Schema::table(
            'playlists', function (Blueprint $table) {
                $table->integer('team_id')->unsigned()->default(1);
                $table->foreign('team_id')
                    ->references('id')
                    ->on(\Config::get('teamwork.teams_table'))
                    ->onDelete('cascade');
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
        Schema::table(
            'computers', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
            }
        );

        Schema::table(
            'computers', function (Blueprint $table) {
                $table->bigInteger('team_id')->change();
            }
        );
        Schema::table(
            'groups', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
            }
        );

        Schema::table(
            'groups', function (Blueprint $table) {
                $table->bigInteger('team_id')->change();
            }
        );
        Schema::table(
            'videos', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
            }
        );

        Schema::table(
            'videos', function (Blueprint $table) {
                $table->bigInteger('team_id')->change();
            }
        );
        Schema::table(
            'playlists', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
            }
        );

        Schema::table(
            'playlists', function (Blueprint $table) {
                $table->bigInteger('team_id')->change();
            }
        );
    }
}
