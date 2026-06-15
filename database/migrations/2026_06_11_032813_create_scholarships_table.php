<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('university_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title'); // KNB Scholarship
            $table->string('degree'); // Bachelor, Master, PhD, Non-degree
            $table->string('funding_type')->nullable(); // Fully Funded, Partial
            $table->date('open_date')->nullable();
            $table->date('deadline')->nullable();

            $table->string('official_link'); // رابط التقديم الرسمي
            $table->string('source_link')->nullable(); // رابط مصدر المعلومة

            $table->text('description')->nullable();
            $table->text('eligibility')->nullable(); // الشروط
            $table->text('required_documents')->nullable(); // الملفات المطلوبة

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};