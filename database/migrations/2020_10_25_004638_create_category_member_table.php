<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_member', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->nullable(false)->index();

            $table->unsignedBigInteger('member_id')->nullable(false)->index();

            $table->date('expired_at')->nullable(false);

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
        Schema::dropIfExists('category_member');
    }
}
