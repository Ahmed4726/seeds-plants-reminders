<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //     public function up()
    // {

    // }
    public function up()
    {
        
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->dateTime('start_from_date');
            $table->string('name');
            $table->timestamps();
        });


        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->string('name');
            $table->integer('days_from_start');
            $table->boolean('reminder')->default(false);
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
