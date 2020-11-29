<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_menus', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable(false);
            $table->string('sub_title')->nullable(false);
            $table->string('icon')->nullable(false);
            $table->string('color');
            $table->string('next_format')->nullable(false);
            $table->string('slag')->nullable(false);
            $table->unsignedTinyInteger('status')->nullable(false)->default(0);
            $table->unsignedSmallInteger('sort')->nullable(false)->default(0);

            $table->unsignedBigInteger('category_id')->nullable();

            $table->unique(['category_id', 'title']);

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
        Schema::dropIfExists('app_menus');
    }
}
