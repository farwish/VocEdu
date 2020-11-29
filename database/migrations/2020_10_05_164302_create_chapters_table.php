<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable(false);
            $table->unsignedTinyInteger('status')->nullable(false)->default(0);
            $table->unsignedTinyInteger('sub_lock')->nullable(false)->default(0);
            $table->unsignedInteger('free_question_num')->nullable(false)->default(0);
            $table->unsignedBigInteger('category_id')->nullable(false)->index();

            $table->nestedSet();

            $table->unique(['category_id', 'parent_id', 'name']);

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
        Schema::dropIfExists('chapters');
    }
}
