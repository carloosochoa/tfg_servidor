<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ejercicios_rutinas', function(Blueprint $table){
            $table->id();

            $table->unsignedBigInteger('routine_id');
            $table->foreign('routine_id')->references('id')->on('rutinas');

            $table->unsignedBigInteger('exercise_id');
            $table->foreign('exercise_id')->references('id')->on('ejercicios');

            $table->integer('sets');
            $table->integer('reps');
            $table->float('weight')->nullable();

            

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
