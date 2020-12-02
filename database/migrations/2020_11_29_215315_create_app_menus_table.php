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

            $table->string('title')->nullable(false)->unique();
            $table->string('sub_title')->nullable(false);
            $table->string('icon')->nullable(false);
            $table->string('color')->nullable();
            $table->string('slug')->nullable(false);
            $table->unsignedTinyInteger('status')->nullable(false)->default(0);
            $table->unsignedTinyInteger('sub_lock')->nullable(false)->default(0);

            $table->nestedSet();
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
