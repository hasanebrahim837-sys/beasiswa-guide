<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assistance_request_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('document_type'); 
            // Passport, Certificate, Transcript, CV, Motivation Letter

            $table->string('file_path');
            $table->string('original_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};