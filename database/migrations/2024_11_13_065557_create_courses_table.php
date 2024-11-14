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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('title')->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('vacancies')->default(0);
            $table->bigInteger('updated_by')->nullable();
            $table->decimal('price', total: 8, places: 2)->nullable();
            $table->json('materials')->nullable();
            $table->timestamp('date_ini')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->timestamps();
           
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
