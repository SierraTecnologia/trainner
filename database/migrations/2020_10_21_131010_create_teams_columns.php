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







        if (Schema::hasTable('computers')) {
            Schema::table(
                'computers',
                function (Blueprint $table) {
                    $table->integer('team_id')->unsigned()->default(1)->nullable();
                    $table->foreign('team_id')
                        ->references('id')
                        ->on(\Config::get('teamwork.teams_table', 'teams'))
                        ->onDelete('cascade');
                }
            );
        }
        if (Schema::hasTable('groups')) {
            Schema::table(
                'groups',
                function (Blueprint $table) {
                    $table->integer('team_id')->unsigned()->default(1);
                    $table->foreign('team_id')
                        ->references('id')
                        ->on(\Config::get('teamwork.teams_table', 'teams'))
                        ->onDelete('cascade');
                }
            );
        }
        if (Schema::hasTable('videos')) {
            Schema::table(
                'videos',
                function (Blueprint $table) {
                    $table->integer('team_id')->unsigned()->default(1)->nullable();
                    $table->foreign('team_id')
                        ->references('id')
                        ->on(\Config::get('teamwork.teams_table', 'teams'))
                        ->onDelete('cascade');
                }
            );
        }
        if (Schema::hasTable('playlists')) {
            Schema::table(
                'playlists',
                function (Blueprint $table) {
                    $table->integer('team_id')->unsigned()->default(1);
                    $table->foreign('team_id')
                        ->references('id')
                        ->on(\Config::get('teamwork.teams_table', 'teams'))
                        ->onDelete('cascade');
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('computers')) {
            Schema::table(
                'computers',
                function (Blueprint $table) {
                    $table->dropForeign(['team_id']);
                }
            );
        }
        if (Schema::hasTable('computers')) {
            Schema::table(
                'computers',
                function (Blueprint $table) {
                    $table->bigInteger('team_id')->change();
                }
            );
        }
        if (Schema::hasTable('groups')) {
            Schema::table(
                'groups',
                function (Blueprint $table) {
                    $table->dropForeign(['team_id']);
                }
            );
        }
        if (Schema::hasTable('groups')) {
            Schema::table(
                'groups',
                function (Blueprint $table) {
                    $table->bigInteger('team_id')->change();
                }
            );
        }
        if (Schema::hasTable('videos')) {
            Schema::table(
                'videos',
                function (Blueprint $table) {
                    $table->dropForeign(['team_id']);
                }
            );
        }
        if (Schema::hasTable('videos')) {
            Schema::table(
                'videos',
                function (Blueprint $table) {
                    $table->bigInteger('team_id')->change();
                }
            );
        }
        if (Schema::hasTable('playlists')) {
            Schema::table(
                'playlists',
                function (Blueprint $table) {
                    $table->dropForeign(['team_id']);
                }
            );
        }
        if (Schema::hasTable('playlists')) {
            Schema::table(
                'playlists',
                function (Blueprint $table) {
                    $table->bigInteger('team_id')->change();
                }
            );
        }
    }
}
