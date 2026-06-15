<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistance_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('scholarship_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('university_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('full_name');
            $table->string('email');
            $table->string('whatsapp')->nullable();
            $table->string('nationality')->nullable();
            $table->string('degree')->nullable(); // Bachelor, Master, PhD

            $table->string('status')->default('Pending');
            // Pending, Checking Documents, Missing Documents, Ready to Apply, Submitted, Completed, Rejected

            $table->text('student_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistance_requests');
    }
};