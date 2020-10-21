<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePractiseNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practise_notes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')->nullable()->index();

            $table->unsignedBigInteger('category_id')->nullable(false)->index();

            $table->unsignedBigInteger('question_id')->nullable(false)->index();

            $table->text('notes')->nullable();

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
        Schema::dropIfExists('practise_notes');
    }
}
