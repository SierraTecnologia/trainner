<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTrainningTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        /**
         * Skills
         */
        Schema::create(
            'conteudos', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('code')->unique();
                $table->primary('code');
                $table->string('name', 255)->nullable();
                $table->string('description', 255)->nullable();
                $table->integer('status')->default(1);
                $table->string('conteudo_code')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
        Schema::create(
            'conteudoables', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('valor', 255)->nullable();
                $table->string('conteudoable_id')->nullable();
                $table->string('conteudoable_type', 255)->nullable();
                $table->string('conteudo_code');
                $table->foreign('conteudo_code')->references('code')->on('skills');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('skillables');
        Schema::dropIfExists('skills');
    }

}
