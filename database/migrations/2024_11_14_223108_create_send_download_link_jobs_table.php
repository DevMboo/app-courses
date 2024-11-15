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
        Schema::create('send_download_link_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('file_path')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('date_process')->nullable();
            $table->string('send_type');
            $table->json('error_message')->nullable();
            $table->string('email_template');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_download_link_jobs');
    }
};
