<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCycletasksTable extends Migration
{
    public function up()
    {
        Schema::create('cycletasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('days_from_start');
            $table->boolean('reminder')->default(false);
            $table->timestamps();

            // $table->foreign('cycle_id')->references('id')->on('cycles')->onDelete('cascade');
        });

        Schema::create('cycletask_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_task_id')->constrained('cycletasks')->onDelete('cascade');
            $table->text('note');
            $table->timestamps();
        });

        Schema::create('cycletask_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_task_id')->constrained('cycletasks')->onDelete('cascade');
            $table->string('tag');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cycletask_notes');
        Schema::dropIfExists('cycletask_tags');
        Schema::dropIfExists('cycletasks');
    }
}
