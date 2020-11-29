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
            $table->string('explain', 600)->nullable(false)->default('');
            $table->unsignedInteger('price')->nullable(false);
            $table->unsignedInteger('ori_price')->nullable();

            $table->unsignedTinyInteger('expire_mode')->nullable(false)->default(0);
            $table->unsignedInteger('duration')->nullable();

            $table->unsignedTinyInteger('list_status')->nullable(false)->default(1);
            $table->timestamp('list_on_datetime')->nullable();
            $table->timestamp('list_off_datetime')->nullable();

            $table->unsignedBigInteger('sort')->nullable(false)->default(0);

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
