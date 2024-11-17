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
        Schema::create('buyings', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('cpf')->nullable();
            $table->string('phone')->nullable();
            $table->string('customer_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->enum('status', ['pending', 'sent', 'payment_created', 'failed'])->default('pending');
            $table->string('payment_id')->nullable();
            $table->text('pix_qr_code')->nullable();
            $table->text('pix_qr_code_url')->nullable();
            $table->json('request')->nullable();
            $table->json('error_reponse')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyings');
    }
};
