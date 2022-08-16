<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained('targets');
            $table->string('title');
            $table->text('first_knowledge');
            $table->text('memo')->nullable()->default(null);
            $table->integer('review_number')->nullable()->default(null);
            $table->integer('priority')->nullable()->default(null);
            $table->boolean('is_done')->nullable()->default(null);
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
        Schema::dropIfExists('books');
    }
}
