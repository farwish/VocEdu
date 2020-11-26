<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_tab', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('package_id')->nullable(false)->index();
            $table->unsignedBigInteger('tab_id')->nullable(false)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_tab');
    }
}
