<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     * nullable付けて問題ないか
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->string('category');
            $table->string('title');
            $table->foreignId('public_category_id')->constrained('public_categories')->nullable()->default(null);
            $table->foreignId('private_category_id')->constrained('private_categories')->nullable()->default(null);
            $table->dateTime('limit')->nullable()->default(null);
            $table->boolean('is_done')->nullable()->default(null);
            $table->boolean('is_private');
            $table->integer('like')->nullable()->default(null);
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
        Schema::dropIfExists('targets');
    }
}
