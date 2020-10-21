<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePractiseCollectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practise_collects', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')->nullable()->index();

            $table->unsignedBigInteger('category_id')->nullable(false)->index();

            $table->unsignedBigInteger('question_id')->nullable()->index();

            $table->unique(['member_id', 'category_id', 'question_id']);

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
        Schema::dropIfExists('practise_collects');
    }
}
