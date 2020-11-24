<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable(false);
            $table->unsignedInteger('price')->nullable(false);
            $table->unsignedInteger('period')->nullable(false)->default(1);
            $table->string('explain', 600)->nullable(false)->default('');

            $table->unsignedBigInteger('category_id')->nullable(false)->index();

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
        Schema::dropIfExists('packages');
    }
}
