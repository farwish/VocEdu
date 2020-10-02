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

            $table->string('title')->nullable(false);
            $table->unsignedTinyInteger('difficulty')->nullable(false)->default(0);

            $table->unsignedMediumInteger('category_id')->nullable(false);
            $table->unsignedSmallInteger('pattern_id')->nullable(false);

            $table->string('option_answer')->nullable();
            $table->unsignedBigInteger('right_answer')->nullable(false);
            $table->string('analysis')->nullable();

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
