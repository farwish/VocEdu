<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->unsignedTinyInteger('status')->nullable(false)->default(0);
            $table->unsignedBigInteger('paper_id')->index();

            $table->string('area')->nullable();

            $table->unsignedBigInteger('guide_id')->nullable();
            $table->unsignedBigInteger('outline_id')->nullable();

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
        Schema::dropIfExists('exams');
    }
}
