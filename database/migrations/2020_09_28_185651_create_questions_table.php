<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->text('title')->nullable(false);
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('difficulty')->nullable(false)->default(0);
            $table->unsignedSmallInteger('pattern')->nullable(false);

            $table->string('option_answer')->nullable();
            $table->string('right_answer')->nullable();
            $table->string('analysis')->nullable();

            $table->unsignedMediumInteger('category_id')->nullable(false)->index();

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
        Schema::dropIfExists('questions');
    }
}
